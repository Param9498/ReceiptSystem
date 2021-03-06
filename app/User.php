<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }
    public function college()
    {
        return $this->belongsTo(College::class);
    }
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
