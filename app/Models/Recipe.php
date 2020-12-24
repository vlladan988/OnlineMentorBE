<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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


}
