<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'front_image', 'back_image', 'side_image'];

    public function client(){
    	return $this->belongsTo('App\Models\Client');
    }
}
