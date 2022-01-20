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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('/login', \App\Http\Livewire\Auth\Login::class)->name('login');
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/register', \App\Http\Livewire\Auth\Register::class)->name('register');
});

Route::middleware(['auth'])->group(function () {

    // Home Page
    Route::get('/', \App\Http\Livewire\Home::class)->name('home');
    Route::get('/home', function () {
        return redirect()->route('home');
    });

    // Logout
    Route::get('logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');
});
