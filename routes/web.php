<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route("alertas.index");
});

Auth::routes(["reset" => false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get("/home", function () {
    return redirect()->route("alertas.index");
});

Route::get("alertas", "App\Http\Controllers\AlertaController@index")->name("alertas.index");
Route::get("alertas/reporte", "App\Http\Controllers\AlertaController@reporte")->name("alertas.reporte");
Route::group(["middleware" => "auth"], function () {
    Route::resource("alertas", "App\Http\Controllers\AlertaController")->except(["index", "reporte"]);
    Route::resource("estados", "App\Http\Controllers\EstadoController");
    Route::resource("users", "App\Http\Controllers\UserController");
    Route::resource("roles", "App\Http\Controllers\RoleController");
});


