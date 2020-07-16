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

    public function buddyOfUser()
    {
        return $this->belongsToMany('App\User', 'buddy', 'user_id', 'buddy_id');
    }

    public function buddyOf()
    {
        return $this->belongsToMany('App\User', 'buddy', 'buddy_id', 'user_id');
    }

    public function buddy()
    {
        return $this->buddyOfUser()->wherePivot('accepted', true)->wherePivot('refuse', false)->get()->merge($this->buddyOf()->wherePivot('accepted', true)->wherePivot('refuse', false)->get());
    }

    public function buddyRequests()
    {
        return $this->buddyOfUser()->wherePivot('accepted', false)->wherePivot('refuse', false)->get();
    }

    public function buddyRequestsPending()
    {
        return $this->buddyOf()->wherePivot('accepted', false)->wherePivot('refuse', false)->get();
    }

    public function hasbuddyRequestPending(User $user)
    {
        return (bool) $this->buddyRequestsPending()->where('id', $user->id)->count();
    }

    public function hasbuddyRequestReceived(User $user)
    {
        return (bool) $this->buddyRequests()->where('id', $user->id)->count();
    }

    public function addbuddy(User $user)
    {
        $this->buddyOf()->attach($user->id);
    }

    public function acceptRequest(User $user)
    {
        $this->buddyRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted' => 1,
            'refuse' => 0,
            'tries' => 1,
        ]);
    }
    public function refuseRequest(User $user)
    {
        $this->buddyRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted' => 0,
            'refuse' => 1,
            'tries' => 1,
        ]);
    }

    public function deleteOtherRequests(User $user)
    {
        $this->buddyOf()->detach($user->id);
    }

    public function buddyRefused()
    {
        return (bool) $this->buddyOfUser()->wherePivot('refuse', true)->get()->merge($this->buddyOf()->wherePivot('refuse', true)->get());
    }


    public function isBuddyWith(User $user)
    {
        return (bool) $this->buddy()->where('id', $user->id)->count(); 
    }
}
