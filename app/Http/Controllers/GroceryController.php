<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Grocery;
use App\Models\RecipeGrocery;
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
            'default_proteins' => $request->proteins,
            'default_carbons' => $request->carbons,
            'default_fats' => $request->fats,
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

        $allRecipeGrocery = RecipeGrocery::where('name', $grocery->name)->get();

        foreach($allRecipeGrocery as $recipeGrocery){
            if($recipeGrocery){

                if ($trainer->id == $recipeGrocery->recipe->trainer->id){

                    $isCupByGlassPinchOrHandful = $request->unit == 'Glass' || $request->unit == 'Pinch' || $request->unit == 'Handful';
                    $newProteinValues = $isCupByGlassPinchOrHandful ? $recipeGrocery->unit_type * $request->proteins : ($recipeGrocery->unit_type * $request->proteins) / 100;
                    $newCarbonValues = $isCupByGlassPinchOrHandful ? $recipeGrocery->unit_type * $request->carbons : ($recipeGrocery->unit_type * $request->carbons) / 100;
                    $newFatValues = $isCupByGlassPinchOrHandful ? $recipeGrocery->unit_type * $request->fats : ($recipeGrocery->unit_type * $request->fats) / 100;

                    $recipeGrocery->name = $request->name;
                    if($recipeGrocery->unit != $request->unit){
                        $recipeGrocery->unit = $request->unit;
                        $recipeGrocery->unit_type = $request->unitType;
                        $recipeGrocery->proteins = $request->proteins;
                        $recipeGrocery->carbons = $request->carbons;
                        $recipeGrocery->fats = $request->fats;
                        $recipeGrocery->calories = $request->calories;
                        $recipeGrocery->default_proteins = $request->proteins;
                        $recipeGrocery->default_carbons = $request->carbons;
                        $recipeGrocery->default_fats = $request->fats;
                    } else {
                        $recipeGrocery->proteins = $newProteinValues;
                        $recipeGrocery->carbons = $newCarbonValues;
                        $recipeGrocery->fats = $newFatValues;
                        $recipeGrocery->calories = $newProteinValues * 4 + $newCarbonValues * 4 + $newFatValues * 9;
                        $recipeGrocery->default_proteins = $request->proteins;
                        $recipeGrocery->default_carbons = $request->carbons;
                        $recipeGrocery->default_fats = $request->fats;
                    }
                    $recipeGrocery->save();
                }
            }
        }

        $grocery->name = $request->name;
        $grocery->unit = $request->unit;
        $grocery->unit_type = $request->unitType;
        $grocery->proteins = $request->proteins;
        $grocery->carbons = $request->carbons;
        $grocery->fats = $request->fats;
        $grocery->calories = $request->calories;
        $grocery->default_proteins = $request->proteins;
        $grocery->default_carbons = $request->carbons;
        $grocery->default_fats = $request->fats;
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
        $trainer = auth('api-trainer')->user();
        $grocery = Grocery::where('trainer_id', $trainer->id)->where('id', $id)->first();
        $allRecipeGrocery = RecipeGrocery::where('name', $grocery->name)->get();

        foreach($allRecipeGrocery as $recipeGrocery){
            if($recipeGrocery)
                if ($trainer->id == $recipeGrocery->recipe->trainer->id)
                    $recipeGrocery->delete();
        }        

        $grocery->delete();

        return $this->index();
    }
}
