<?php

namespace App\Http\Controllers;

use App\Models\TrainerRecipe;
use App\Models\Trainer;
use Illuminate\Http\Request;


class TrainerRecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $trainer = auth('api-trainer')->user();
        $trainer = Trainer::find(1);

        return response()->json($trainer->recipies);
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
        $input = $request->all(); 
        $recipe = TrainerRecipe::create($input);

        return response()->json($recipe);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainerRecipe  $trainerRecipe
     * @return \Illuminate\Http\Response
     */
    public function show(TrainerRecipe $trainerRecipe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainerRecipe  $trainerRecipe
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainerRecipe $trainerRecipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrainerRecipe  $trainerRecipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainerRecipe $trainerRecipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainerRecipe  $trainerRecipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainerRecipe $trainerRecipe)
    {
        //
    }
}
