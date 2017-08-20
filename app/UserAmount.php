<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAmount extends Model
{
   	protected $fillable = [
        'event_id', 'user_id', 'amount_collected',
    ];
    protected $table = 'user_amount';
}
