<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoriaController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\ProdutoController;
use App\Http\Controllers\Backend\PromocaoController;
use App\Http\Controllers\Backend\VendedorController;
use App\Http\Controllers\Backend\VendaController;
use App\Http\Controllers\Backend\ColaboradorController;
use App\Http\Controllers\Backend\ServicoController;
use Illuminate\Support\Facades\Route;

//rota admin
Route::get('admin/dashboard', [AdminController::class, 'dashboard'])
->middleware(['auth', 'admin'])
->name('admin.dashboard');

//ROTA ADMIN VER PERFIL
Route::get('admin/profile', [ProfileController::class, 'index'])
->middleware(['auth', 'admin'])
->name('admin.profile');

//ROTA ADMIN PARA ATUALIZAR PERFIL
Route::post('admin/profile/update', [ProfileController::class, 'update'])
->middleware(['auth', 'admin'])
->name('admin.profile.update');

//ROTA ADMIN PARA ATUALIZAR SENHA
Route::post('admin/profile/update/password', [ProfileController::class, 'updatePassword'])
->middleware(['auth', 'admin'])
->name('admin.profile.password');

//ROTA SLIDER DESTAQUE
Route::PUT('muda-status', [SliderController::class, 'mudaStatus'])->name('slider.muda-status');
Route::resource('admin/slider', SliderController::class)
->middleware(['auth', 'admin']);

//ROTA CATEGORIAS
Route::PUT('cMuda-status', [CategoriaController::class, 'cMudaStatus'])->name('categoria.muda-status');
Route::resource('admin/categoria', CategoriaController::class)
->middleware(['auth', 'admin']);

//ROTA PRODUTOS
Route::PUT('pMuda-status', [ProdutoController::class, 'pMudaStatus'])->name('produto.muda-status');
Route::resource('admin/produto', ProdutoController::class)
->middleware(['auth', 'admin']);

//ROTA PROMOÇÕES
Route::PUT('proMuda-status', [PromocaoController::class, 'proMudaStatus'])->name('promocao.muda-status');
Route::resource('admin/promocao', PromocaoController::class)
->middleware(['auth', 'admin']);

// Grupo de rotas para o painel de administração
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function() {
    // Rota resource para vendedor
    Route::resource('vendedor', VendedorController::class);
    Route::resource('vendas', VendaController::class);
    Route::get('/vendas/{id}/filtrar', [VendaController::class, 'buscarVendas'])
    ->name('admin.vendas.filtrar');
    Route::get('/vendas/{id}/detalhes', [VendaController::class, 'detalhes'])->name('vendas.detalhes');
    Route::post('/vendas/{id}/concluir', [VendaController::class, 'concluirVenda'])->name('venda.concluir');


});


Route::prefix('admin')->group(function() {
    Route::delete('/colaboradores/{colaboradorId}', [ColaboradorController::class, 'destroy'])->name('colaboradores.destroy');
    Route::get('/colaboradores', [ColaboradorController::class, 'index'])->name('admin.colaboradores.index');
    Route::post('/colaboradores', [ColaboradorController::class, 'storeColaborador'])->name('admin.colaboradores.store');
    Route::post('/servicos', [ColaboradorController::class, 'storeServico'])->name('admin.servicos.store');
    Route::post('/colaboradores/{colaboradorId}/servicos', [ColaboradorController::class, 'storeServicoColaborador'])->name('admin.colaboradores.servicos.store');
    Route::get('/colaboradores/servicos', [ColaboradorController::class, 'listarServicos'])->name('admin.servicos.listar');
    Route::get('/colaboradores/{colaboradorId}/detalhes', [ColaboradorController::class, 'detalhes'])->name('admin.colaboradores.detalhes');

});
