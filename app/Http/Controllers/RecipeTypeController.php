<?php

namespace App\Http\Controllers;

use App\Models\RecipeType;
use App\Models\Trainer;
use Illuminate\Http\Request;

class RecipeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('api-trainer')->user();

        $trainerRecipeTypes = [];
        $recipes = Trainer::find(1)->recipeTypes->toArray();
        if($user->id != 1)
            $trainerRecipeTypes = Trainer::find($user->id)->recipeTypes->toArray();
        $response = array_merge($recipes, $trainerRecipeTypes);

        return response()->json($response);
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
        $recipeType = RecipeType::create([
            'trainer_id' => $request->trainerId,
            'name' => $request->name
        ]);

        return response('nije isprobano, samo je napravljen kontroler');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RecipeType  $recipeType
     * @return \Illuminate\Http\Response
     */
    public function show(RecipeType $recipeType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RecipeType  $recipeType
     * @return \Illuminate\Http\Response
     */
    public function edit(RecipeType $recipeType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RecipeType  $recipeType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RecipeType $recipeType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecipeType  $recipeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecipeType $recipeType)
    {
        //
    }
}
