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

Auth::routes();


//TUDO QUE ESTÁ AQUI, PRECISA ESTAR AUTENTICADO PARA ACESSAR
Route::group(['middleware' => 'auth'], function(){
	Route::get('/', [App\Http\Controllers\EventosController::class, 'exibirEventosConvidado'])->name('home');
	Route::get('/home', [App\Http\Controllers\EventosController::class, 'exibirEventosConvidado'])->name('home');
    
    Route::get('/eventos', [App\Http\Controllers\EventosController::class, 'index'])->name('eventos');
    Route::prefix('eventos')->group(function () {
        
        Route::get('adicionar', [App\Http\Controllers\EventosController::class, 'adicionar'])->name('adicionar');
        Route::post('salvar', [App\Http\Controllers\EventosController::class, 'salvar'])->name('salvar');
    	Route::get('exibir/{id_evento}', [App\Http\Controllers\EventosController::class, 'exibirEvento'])->name('exibir');
    	Route::post('editar/{id_evento}', [App\Http\Controllers\EventosController::class, 'editarEvento'])->name('editar');
    	Route::get('cancelar/{id_evento}', [App\Http\Controllers\EventosController::class, 'cancelarEvento'])->name('cancelar');
    	Route::get('ativar/{id_evento}', [App\Http\Controllers\EventosController::class, 'ativarEvento'])->name('ativar');


    	Route::get('pessoa/convidar/{id_evento}', [App\Http\Controllers\EventosController::class, 'convidarPessoa'])->name('convidarPessoa');
    	Route::post('pessoa/salvar/{id_evento}', [App\Http\Controllers\EventosController::class, 'salvarPessoa'])->name('salvarPessoa');
    	Route::get('pessoa/confirmar/{id_evento}', [App\Http\Controllers\EventosController::class, 'confirmarPessoa'])->name('confirmarPessoa');
    	Route::get('pessoa/recusar/{id_evento}', [App\Http\Controllers\EventosController::class, 'recusarPessoa'])->name('recusarPessoa');

    });

});