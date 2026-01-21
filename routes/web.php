<?php

use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryMappingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceDetailController;
use App\Http\Controllers\DeviceUserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\SpecificationController;
use App\Http\Controllers\TempMonitoringController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WarehouseController;

Route::get('/', [AuthController::class, 'login'])->name('login')->middleware('web');

// Untuk ujicoba halaman, jangan dihapus
Route::get('/suhu', function () {
    return view('backend.idev.monitoring-suhu');
})->name('suhu');

Route::group(['middleware' => ['web', 'auth']], function () {
    // Route Warehouse
    Route::resource('warehouse', WarehouseController::class);
    Route::get('warehouse-api', [WarehouseController::class, 'indexApi'])->name('warehouse.listapi');
    Route::get('warehouse-export-pdf-default', [WarehouseController::class, 'exportPdf'])->name('warehouse.export-pdf-default');
    Route::get('warehouse-export-excel-default', [WarehouseController::class, 'exportExcel'])->name('warehouse.export-excel-default');
    Route::post('warehouse-import-excel-default', [WarehouseController::class, 'importExcel'])->name('warehouse.import-excel-default');

    // Route Location
    Route::resource('location', LocationController::class);
    Route::get('location-api', [LocationController::class, 'indexApi'])->name('location.listapi');
    Route::get('location-export-pdf-default', [LocationController::class, 'exportPdf'])->name('location.export-pdf-default');
    Route::get('location-export-excel-default', [LocationController::class, 'exportExcel'])->name('location.export-excel-default');
    Route::post('location-import-excel-default', [LocationController::class, 'importExcel'])->name('location.import-excel-default');

    // Route Customer
    Route::resource('customer', CustomerController::class);
    Route::get('customer-api', [CustomerController::class, 'indexApi'])->name('customer.listapi');
    Route::get('customer-export-pdf-default', [CustomerController::class, 'exportPdf'])->name('customer.export-pdf-default');
    Route::get('customer-export-excel-default', [CustomerController::class, 'exportExcel'])->name('customer.export-excel-default');
    Route::post('customer-import-excel-default', [CustomerController::class, 'importExcel'])->name('customer.import-excel-default');

    // Route Category Mapping
    Route::resource('category-mapping', CategoryMappingController::class);
    Route::get('category-mapping-api', [CategoryMappingController::class, 'indexApi'])->name('category-mapping.listapi');
    Route::get('category-mapping-export-pdf-default', [CategoryMappingController::class, 'exportPdf'])->name('category-mapping.export-pdf-default');
    Route::get('category-mapping-export-excel-default', [CategoryMappingController::class, 'exportExcel'])->name('category-mapping.export-excel-default');
    Route::post('category-mapping-import-excel-default', [CategoryMappingController::class, 'importExcel'])->name('category-mapping.import-excel-default');

    // Route Mapping
    Route::resource('mapping', MappingController::class);
    Route::get('mapping-api', [MappingController::class, 'indexApi'])->name('mapping.listapi');
    Route::get('mapping-print', [MappingController::class, 'generatePDF'])->name('mapping.print');
    Route::get('mapping-export-pdf-default', [MappingController::class, 'exportPdf'])->name('mapping.export-pdf-default');
    Route::get('mapping-export-excel-default', [MappingController::class, 'exportExcel'])->name('mapping.export-excel-default');
    Route::post('mapping-import-excel-default', [MappingController::class, 'importExcel'])->name('mapping.import-excel-default');

    // Route Monitoring
    Route::resource('temp-monitoring', TempMonitoringController::class);
Route::get('temp-monitoring-api', [TempMonitoringController::class, 'indexApi'])->name('temp-monitoring.listapi');
Route::get('temp-monitoring-export-pdf-default', [TempMonitoringController::class, 'exportPdf'])->name('temp-monitoring.export-pdf-default');
Route::get('temp-monitoring-export-excel-default', [TempMonitoringController::class, 'exportExcel'])->name('temp-monitoring.export-excel-default');
Route::post('temp-monitoring-import-excel-default', [TempMonitoringController::class, 'importExcel'])->name('temp-monitoring.import-excel-default');

    // Route Form Pengajuan
    Route::get('/form-pengajuan', function () {
    return view('frontend.form-pengajuan');
    })->name('form-pengajuan');
    Route::post('/form-pengajuan-submit', [CustomerController::class, 'pengajuanCustomer'])->name('form-pengajuan-submit');
    Route::get('cetak-pengajuan-data', [CustomerController::class, 'generatePDF'])->name('cetak.pengajuan.data');
    Route::get('form-transfer', [CustomerController::class, 'formTransfer'])->name('form.transfer');

    // Route Employee
    Route::resource('employee', EmployeeController::class);
    Route::get('employee-api', [EmployeeController::class, 'indexApi'])->name('employee.listapi');
    Route::get('employee-export-pdf-default', [EmployeeController::class, 'exportPdf'])->name('employee.export-pdf-default');
    Route::get('employee-export-excel-default', [EmployeeController::class, 'exportExcel'])->name('employee.export-excel-default');
    Route::post('employee-import-excel-default', [EmployeeController::class, 'importExcel'])->name('employee.import-excel-default');

    // Route Asset
    Route::resource('asset', AssetController::class);
    Route::get('asset-api', [AssetController::class, 'indexApi'])->name('asset.listapi');
    Route::get('asset-export-pdf-default', [AssetController::class, 'exportPdf'])->name('asset.export-pdf-default');
    Route::get('asset-export-excel-default', [AssetController::class, 'exportExcel'])->name('asset.export-excel-default');
    Route::post('asset-import-excel-default', [AssetController::class, 'importExcel'])->name('asset.import-excel-default');

    // Route Specification
    Route::resource('specification', SpecificationController::class);
    Route::get('specification-api', [SpecificationController::class, 'indexApi'])->name('specification.listapi');
    Route::get('specification-export-pdf-default', [SpecificationController::class, 'exportPdf'])->name('specification.export-pdf-default');
    Route::get('specification-export-excel-default', [SpecificationController::class, 'exportExcel'])->name('specification.export-excel-default');
    Route::post('specification-import-excel-default', [SpecificationController::class, 'importExcel'])->name('specification.import-excel-default');

    // Route Transaction
    Route::resource('transaction', TransactionController::class);
    Route::get('transaction-api', [TransactionController::class, 'indexApi'])->name('transaction.listapi');
    Route::get('transaction-export-pdf-default', [TransactionController::class, 'exportPdf'])->name('transaction.export-pdf-default');
    Route::get('transaction-export-excel-default', [TransactionController::class, 'exportExcel'])->name('transaction.export-excel-default');
    Route::post('transaction-import-excel-default', [TransactionController::class, 'importExcel'])->name('transaction.import-excel-default');
    
    // Route Maintenance
    Route::resource('maintenance', MaintenanceController::class);
    Route::get('maintenance-api', [MaintenanceController::class, 'indexApi'])->name('maintenance.listapi');
    Route::get('maintenance-export-pdf-default', [MaintenanceController::class, 'exportPdf'])->name('maintenance.export-pdf-default');
    Route::get('maintenance-export-excel-default', [MaintenanceController::class, 'exportExcel'])->name('maintenance.export-excel-default');
    Route::post('maintenance-import-excel-default', [MaintenanceController::class, 'importExcel'])->name('maintenance.import-excel-default');

    // Route Ticket
    Route::resource('ticket', TicketController::class);
    Route::get('ticket-api', [TicketController::class, 'indexApi'])->name('ticket.listapi');
    Route::get('ticket-export-pdf-default', [TicketController::class, 'exportPdf'])->name('ticket.export-pdf-default');
    Route::get('ticket-export-excel-default', [TicketController::class, 'exportExcel'])->name('ticket.export-excel-default');
    Route::post('ticket-import-excel-default', [TicketController::class, 'importExcel'])->name('ticket.import-excel-default');

});

