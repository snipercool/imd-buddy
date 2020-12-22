<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\MessageSent;
use App\Message;

class BuddyController extends Controller
{
    public function index()
    {
        //check if user has buddy        
        $buddy = Auth::user()->buddy();
        if ($buddy->isEmpty()) {
            return redirect(app()->getLocale() . '/');
        } else {

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

        $allYourrequests = DB::table('buddy')->where('accepted', '=', false)->where(function ($q) {
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

    public function fetchMessage()
    {
        //dd(Auth::id(), Auth::user()->buddy()->first()->id);
        return response()->json(\App\Message::with('user')->where(function ($first){
            $first->where('from_id', Auth::id())->where('to_id', Auth::user()->buddy()->first()->id);
        })->orWhere(function ($second) {
            $second->where('from_id', Auth::user()->buddy()->first()->id)
            ->where('to_id', Auth::id());
        })->oldest()->get());
    }

    public function sendMessage(Message $message)
    {
        if (request('message') != null) {
            $addMessage = $message->create([
                'from_id' => Auth::id(),
                'to_id' => Auth::user()->buddy()->first()->id,
                'message' => request('message')
            ]);

            $addMessage = Message::where('id', $addMessage->id)->with('user')->first(); 
                
            event(new MessageSent($addMessage));

            return $addMessage->toJson();
        }
        else {
            return redirect()->back()->with('noMessage', 'done!');
        }
        
    }
}
