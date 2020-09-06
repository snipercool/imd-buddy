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
            if (Auth::user()->buddy == 1) {
                $data = User::where('buddy', 0)->get();
            }
            else {
                $data = User::where('buddy', 1)->get();
            }
        }

        //all user tags
        $tags = [];
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
        return view('home')->with(['data' => $data, 'tags' => $tags]);
    }
}
