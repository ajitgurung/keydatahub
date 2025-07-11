<?php

namespace App\Http\Controllers;

use App\Models\Make;
use App\models\Model;
use App\models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $years = Year::all();
        return view('years.index', compact('years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $makes = Make::all();
        return view('years.create', compact('makes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'model_id' => 'required|exists:models,id',
            'year' => 'required',
        ]);

        $years = explode(',', $request->year);
        foreach ($years as $year) {
            $cleanYear = trim($year);
            if ($cleanYear) {
                Year::firstOrCreate([
                    'model_id' => $request->model_id,
                    'year' => $cleanYear
                ]);
            }
        }

        $years = Year::all();

        return redirect()->route('years.index', compact('years'))->with('success', 'Year added successfully.');
    }

    public function getModels($makeId)
    {
        $models = Model::where('make_id', $makeId)->get();
        return response()->json($models);
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
        $year = Year::findOrFail($id);
        $makes = Make::all();

        return view('years.edit', compact('year', 'makes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'model_id' => 'required|exists:models,id',
            'year' => 'required',
        ]);

        $year = Year::findOrFail($id);
        $year->year = $request->input('year');
        $year->model_id = $request->input('model_id');

        $year->save();

        return redirect()->route('years.index')->with('success', 'Year updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $year = Year::findOrFail($id);


        $year->delete();

        return redirect()->route('years.index')->with('success', 'Year deleted successfully.');
    }
}
