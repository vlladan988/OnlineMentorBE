<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grocery extends Model
{
    use HasFactory;

    protected $fillable = ['trainer_id', 'name', 'unit', 'unit_type', 'proteins', 'carbons', 'fats', 'calories', 'description'];

    public function trainer(){
        return $this->belongsTo('App\Models\Trainer');
    }
}
