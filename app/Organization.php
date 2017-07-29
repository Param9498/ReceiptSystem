<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function events()
    {
    	return $this->hasMany(Event::class);
    }
    public function college()
    {
    	return $this->belongsTo(College::class);
    }
}
