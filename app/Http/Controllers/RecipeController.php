<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Trainer;
use App\Models\RecipeGrocery;
use App\Models\RecipeType;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $responseData = [];
        $user = auth('api-trainer')->user();
        $trainer = Trainer::find($user->id);
        $recepies = $trainer->recipies;

        foreach($recepies as $recipe){
            if($recipe->recipe_image_url != '0' && $recipe->recipe_image_url != '1' && $recipe->recipe_image_url != '2')
                $recipe->recipe_image_url = storage_path('app/public/RecipeImage/' . $recipe->recipe_image_url);
            $recipe->recipeGroceries;
            array_push($responseData, $recipe);
        }

        return response()->json($responseData);
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
        $recipeImage = $request->recipeImage;
        $allRecipeType = RecipeType::where('trainer_id', 1)->get();

        $types = [];
        foreach($allRecipeType as $item){
            array_push($types, $item->name);
        }

        if (!in_array($request->recipeType, $types)) {
            RecipeType::create([
                'trainer_id' => $trainer->id,
                'name' => $request->recipeType,
            ]);
        }

        if($request->isCustomImage){
            $image = str_replace('data:image/png;base64,', '', $recipeImage);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(15).'.'.'png';
            Storage::disk('local')->put("public/RecipeImage/" . $imageName, base64_decode($recipeImage));
            $recipeImage = $imageName;
        }
        $recipe = Recipe::create([
            'trainer_id' => $trainer->id,
            'name' => $request->name,
            'recipe_image_url' => $recipeImage,
            'recipe_type' => $request->recipeType,
            'recipe_description' => $request->description,
        ]);

        foreach($request->recipeGroceries as $grocery){
            RecipeGrocery::create([
                'recipe_id' => $recipe->id,
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
            ]);
        }

        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe, $id)
    {
        $trainer = auth('api-trainer')->user();
        $recipeImage = $request->recipeImage;
        $allRecipeType = RecipeType::where('trainer_id', 1)->get();

        $types = [];
        foreach($allRecipeType as $item){
            array_push($types, $item->name);
        }

        if (!in_array($request->recipeType, $types)) {
            RecipeType::create([
                'trainer_id' => $trainer->id,
                'name' => $request->recipeType,
            ]);
        }

        $recipe = Recipe::find($id);
        $recipe->name = $request->name;
        $recipe->recipe_type = $request->recipeType;
        $recipe->recipe_description = $request->description;

        if($request->isImageChanged){
            if($recipe->recipe_image_url != '0' && $recipe->recipe_image_url != '1' && $recipe->recipe_image_url != '2'){
                unlink(storage_path('app/public/RecipeImage/' . $recipe['recipe_image_url']));
            }
            if($request->isCustomImage){
                $image = str_replace('data:image/png;base64,', '', $recipeImage);
                $image = str_replace(' ', '+', $image);
                $imageName = str_random(15).'.'.'png';
                Storage::disk('local')->put("public/RecipeImage/" . $imageName, base64_decode($recipeImage));
                $recipeImage = $imageName;
            }
            $recipe->recipe_image_url = $recipeImage;
        }

        $recipe->save();

        foreach($recipe->recipeGroceries as $recipeGrocery){
            $recipeGrocery->delete();
        }

        foreach($request->recipeGroceries as $grocery){
            RecipeGrocery::create([
                'recipe_id' => $recipe->id,
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
            ]);
        }

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth('api-trainer')->user();
        $trainer = Trainer::find($user->id);
        $recipeToDelete = Recipe::where('trainer_id', $trainer->id)->where('id', $id)->first();

        if($recipeToDelete->recipe_image_url != '0' && $recipeToDelete->recipe_image_url != '1' && $recipeToDelete->recipe_image_url != '2')
            unlink(storage_path('app/public/RecipeImage/' . $recipeToDelete['recipe_image_url']));

        $recipeGroceries = $recipeToDelete->recipeGroceries;
        $dailyRecipeGroceries = $recipeToDelete->dailyRecipeGroceries;

         foreach($recipeGroceries as $grocery){
            $grocery->delete();
         }
         foreach($dailyRecipeGroceries as $dailyGrocery){
            $dailyGrocery->delete();
         }

         DB::table('dailymeals_recipes')->where('recipe_id', $recipeToDelete->id)->delete();
         DB::table('templatemeal_recipe')->where('recipe_id', $recipeToDelete->id)->delete();
         $recipeToDelete->delete();

        return $this->index();
    }
}
