<?php

use Illuminate\Support\Facades\Route;

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
        return view('welcome');
    })->name('welcome');;

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/Profile', 'Usercontroller@profile')->name('profile');

    Route::get('/settings', 'HomeController@settings')->name('settings');
});


