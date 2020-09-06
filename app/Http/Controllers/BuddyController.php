<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BuddyController extends Controller
{
    public function index()
    {
        //check if user has buddy
        $user = Auth::user()->id;
        
        $buddy = DB::table('buddy')
        ->join('users', 'buddy.buddy_id', '=', 'users.id')
        ->where('users.id','<>',$user)          
        ->where('buddy.accepted', true)                       
        ->where(function($query) use ($user)
                   {
                       $query->where('user_id', $user)
                             ->orWhere('buddy_id', $user);
                   })
       
         ->get();

        if ($buddy->isEmpty() ) {
            return redirect(app()->getLocale() . '/');
        }
        else {
            return view('buddy.buddy')->with('buddy', $buddy);
        }
       
    }

    public function getAdd($locale, $name, $surname)
    {
        $user = User::where('name', $name)->where('surname', $surname)->first();

        if (!$user) {
            return redirect()->back()->with('RequestError', 'Error!');
        }

        Auth::user()->addbuddy($user);

        return redirect()->back()->with('RequestSuccess', 'done!');
    }

    public function acceptRequest($locale, $name, $surname)
    {
        $user = User::where('name', $name)->where('surname', $surname)->first();

        if (!$user) {
            return redirect()->back()->with('AcceptError', 'Error!');
        }

        if (!Auth::user()->hasbuddyRequestReceived($user)) {
            return redirect(app()->getLocale() . '/');
        }

        Auth::user()->acceptRequest($user);

        $allYourrequests = DB::table('buddy')->where('accepted', '=', false)->where(function ($q)
        {
            $q->where('user_id', Auth::user()->id)->orWhere('buddy_id', Auth::user()->id);
        })->delete();

        return redirect()->back()->with('AcceptSuccess', 'done!');
    }

    public function refuseRequest($locale, $name, $surname)
    {
        $user = User::where('name', $name)->where('surname', $surname)->first();

        if (!Auth::user()->hasbuddyRequestReceived($user)) {
            return redirect(app()->getLocale() . '/');
        }

        Auth::user()->refusedRequest($user);

        return redirect()->back()->with('RefuseSuccess', 'done!');
    }

    public function deleteBuddy($locale, $name, $surname)
    {
        $user = User::where('name', $name)->where('surname', $surname)->first();

        if (!Auth::user()->isBuddyWith($user)) {
            return redirect()->back()->with('DeleteError', 'Error!');
        }

        Auth::user()->deleteBuddy($user);

        return redirect()->back()->with('DeleteSuccess', 'done!');
    }
}
