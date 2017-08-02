<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $fillable = [
        'name', 'organization_id', 'privilege_level'
    ];
    public function users()
    {
    	return $this->belongsToMany(User::class);
    }
    public function organization()
    {
    	return $this->belongsTo(Organization::class);
    }
}
