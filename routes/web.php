<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::resource('customer', CustomerController::class);
    Route::get('customer-api', [CustomerController::class, 'indexApi'])->name('customer.listapi');
    Route::get('customer-export-pdf-default', [CustomerController::class, 'exportPdf'])->name('customer.export-pdf-default');
    Route::get('customer-export-excel-default', [CustomerController::class, 'exportExcel'])->name('customer.export-excel-default');
    Route::post('customer-import-excel-default', [CustomerController::class, 'importExcel'])->name('customer.import-excel-default');

    Route::get('/form-pengajuan', function () {
    return view('frontend.form-pengajuan');
    })->name('form-pengajuan');
    Route::post('/form-pengajuan-submit', [CustomerController::class, 'pengajuanCustomer'])->name('form-pengajuan-submit');

    Route::get('cetak-pengajuan-data', [CustomerController::class, 'generatePDF'])->name('cetak.pengajuan.data');
    Route::get('form-transfer', [CustomerController::class, 'formTransfer'])->name('form.transfer');
});
