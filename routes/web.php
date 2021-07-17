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

// Route::get('/', function () {
//     return view('auth/login');
// });
Route::get('/', [App\Http\Controllers\Student\MasterController::class, 'home']);
Route::get('login-step', [App\Http\Controllers\Student\MasterController::class, 'loginStep'])->name('loginStep');
Route::get('university-list', [App\Http\Controllers\Student\UniversityController::class, 'index'])->name('universityList');
Route::get('varsity-professor-list/{varsity_id}', [App\Http\Controllers\Student\UniversityController::class, 'varsityProfessorList'])->name('varsityProfessorList');

Auth::routes(['verify' => true]);
Route::group(['middleware' => 'auth'], function (){
    Route::get('home', [App\Http\Controllers\Student\MasterController::class, 'home'])->name('home');
    Route::get('profile', [App\Http\Controllers\Student\ProfileController::class, 'index'])->name('profile');
    Route::put('profileUpdate/{id}', [App\Http\Controllers\Student\ProfileController::class, 'updateProfile'])->name('profileUpdate');
    Route::put('profilePassUpdate/{id}', [App\Http\Controllers\Student\ProfileController::class, 'updatePassword'])->name('profilePassUpdate');
    
    Route::get('rate-teacher', [App\Http\Controllers\Student\UniversityController::class, 'rateTeacher'])->name('rateTeacher');
    Route::get('teacherComments', [App\Http\Controllers\Student\UniversityController::class, 'teacherComments'])->name('teacherComments');
    Route::post('teacherCommentAction', [App\Http\Controllers\Student\UniversityController::class, 'teacherCommentAction'])->name('teacherCommentAction');
    Route::delete('removeComment/{id}', [App\Http\Controllers\Student\UniversityController::class, 'removeComment'])->name('removeComment');
    Route::post('teacherRatingAction', [App\Http\Controllers\Student\UniversityController::class, 'teacherRatingAction'])->name('teacherRatingAction');

});


Route::group(['prefix' => 'provider', 'as'=>'provider.'], function (){

    //Login & Logout
    Route::get('/', ['as'=>'login', function (){ return redirect()->route('provider.login');}]);
    Route::get('login', [App\Http\Controllers\Provider\MasterController::class, 'getLogin'])->name('login');
    Route::post('login', [App\Http\Controllers\Provider\MasterController::class, 'postLogin']);
    Route::post('logout', [App\Http\Controllers\Provider\MasterController::class, 'logout'])->name('logout');

    Route::group(['middleware' => 'providerAuth'], function (){
        Route::get('home', [App\Http\Controllers\Provider\MasterController::class, 'home'])->name('home');
        Route::get('profile', [App\Http\Controllers\Provider\ProfileController::class, 'index'])->name('profile');
        Route::put('profileUpdate/{id}', [App\Http\Controllers\Provider\ProfileController::class, 'updateProfile'])->name('profileUpdate');
        Route::put('profilePassUpdate/{id}', [App\Http\Controllers\Provider\ProfileController::class, 'updatePassword'])->name('profilePassUpdate');
        // UNIVERSITY
        Route::resource('university', App\Http\Controllers\Provider\UniversityController::class);
        Route::resource('post', App\Http\Controllers\Provider\PostController::class);
        
        Route::get('teacherRatingList', [App\Http\Controllers\Provider\UniversityController::class, 'teacherRatingList'])->name('teacherRatingList');
    });
});

Route::group(['prefix' => 'teacher', 'as'=>'teacher.'], function (){

    //Login & Logout  
    Route::get('/', ['as'=>'login', function (){ return redirect()->route('teacher.login');}]);
    Route::get('login', [App\Http\Controllers\Teacher\MasterController::class, 'getLogin'])->name('login');
    Route::post('login', [App\Http\Controllers\Teacher\MasterController::class, 'postLogin']);
    Route::post('logout', [App\Http\Controllers\Teacher\MasterController::class, 'logout'])->name('logout');

    Route::group(['middleware' => 'teacherAuth'], function (){
        Route::get('home', [App\Http\Controllers\Teacher\MasterController::class, 'home'])->name('home');
        Route::get('profile', [App\Http\Controllers\Teacher\ProfileController::class, 'index'])->name('profile');
        Route::get('myRate', [App\Http\Controllers\Teacher\ProfileController::class, 'myRate'])->name('myRate');

    });
});
