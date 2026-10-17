<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\MovimentacaoEstoqueController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('produtos.index');
    });
    Route::get('/movimentacoes', [MovimentacaoEstoqueController::class, 'index'])->name('movimentacoes.index');

    Route::resource('produtos', ProdutoController::class);

    Route::get('/movimentacoes/create', [MovimentacaoEstoqueController::class, 'create'])->name('movimentacoes.create');
    Route::post('/movimentacoes', [MovimentacaoEstoqueController::class, 'store'])->name('movimentacoes.store');

    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index')->middleware('can:gerenciar-usuarios');
});