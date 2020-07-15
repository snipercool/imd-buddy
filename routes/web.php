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
    route::get('/', 'Homecontroller@index')->name('home');

    Route::get('/home', 'Homecontroller@index');

    Auth::routes();

    Route::get('/profile', 'ProfileController@profile')->middleware('auth')->name('profile');

    Route::get('/updatepassword', 'ProfileController@PasswordPage')->middleware('auth')->name('updatepassword');

    Route::get('/search', 'SearchController@getResults')->name('search');

    Route::post('/updatepassword', 'ProfileController@updatePassword')->name('updatepassword');

    Route::post('/updateimage', 'ProfileController@UpdateImage')->name('updateimage');

    Route::post('/profile', 'ProfileController@update')->name('profile');

    Route::get('/user', 'ProfileController@userProfile')->name('userprofile');
});


