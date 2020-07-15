<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'year', 'buddy', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function FriendsOfUser()
    {
        return $this->belongsToMany('App\User', 'buddy', 'user_id', 'buddy_id');
    }

    public function FriendsOf()
    {
        return $this->belongsToMany('App\User', 'buddy', 'buddy_id', 'user_id');
    }

    public function Friends()
    {
        return $this->FriendsOfUser()->wherePivot('accepted', true)->get()->merge($this->FriendsOf()->wherePivot('accepted', true)->get());
    }
}
