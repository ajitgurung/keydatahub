<?php

namespace App\Http\Controllers;

use App\Models\Make;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $makes = Make::paginate(10);
        return view('makes.index', compact('makes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('makes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:makes,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('makeimgs', 'public');
        }

        Make::firstOrCreate([
            'name' => $request->name,
            'image' => $path
        ]);

        return redirect()->route('makes.index')->with('success', 'Make added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $make = Make::findOrFail($id);

        return view('makes.edit', compact('make'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $make = Make::findOrFail($id);
        $make->name = $request->input('name');

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($make->image && Storage::disk('public')->exists($make->image)) {
                Storage::disk('public')->delete($make->image);
            }

            // Store new image
            $path = $request->file('image')->store('makeimgs', 'public');
            $make->image = $path;
        }

        $make->save();

        return redirect()->route('makes.index')->with('success', 'Make updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $make = Make::findOrFail($id);

        // Delete image if it exists
        if ($make->image && Storage::disk('public')->exists($make->image)) {
            Storage::disk('public')->delete($make->image);
        }

        $make->delete();

        return redirect()->route('makes.index')->with('success', 'Make deleted successfully.');
    }
}
