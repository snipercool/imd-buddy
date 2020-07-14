<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\User;
use App\TagModel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

route::get('/', function()
    {
        return redirect(app()->getLocale());
    });

Route::group([  'prefix' => '{locale}',
                'where' => ['locale' => '[a-zA-Z]{2}'],
                'middleware' => 'setlocale',
            ], function()
{
    route::get('/', function()
    {
        if (Auth::guest()) {
            $data =  User::all();
        }
        else {
             if (Auth::user()->buddy  == 0) {
                $data = User::where('buddy', 1)->get();
             }
             else {
                $data = User::where('buddy', 0)->get();
             }
         }

        return view('home', ['data' => $data]);
    })->name('home');

    Route::get('/home', 'Homecontroller@index');

    Auth::routes();

    Route::get('/profile', 'ProfileController@profile')->middleware('auth')->name('profile');

    Route::get('/updatepassword', 'ProfileController@PasswordPage')->middleware('auth')->name('updatepassword');

    Route::post('/updatepassword', 'ProfileController@updatePassword')->name('updatepassword');

    Route::post('/updateimage', 'ProfileController@UpdateImage')->name('updateimage');

    Route::post('/profile', 'ProfileController@update')->name('profile');
});


