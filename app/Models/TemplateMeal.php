<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;


class TemplateMeal extends Model
{
    use HasFactory;

    protected $fillable = ['template_id', 'name', 'description', 'sort_number'];

    public function template(){
        return $this->belongsTo('App\Models\Template');
    }

    public function recipes() {
        return $this->belongsToMany(Recipe::class, 'templatemeal_recipe', 'meal_id', 'recipe_id');
    }
}
