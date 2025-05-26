<?php

use App\Http\Controllers\Backend\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Frontend\FrontController;
use App\Http\Controllers\Backend\ProdutoController;
use App\Http\Controllers\Frontend\PortifolioController;

Route::get('/', [FrontController::class, 'index']);
Route::get('/produtos', [ProdutoController::class, 'getProdutos']);
Route::get('/portifolio', [PortifolioController::class, 'index'])->name('portifolio.index');
Route::get('categoria/{slug}', [PortifolioController::class, 'produtosPorCategoria'])->name('categoria.produtos');
Route::get('front-end/show/{categoria}/{produto}', [PortifolioController::class, 'show'])->name('produto.show');


//chamando rotas MSFLIX ORGANIZADAS
foreach(File::allFiles(__DIR__.'/web') as $route_file){
    require $route_file->getPathname();
}

require __DIR__.'/auth.php';

//ROTA ADMIN LOGIN
Route::get('login', [AdminController::class, 'login'])->name('login');

//ROTA ADMIN RECUPERAÇÃO DE SENHA
Route::get('forgot-password', [AdminController::class, 'forgot'])->name('forgot');
