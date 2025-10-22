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
// Grupo de rotas para o painel de administração
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function() {
    // Rota resource para vendedor
    Route::resource('vendedor', VendedorController::class);
    Route::resource('vendas', VendaController::class);
    Route::get('/vendas/{id}/filtrar', [VendaController::class, 'buscarVendas'])
    ->name('admin.vendas.filtrar');
    Route::get('/vendas/{id}/detalhes', [VendaController::class, 'detalhes'])->name('vendas.detalhes');
    Route::post('/vendas/{id}/concluir', [VendaController::class, 'concluirVenda'])->name('venda.concluir');
    Route::delete('/colaboradores/{colaboradorId}', [ColaboradorController::class, 'destroy'])->name('colaboradores.destroy');
    Route::get('/colaboradores', [ColaboradorController::class, 'index'])->name('admin.colaboradores.index');
    Route::get('/colaboradores/servicos', [ColaboradorController::class, 'listarServicos'])->name('admin.servicos.listar');
    Route::get('/colaboradores/{colaborador}', [ColaboradorController::class, 'show'])->name('admin.colaboradores.show');
    Route::post('/colaboradores', [ColaboradorController::class, 'storeColaborador'])->name('admin.colaboradores.store');
    Route::post('/servicos', [ColaboradorController::class, 'storeServico'])->name('admin.servicos.store');
    Route::post('/colaboradores/{colaboradorId}/servicos', [ColaboradorController::class, 'adicionarServicoColaborador'])->name('admin.colaboradores.servicos.store');
    Route::delete('/colaboradores/{colaboradorId}/servicos/{servicoId}', [ColaboradorController::class, 'destroyServicoColaborador'])->name('admin.colaboradores.servicos.destroy');
    Route::get('/colaboradores/{colaboradorId}/detalhes', [ColaboradorController::class, 'detalhes'])->name('admin.colaboradores.detalhes');
    Route::PUT('proMuda-status', [PromocaoController::class, 'proMudaStatus'])->name('promocao.muda-status');
    Route::resource('admin/promocao', PromocaoController::class);
    Route::PUT('pMuda-status', [ProdutoController::class, 'pMudaStatus'])->name('produto.muda-status');
    Route::resource('admin/produto', ProdutoController::class);
    Route::PUT('pMuda-status', [ProdutoController::class, 'pMudaStatus'])->name('produto.muda-status');
    Route::resource('admin/produto', ProdutoController::class);
    Route::PUT('cMuda-status', [CategoriaController::class, 'cMudaStatus'])->name('categoria.muda-status');
    Route::resource('admin/categoria', CategoriaController::class);
    Route::PUT('muda-status', [SliderController::class, 'mudaStatus'])->name('slider.muda-status');
    Route::resource('admin/slider', SliderController::class);
    Route::get('dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard');
    Route::get('profile', [ProfileController::class, 'index'])
    ->name('admin.profile');
    Route::post('profile/update', [ProfileController::class, 'update'])
    ->name('admin.profile.update');
    Route::post('profile/update/password', [ProfileController::class, 'updatePassword'])
    ->name('admin.profile.password');
    Route::get('faturamento', [AdminController::class, 'faturamentoIndex'])
    ->name('admin.faturamento.index');
    Route::post('faturamento/filtrar', [AdminController::class, 'faturamentoFiltrar'])
    ->name('admin.faturamento.filtrar');
});



