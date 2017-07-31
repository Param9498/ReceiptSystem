<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function roles()
    {
    	return $this->hasMany(Role::class);
    }
    public function organization()
    {
    	return $this->belongsTo(Organization::class);
    }
    public function users()
    {
    	return $this->belongsToMany(User::class);
    }
}
