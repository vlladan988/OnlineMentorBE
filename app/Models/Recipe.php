<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TemplateMeal;


class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['trainer_id', 'name', 'recipe_image_url', 'recipe_type', 'recipe_description'];
    
    public function trainer() {
        return $this->belongsTo('App\Models\Trainer');
    }

    public function recipeGroceries(){
        return $this->hasMany('App\Models\RecipeGrocery', 'recipe_id');
    }

    public function templateMeals() {
        return $this->belongsToMany(TemplateMeal::class, 'templatemeal_recipe','recipe_id', 'meal_id');
    }

    public function dailyMeals() {
        return $this->belongsToMany(DailyMeal::class, 'dailymeals_recipes', 'recipe_id', 'dailymeal_id');
    }

    public function dailyRecipeGroceries(){
        return $this->hasMany('App\Models\DailyRecipeGrocery', 'recipe_id');
    }


}
