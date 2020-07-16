<?php

use App\Http\Controllers\BuddyController;
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

    Route::get('/search', 'SearchController@getResults')->name('search');

    //profileRoutes
    Route::get('/profile', 'ProfileController@profile')->middleware('auth')->name('profile');

    Route::get('/updatepassword', 'ProfileController@PasswordPage')->middleware('auth')->name('updatepassword');

    Route::post('/updatepassword', 'ProfileController@updatePassword')->name('updatepassword');

    Route::post('/updateimage', 'ProfileController@UpdateImage')->name('updateimage');

    Route::post('/profile', 'ProfileController@update')->name('profile');

    //buddyRoutes
    Route::get('/buddy', 'BuddyController@index')->middleware('auth')->name('buddy');

    Route::get('/buddy/add/{name}-{surname}', 'BuddyController@getAdd')->middleware('auth')->name('buddyadd');

    Route::get('/buddy/accept/{name}-{surname}', 'BuddyController@acceptRequest')->middleware('auth')->name('buddyaccept');


    Route::get('/user', 'ProfileController@userProfile')->middleware('auth')->name('userprofile');
});


