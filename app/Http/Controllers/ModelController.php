<?php

namespace App\Http\Controllers;

use App\Models\Make;
use App\Models\Model;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Model::all();
        return view('models.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $makes = Make::all();
        return view('models.create', compact('makes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'make_id' => 'required|exists:makes,id',
            'name' => 'required|unique:models,name',
        ]);

        $modelNames = explode(',', $request->name);
        foreach ($modelNames as $name) {
            $cleanName = trim($name);
            if ($cleanName) {
                Model::firstOrCreate([
                    'make_id' => $request->make_id,
                    'name' => $cleanName
                ]);
            }
        }

        $models = Model::all();

        return redirect()->route('models.index', compact('models'))->with('success', 'Model added successfully.');
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
        $model = Model::findOrFail($id);
        $makes = Make::all();

        return view('models.edit', compact('model', 'makes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'make_id' => 'required|exists:makes,id',
        ]);

        $model = Model::findOrFail($id);
        $model->name = $request->input('name');
        $model->make_id = $request->input('make_id');

        $model->save();

        return redirect()->route('models.index')->with('success', 'Model updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Model::findOrFail($id);


        $model->delete();

        return redirect()->route('models.index')->with('success', 'Model deleted successfully.');
    }
}
