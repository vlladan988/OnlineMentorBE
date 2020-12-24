<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeGrocery extends Model
{
    use HasFactory;

    protected $fillable = ['recipe_id', 'name', 'unit', 'unit_type', 'proteins', 'carbons', 'fats', 'calories', 'default_proteins', 'default_carbons', 'default_fats'];

    public function recipe(){
        return $this->belongsTo('App\Models\Recipe');
    }
}