Route::group(['middleware' => ['web', 'auth']], function () { 
    // Route Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

     // Route Device User
    Route::resource('device-user', DeviceUserController::class);
    Route::get('device-user-api', [DeviceUserController::class, 'indexApi'])->name('device-user.listapi');
    Route::get('device-user-export-pdf-default', [DeviceUserController::class, 'exportPdf'])->name('device-user.export-pdf-default');
    Route::get('device-user-export-excel-default', [DeviceUserController::class, 'exportExcel'])->name('device-user.export-excel-default');
    Route::post('device-user-import-excel-default', [DeviceUserController::class, 'importExcel'])->name('device-user.import-excel-default');

    // Route Detail Device
    Route::resource('device-detail', DeviceDetailController::class);
    Route::get('device-detail-api', [DeviceDetailController::class, 'indexApi'])->name('device-detail.listapi');
    Route::get('device-detail-export-pdf-default', [DeviceDetailController::class, 'exportPdf'])->name('device-detail.export-pdf-default');
    Route::get('device-detail-export-excel-default', [DeviceDetailController::class, 'exportExcel'])->name('device-detail.export-excel-default');
    Route::post('device-detail-import-excel-default', [DeviceDetailController::class, 'importExcel'])->name('device-detail.import-excel-default');
    Route::post('device-detail-maintenance-store', [DeviceDetailController::class, 'storeMaintenance'])->name('device-detail.maintenance-store');

    // Route Scanner Suhu
    Route::get('scanner-temperature', [TempMonitoringController::class, 'ScannerTemperature'])->name('scanner-temperature' );
    Route::get('scanner-temperature/get-point', [TempMonitoringController::class, 'getPointDetails'])->name('scanner-temperature.get-point');
    Route::post('scanner-temperature/store', [TempMonitoringController::class, 'storeTemperature'])->name('scanner-temperature.store');

    // Route Mapping
    Route::get('mapping-suhu', [MappingController::class, 'monitoringSuhu'])->name('monitoring-suhu');
    Route::get('mapping-pdf', [MappingController::class, 'generatePDF'])->name('mapping.pdf');
});
