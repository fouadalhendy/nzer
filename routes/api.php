<?php

use App\Http\Controllers\AuthControler;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\Usercontroller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('home', [AuthControler::class,'index']);
Route::post('login', [AuthControler::class,'login'])->name('login');
Route::post('register', [AuthControler::class,'regster']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthControler::class,'logout']);

    Route::get('home', [AuthControler::class,'index']);

    Route::resource('team', TeamController::class);
    Route::resource('contact', ContactController::class);
    Route::resource('user', Usercontroller::class);
    Route::resource('client', ClientsController::class);
    Route::resource('event', EventController::class);
});
