<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
	protected $fillable = [
        'name', 'email', 'college', 'branch', 'department', 'mobile_number', 'alternate_number', 'amount',
    ];
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
