<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function getResults()
    {
        $search = request('search');

        if (!$search) {
            return redirect()->back()->with('searchError', 'Error!');
        }
        $userbuddy = Auth::user()->buddy;

        if ($userbuddy == 1) {
            $users = User::where(DB::raw("CONCAT(name, ' ', surname)"), 'LIKE', "%{$search}%")
            ->where(function ($query)
            {
                $query->where('buddy', 0);
            })
            ->get();
        }
        elseif ($userbuddy == 0) {
            $users = User::where(DB::raw("CONCAT(name, ' ', surname)"), 'LIKE', "%{$search}%")
            ->where(function ($query)
            {
                $query->where('buddy', 1);
            })
            ->get();
        }

        return view('search.results')->with('users', $users);
    }
}
