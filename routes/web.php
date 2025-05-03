<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

 // Rutas para productos, protegidas con el middleware de autenticación 'auth'
    Route::middleware(['auth'])->group(function () {
        Route::resource('productos', ProductoController::class);
    });

    // Rutas para categorías, protegidas con el middleware de autenticación 'auth'
    Route::middleware(['auth'])->group(function () {
        Route::resource('categorias', CategoriaController::class);
    });

    //Otras rutas de la aplicación
    Route::get('/', function () {
        return view('welcome');
    });

 

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
