<?php
namespace App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RoleController;
use Illuminate\Support\Facades\UserController;
use Illuminate\Support\Facades\ProductController;

Route::get('/', function (){ 
    if (Auth::check()) { 
        return redirect()->route('home');
    } return redirect()->route('login'); });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth']) ->group(function(){ Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('products', ProductController::class); }); 