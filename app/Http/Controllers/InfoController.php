<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\Make;
use App\Models\Model;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infos = Info::paginate(10);
        return view('infos.index', compact('infos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $makes = Make::all();
        return view('infos.create', compact('makes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'year_id' => 'required|exists:years,id',
            'sections' => 'required|array',
            'image' => 'image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048'
        ]);

        // Check if an info already exists for this year_id
        if (Info::where('year_id', $request->year_id)->exists()) {
            return redirect()->back()->withErrors(['year_id' => 'Info already exists for this year.']);
        }

        $infoData = [];

        foreach ($request->sections as $section) {
            $title = $section['title'];
            $keys = $section['keys'];
            $values = $section['values'];

            $sectionData = [];

            foreach ($keys as $index => $key) {
                $key = trim($key);
                $value = trim($values[$index] ?? '');
                if ($key !== '') {
                    $sectionData[$key] = $value;
                }
            }

            $infoData[$title] = $sectionData;
        }

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('infos', 'public');
        }

        Info::create([
            'year_id' => $request->year_id,
            'info' => json_encode($infoData),
            'image' => $path ?? ''
        ]);

        return redirect()->route('infos.index')->with('success', 'Info stored successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $info = Info::with(['year.model.make'])->findOrFail($id);

        return response()->json([
            'make_name' => $info->year->model->make->name,
            'model_name' => $info->year->model->name,
            'year' => $info->year->year,
            'image' => $info->image,
            'info' => json_decode($info->info, true),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $info = Info::where('id', $id)->firstOrFail();

        return view('infos.edit', compact('info'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.title' => 'required|string',
            'sections.*.keys' => 'required|array',
            'sections.*.values' => 'required|array',
            'image' => 'nullable|image|max:2048', // Optional image upload
        ]);

        $info = Info::findOrFail($id);

        $infoData = [];

        foreach ($request->sections as $section) {
            $title = $section['title'];
            $keys = $section['keys'];
            $values = $section['values'];

            $paired = [];
            foreach ($keys as $index => $key) {
                $value = $values[$index] ?? null;
                if ($key) {
                    $paired[$key] = $value;
                }
            }

            $infoData[strtolower(str_replace(' ', '_', $title))] = $paired;
        }

        // Handle image if uploaded
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($info->image && Storage::disk('public')->exists($info->image)) {
                Storage::disk('public')->delete($info->image);
            }

            // Store new image
            $path = $request->file('image')->store('infos', 'public');
            $info->image = $path;
        }

        $info->info = json_encode($infoData);
        $info->save();

        return redirect()->route('infos.index')->with('success', 'Info updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $info = Info::findOrFail($id);

        // Delete image if it exists
        if ($info->image && Storage::disk('public')->exists($info->image)) {
            Storage::disk('public')->delete($info->image);
        }

        $info->delete();

        return redirect()->route('infos.index')->with('success', 'Info deleted successfully.');
    }

    public function getYears($modelId)
    {
        $years = Year::where('model_id', $modelId)->get();
        return response()->json($years);
    }
}
