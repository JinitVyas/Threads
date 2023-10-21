<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usersController;
use App\Http\Controllers\ThreadController;
use App\Http\Middleware;

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

// this portion of code is checking if loggedin or not 
// if not then go to login page, 
// that's why written before login GET route so that compiler will go ahead and find that route
Route::get('/home', function () {return view('pagewithauth');})->name('authverify')->middleware('checkLoginOfThredUser');
// Route::get('/loginland', function () {return view('pagewithauth');})->name('authverify')->middleware('LoggedinUserRestrictions');

    Route::get('/', function () { return view('index'); })->name('HomePage')->middleware('LoggedinUserRestrictions');
    Route::get('/login', function () { return view('login'); })->name('loginForm')->middleware('LoggedinUserRestrictions');
    Route::get('/reg', function () { return view('reg'); })->name('regForm')->middleware('LoggedinUserRestrictions');

// GETs
Route::get('/MyThreads', [ThreadController::class ,'MyThreads'])->name('MyThreads')->middleware('checkLoginOfThredUser');
Route::get('/addThread', function () { return view('ThreadForm'); })->name('ThreadForm')->middleware('checkLoginOfThredUser');
Route::get('/logout', [usersController::class,'logout'])->name('regForm');
Route::get('/Profile/{id}',[usersController::class, 'getProfile']);
Route::get('/Follow/{id}',[usersController::class, 'followProfile']);
Route::get('/Unfollow/{id}',[usersController::class, 'unfollowProfile']);
Route::get('/Like/{id}',[ThreadController::class, 'voteThread']);
Route::get('/Comment/{id}',[ThreadController::class, 'commentThread']);
Route::get('/Threads/{uname}',[ThreadController::class, 'showThread']);

// POSTs
Route::post('/login', [usersController::class, 'login'])->name('login');
Route::post('/reg', [usersController::class, 'signup'])->name('reg');
Route::post('/addThread', [ThreadController::class, 'create'])->name('startThread');
