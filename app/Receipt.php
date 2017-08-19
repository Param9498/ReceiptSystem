<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
	protected $fillable = [
        'name', 'email', 'college', 'branch', 'department', 'mobile_number', 'alternate_number', 'amount',
    ];
    protected $with = array('User', 'Event');
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    public function event()
    {
    	return $this->belongsTo(Event::class);
    }
}
