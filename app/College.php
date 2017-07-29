<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    public function organizations()
    {
    	return $this->hasMany(Organization::class);
    }
}
