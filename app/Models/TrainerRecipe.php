<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerRecipe extends Model
{
    use HasFactory;

    protected $fillable = ['trainer_id', 'name', 'photo_url', 'proteins', 'carbohydrates', 'fats', 'calories', 'recipe_type', 'recipe_description' ];

    public function trainer() {
        return $this->belongsTo('App\Models\Trainer');
    }
}
