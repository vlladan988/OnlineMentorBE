<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = ['start_at', 'end_at', 'final_weight', 'description', 'client_id'];

    public function client(){
    	return $this->belongsTo('App\Models\Client');
    }
}
