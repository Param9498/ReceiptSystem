<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function receipts()
    {
    	return $this->hasMany(Receipt::class);
    }
}
