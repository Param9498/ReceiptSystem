<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function events()
    {
    	return $this->hasMany(Event::class);
    }
    public function users()
    {
    	return $this->belongsToMany(User::class);
    }
    public function college()
    {
    	return $this->belongsTo(College::class);
    }
    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}
