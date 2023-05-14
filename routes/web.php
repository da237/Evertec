<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolPermissionController;
use App\Http\Controllers\UsuariosController;
//use App\Http\Controllers\ProductsController;
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

Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>['auth']],function(){
    Route::group(['prefix'=>'roles'],function(){
        Route::get('/',[App\Http\Controllers\RolPermissionController::class,'index'])->middleware(['permission:ver-usuario'])->name('roles.index');
        Route::get('/create',[App\Http\Controllers\RolPermissionController::class,'create'])->middleware(['permission:crear-usuario'])->name('roles.create');
        Route::put('/update/{id}',[App\Http\Controllers\RolPermissionController::class,'update'])->middleware(['permission:editar-usuario'])->name('roles.update');
        Route::delete('/delete/{id}',[App\Http\Controllers\RolPermissionController::class,'delete'])->middleware(['permission:borar-usuario'])->name('roles.delete');
    });

    Route::group(['prefix'=>'usuarios'],function(){
        Route::get('/',[App\Http\Controllers\UsuariosController::class,'index'])
            ->middleware(['permission:view-users'])
            ->name('usuarios.index');
        Route::get('/all',[App\Http\Controllers\UsuariosController::class,'all'])
            ->middleware(['permission:view-users'])
            ->name('usuarios.all');
        Route::get('/create',[App\Http\Controllers\UsuariosController::class,'create'])->middleware(['permission:create-users'])->name('usuarios.create');
        Route::put('/update/{id}',[App\Http\Controllers\UsuariosController::class,'update'])->middleware(['permission:edit-users'])->name('usuarios.update');
        Route::put('/update_status/{id}',[App\Http\Controllers\UsuariosController::class,'updateStatus'])->middleware(['permission:edit-users'])->name('usuarios.update.status');
        Route::delete('/delete/{id}',[App\Http\Controllers\UsuariosController::class,'delete'])->middleware(['permission:delete-users'])->name('usuarios.delete');
    });

    Route::group(['prefix'=>'productos'],function(){
        Route::get('/',[ProductsController::class,'index'])
            ->middleware(['permission:ver-products'])
            ->name('productos.index');
        Route::get('/all',[ProductsController::class,'all'])
            ->middleware(['permission:ver-products'])
            ->name('productos.all');
        Route::get('/create',[ProductsController::class,'create'])
            ->middleware(['permission:crear-products'])
            ->name('productos.create');
        Route::put('/update/{id}',[ProductsController::class,'update'])
            ->middleware(['permission:editar-products'])
            ->name('productos.update');
        Route::delete('/delete/{id}',[ProductsController::class,'delete'])
            ->middleware(['permission:borar-products'])
            ->name('productos.delete');
    });


    // Route::resource('usuarios',UsuarioController::class);

    Route::get('usuarios/index',[UsuarioController::class,'index']);
});
