<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $with = array('Organization');

    public function organization()
    {
    	return $this->belongsTo(Organization::class);
    }
    public function users()
    {
    	return $this->belongsToMany(User::class);
    }
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
