<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	
	protected $fillable = [
        'branch', 'department', 'class', 'division', 'roll_number', 'mobile_number', 'user_id', 'college_id', 'alternate_number'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
