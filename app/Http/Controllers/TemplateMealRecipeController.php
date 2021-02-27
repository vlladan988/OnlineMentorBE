<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateMeal;
use DB;

class TemplateMealRecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        DB::table('templatemeal_recipe')->insert([
            'recipe_id' => $request->recipeId,
            'meal_id' => $request->templateMealId
        ]);

        return $this->show($request->templateMealId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $templateMeal = TemplateMeal::find($id);

        $responseData = [];
        foreach($templateMeal->recipes as $recipe){
            $recipe->recipeGroceries;
                array_push($responseData, $recipe);
        }
        return response()->json($responseData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($recipeId, $mealId)
    {
        DB::table('templatemeal_recipe')->where('recipe_id', $recipeId)->where('meal_id', $mealId)->delete();
        return $this->show($mealId);
    }
}
