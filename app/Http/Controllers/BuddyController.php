<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuddyController extends Controller
{
    public function index()
    {
        
        return view('buddy.buddy');
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

        Auth::user()->deleteOtherRequests(Auth::user());

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
