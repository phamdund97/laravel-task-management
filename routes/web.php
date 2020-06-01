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

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

/**
 * Route for General Part
 */
Route::middleware(['auth'])->group(function () {
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    Route::resource('profiles', 'General\ProfileController');

    /**
     * Route for Members
     */
    Route::middleware(['member'])->group(function () {
        Route::get('/home', 'Member\HomeController@index')->name('home');
        Route::get('/tasks-update', 'Member\TaskController@update')->name('update');
        Route::match(['post', 'get'], 'search', 'Member\SearchController@search')->name('search');
        Route::get('resultsSearch/{$projectId}', 'Member\SearchController@showTask')->name('redirectSearch');
        Route::resources([
            'projects' => 'Member\ProjectController',
            'resultsSearch' => 'Member\SearchController'
        ]);
        Route::resource('tasks', 'Member\TaskController')->only(['index', 'update']);
        Route::get('project/{id}/show-task', 'Member\ProjectController@showTask')->name('tasks.show_task');
    });

    /**
     * Route for Admin
     */
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin', 'Admin\HomeController@index')->name('admin');
        Route::resources([
            'members' => 'Admin\MemberController'
        ]);
    });
});
