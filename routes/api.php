<?php

use App\Http\Controllers\API\PSController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('task-one/{param_one}/{param_two}',[PSController::class,'taskOne'])->name('task-one');
Route::get('task-two/{input_string}',[PSController::class,'taskTwo'])->name('task-two');
Route::get('task-three/{N}/{Q}',[PSController::class,'taskThree'])->name('task-three');


Route::post('register',[UserController::class,'register'])->name('register');
Route::post('login',[UserController::class,'login'])->name('login');





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout',[UserController::class,'logout'])->name('logout');

    Route::get('user/{user}',[UserController::class,'show'])->name('user.show');
    Route::patch('user/{user}',[UserController::class,'update'])->name('user.update');
    Route::delete('user/{user}',[UserController::class,'destroy'])->name('user.delete');
    Route::get('users',[UserController::class,'index'])->name('user.index');
});
