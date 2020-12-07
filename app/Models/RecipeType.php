<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeType extends Model
{
    use HasFactory;

    protected $fillable = ['trainer_id', 'name'];

    public function trainer(){
        return $this->belongsTo('App\Models\Trainer');
    }
}
