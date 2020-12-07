<?php

namespace App\Http\Controllers;

use App\Models\Grocery;
use Illuminate\Http\Request;

class GroceryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainer = auth('api-trainer')->user();
        $groceries = Grocery::where('trainer_id', $trainer->id)->get();

        return response()->json($groceries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $trainer = auth('api-trainer')->user();

        Grocery::create([
            'trainer_id' => $trainer->id,
            'name' => $request->name,
            'unit' => $request->unit,
            'unit_type' => $request->unitType,
            'proteins' => $request->proteins,
            'carbons' => $request->carbons,
            'fats' => $request->fats,
            'calories' => $request->calories,
            'description' => $request->description
        ]);

        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grocery  $grocery
     * @return \Illuminate\Http\Response
     */
    public function show(Grocery $grocery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grocery  $grocery
     * @return \Illuminate\Http\Response
     */
    public function edit(Grocery $grocery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grocery  $grocery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $trainer = auth('api-trainer')->user();
        $grocery = Grocery::where('trainer_id', $trainer->id)->where('id', $id)->first();

        $grocery->name = $request->name;
        $grocery->unit = $request->unit;
        $grocery->unit_type = $request->unitType;
        $grocery->proteins = $request->proteins;
        $grocery->carbons = $request->carbons;
        $grocery->fats = $request->fats;
        $grocery->calories = $request->calories;
        $grocery->description = $request->description;
        $grocery->save();

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grocery  $grocery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grocery = Grocery::find($id);
        $grocery->delete();

        return $this->index();
    }
}
