<?php

use App\Http\Controllers\Backend\VendorController;
use Illuminate\Support\Facades\Route;

//rota vendedor
Route::get('vendor/dashboard', [VendorController::class, 'dashboard'])
->middleware(['auth', 'vendor'])
->name('vendor.dashboard');

Route::get('vendor/vendas/data', [VendorController::class, 'getVendasData'])
->middleware(['auth', 'vendor'])
->name('vendor.vendas.data');

Route::get('vendor/stats/periodo', [VendorController::class, 'getStatsByPeriod'])
->middleware(['auth', 'vendor'])
->name('vendor.stats.periodo');

Route::post('vendor/vendas/store', [VendorController::class, 'storeVenda'])
->middleware(['auth', 'vendor'])
->name('vendor.vendas.store');

Route::delete('vendor/vendas/{id}', [VendorController::class, 'deleteVenda'])
->middleware(['auth', 'vendor'])
->name('vendor.vendas.delete');

