<?php

namespace App\Http\Controllers;

use App\TagModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::guest()) {
           $data =  User::all();
        }
        if (Auth::user()) {
            $data = User::all()->except(Auth::id());
        }

        //all user tags
        $user = Auth::user();
        $skills = DB::table('user_tags')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($tags) {
                return [
                    'id'      => $tags->id,
                    'value'   => $tags->tag_id,
                ];
            });
        foreach ($skills as $tag => $value) {
            $tags[] = TagModel::where('id', $value)->first();
        }
        return view('home', compact('data', 'tags'));
    }
}
