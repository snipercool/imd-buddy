<?php

use Illuminate\Support\Facades\Auth;
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
    route::get('/', 'Homecontroller@index')->name('home');

    Route::get('/home', 'Homecontroller@index');

    Auth::routes();

    Route::get('/Profile', 'Usercontroller@profile')->middleware('verified')->name('profile');

    Route::get('/settings', 'HomeController@settings')->name('settings');
});


