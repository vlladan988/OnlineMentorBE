<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyMeal extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'name', 'date'];

    public function client(){
       return $this->belongsTo('App\Models\Client');
    }
}
