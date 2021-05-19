<?php

namespace App\Http\Controllers;

use App\Models\DailyMeal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\DailyRecipeGrocery;
use DB;

class DailyMealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->show($request->clientId, Carbon::parse($request->date));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function recipeCreate(Request $request)
    {
        $clientId = $request->clientId;
        $date = Carbon::parse($request->date);
        $dailyMealId = $request->dailyMealId;

        DB::table('dailymeals_recipes')->insert([
            'dailymeal_id' => $dailyMealId,
            'recipe_id' => $request->recipeId
        ]);

        foreach($request->dailyRecipeGroceries as $grocery){
            DailyRecipeGrocery::create([
                'recipe_id' => $request->recipeId,
                'name' => $grocery['name'],
                'unit' => $grocery['unit'],
                'unit_type' => $grocery['unit_type'],
                'proteins' => $grocery['proteins'],
                'carbons' => $grocery['carbons'],
                'fats' => $grocery['fats'],
                'calories' => $grocery['calories'],
                'default_proteins' => $grocery['default_proteins'],
                'default_carbons' => $grocery['default_carbons'],
                'default_fats' => $grocery['default_fats'],
                'daily_meal' => $dailyMealId,
            ]);
        }

        return $this->show($clientId, Carbon::parse($date));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DailyMeal::create([
            'client_id' => $request->clientId,
            'name' => $request->name,
            'date' => Carbon::parse($request->date)
        ]);

        return $this->show($request->clientId, Carbon::parse($request->date));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyMeal  $dailyMeal
     * @return \Illuminate\Http\Response
     */
    public function show($clientId, $date)
    {
        $dailyMeals = DailyMeal::where('client_id', $clientId)->where('date', Carbon::parse($date))->get();

        foreach($dailyMeals as $meal){
            $meal->dailyMealRecipes;
            foreach($meal->dailyMealRecipes as $recipe){
                if($recipe->recipe_image_url != '0' && $recipe->recipe_image_url != '1' && $recipe->recipe_image_url != '2')
                $recipe->recipe_image_url = storage_path('app/public/RecipeImage/' . $recipe->recipe_image_url);
                $recipe['daily_recipe_groceries'] = DailyRecipeGrocery::where('daily_meal', $meal->id)->where('recipe_id', $recipe->id)->get();
            }
        }

        return response()->json($dailyMeals);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyMeal  $dailyMeal
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyMeal $dailyMeal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyMeal  $dailyMeal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $recipe = DailyRecipeGrocery::where('daily_meal', $request->dailyMealId)->where('recipe_id', $id)->delete();


        foreach($request->dailyRecipeGroceries as $grocery){
            DailyRecipeGrocery::create([
                'recipe_id' => $id,
                'name' => $grocery['name'],
                'unit' => $grocery['unit'],
                'unit_type' => $grocery['unit_type'],
                'proteins' => $grocery['proteins'],
                'carbons' => $grocery['carbons'],
                'fats' => $grocery['fats'],
                'calories' => $grocery['calories'],
                'daily_meal' => $request->dailyMealId,
            ]);
        }


        return $this->show($request->clientId, Carbon::parse($request->date));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyMeal  $dailyMeal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        DailyRecipeGrocery::where('daily_meal', $id)->delete();
        DB::table('dailymeals_recipes')->where('dailymeal_id', $id)->delete();
        DailyMeal::find($id)->delete();

        return $this->show($request->clientId, Carbon::parse($request->date));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function recipeDestroy(Request $request, $id)
    {
        $mealId = $request->dailyMealId;
        $clientId = $request->clientId;
        $date = $request->date;

        DailyRecipeGrocery::where('daily_meal', $mealId)->where('recipe_id', $id)->delete();
        DB::table('dailymeals_recipes')->where('dailymeal_id', $mealId)->where('recipe_id', $id)->delete();

        return $this->show($clientId, Carbon::parse($date));
    }
}
