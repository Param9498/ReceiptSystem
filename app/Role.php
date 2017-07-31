<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $fillable = [
        'name', 'event_id', 'privilege_level'
    ];
    public function users()
    {
    	return $this->belongsToMany(User::class);
    }
    public function Event()
    {
    	return $this->belongsTo(Event::class);
    }
}
