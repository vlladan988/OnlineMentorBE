<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grocery extends Model
{
    use HasFactory;

    protected $fillable = ['trainer_id', 'name', 'unit', 'unit_type', 'proteins', 'carbons', 'fats', 'calories', 'default_proteins', 'default_carbons', 'default_fats'];

    public function trainer(){
        return $this->belongsTo('App\Models\Trainer');
    }
}
