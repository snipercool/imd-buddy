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
    /*  */
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
        return $this->buddyOfUser()->wherePivot('accepted', true)->wherePivot('refused', false)->wherePivot('deleted', null)->get()->merge($this->buddyOf()->wherePivot('accepted', true)->wherePivot('refused', false)->wherePivot('deleted', null)->get());
    }

    public function buddyRequests()
    {
        return $this->buddyOfUser()->wherePivot('accepted', false)->wherePivot('refused', false)->wherePivot('deleted', null)->get();
    }

    public function buddyRequestsPending()
    {
        return $this->buddyOf()->wherePivot('accepted', false)->wherePivot('refused', false)->wherePivot('deleted', null)->get();
    }

    public function buddyRequestsRefused()
    {
        return $this->buddyOf()->wherePivot('refused', true)->get();
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

    public function buddyDeleted()
    {
        return $this->buddyOfUser()->wherePivot('deleted', true)->wherePivot('deleted', true)->get()->merge($this->buddyOf()->wherePivot('deleted', true)->wherePivot('deleted', true)->get());
    }

    public function hasbuddy()
    {
        return $this->buddyOf()->wherePivot('accepted', true)->wherePivot('refused', false)->get();
    }

    public function acceptRequest(User $user)
    {
        $this->buddyRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted' => 1,
            'refused' => 0,
            'tries' => 1,
        ]);
    }
    public function refusedRequest(User $user)
    {
        $this->buddyRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted' => 0,
            'refused' => 1,
            'tries' => 1,
        ]);
    }

    public function deleteOtherRequests(User $user)
    {
        $this->buddyRequests()->where('id', $user->id)->where('accepted', 0)->detach($user->id);
    }

    public function deleteBuddy(User $user)
    {
        $this->buddy()->where('id', $user->id)->where('accepted', 0)->first()->pivot->update([
            'accepted' => 0,
            'deleted' => 1,
            'tries' => 1,
        ]);
    }

    public function buddyRefused(User $user)
    {
        return (bool) $this->buddyRequestsRefused()->where('id', $user->id)->count();
    }


    public function isBuddyWith(User $user)
    {
        return (bool) $this->buddy()->where('id', $user->id)->count(); 
    }

    public function noMoreBuddy(User $user)
    {
        return (bool) $this->buddyDeleted()->where('id', $user->id)->count(); 
    }
}
