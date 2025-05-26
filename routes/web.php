<?php

use App\Http\Controllers\BarcodeController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [BarcodeController::class, 'index'])->name('barcode');

// Item
Route::post('/barcode/item', [BarcodeController::class, 'storeItem'])->name('barcode.items.store');
Route::post('/barcode/jeniskayu', [BarcodeController::class, 'storeJenisKayu'])->name('barcode.jeniskayus.store');
Route::delete('/barcode/jeniskayu/{jeniskayu}', [BarcodeController::class, 'destroyJenisKayu'])->name('barcode.jeniskayus.destroy');
Route::post('/barcode/grade', [BarcodeController::class, 'storeGrade'])->name('barcode.grades.store');
Route::delete('/barcode/grade/{grade}', [BarcodeController::class, 'destroyGrade'])->name('barcode.grades.destroy');
Route::post('/barcode/finishing', [BarcodeController::class, 'storeFinishing'])->name('barcode.finishings.store');
Route::delete('/barcode/finishing/{finishing}', [BarcodeController::class, 'destroyFinishing'])->name('barcode.finishings.destroy');
Route::post('/barcode/jenisanyam', [BarcodeController::class, 'storeJenisAnyam'])->name('barcode.jenisanyams.store');
Route::delete('/barcode/jenisanyam/{jenisanyam}', [BarcodeController::class, 'destroyJenisAnyam'])->name('barcode.jenisanyams.destroy');
Route::post('/barcode/warnaanyam', [BarcodeController::class, 'storeWarnaAnyam'])->name('barcode.warnaanyams.store');
Route::delete('/barcode/warnaanyam/{warnaanyam}', [BarcodeController::class, 'destroyWarnaAnyam'])->name('barcode.warnaanyams.destroy');
Route::post('/barcode/buyer', [BarcodeController::class, 'storeBuyer'])->name('barcode.buyers.store');
Route::delete('/barcode/buyer/{buyer}', [BarcodeController::class, 'destroyBuyer'])->name('barcode.buyers.destroy');
Route::post('/barcode/purchase', [BarcodeController::class, 'storePurchase'])->name('barcode.purchases.store');
Route::delete('/barcode/purchase/{purchase}', [BarcodeController::class, 'destroyPurchase'])->name('barcode.purchases.destroy');
Route::post('/barcode/container', [BarcodeController::class, 'storeContainer'])->name('barcode.containers.store');
Route::delete('/barcode/container/{container}', [BarcodeController::class, 'destroyContainer'])->name('barcode.containers.destroy');
Route::post('/barcode/origin', [BarcodeController::class, 'storeOrigin'])->name('barcode.origins.store');
Route::delete('/barcode/origin/{origin}', [BarcodeController::class, 'destroyOrigin'])->name('barcode.origins.destroy');
Route::get('/barcode/reverse-search', [BarcodeController::class, 'reverseSearch']);

// Buyer
Route::post('/barcode/buyer', [BarcodeController::class, 'storeBuyer'])->name('barcode.buyers.store');
Route::put('/barcode/buyer/{buyer}', [BarcodeController::class, 'updateBuyer'])->name('barcode.buyers.update');
Route::delete('/barcode/buyer/{buyer}', [BarcodeController::class, 'destroyBuyer'])->name('barcode.buyers.destroy');

// Purchase
Route::post('/barcode/purchase', [BarcodeController::class, 'storePurchase'])->name('barcode.purchases.store');
Route::put('/barcode/purchase/{purchase}', [BarcodeController::class, 'updatePurchase'])->name('barcode.purchases.update');
Route::delete('/barcode/purchase/{purchase}', [BarcodeController::class, 'destroyPurchase'])->name('barcode.purchases.destroy');

// API for dynamic dropdown
Route::get('/api/buyers/{buyer}/purchases', [BarcodeController::class, 'getPurchasesByBuyer']);


require __DIR__.'/auth.php';
