<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Template extends Model
{
    use HasFactory;

    protected $fillable = ['trainer_id', 'name', 'template_image_url', 'template_meal_type', 'template_description', 'template_duration'];

    public function trainer(){
        return $this->belongsTo('App\Models\Trainer');
    }

    public function templateMeals(){
        return $this->hasMany('App\Models\TemplateMeal', 'template_id');
    }

    public function clients(){
        return $this->belongsToMany(Client::class, 'client_template', 'template_id', 'client_id');
    }


}
