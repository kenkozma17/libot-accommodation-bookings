<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BookingDetailsController;
use App\Http\Controllers\RoomFinderController;
use App\Http\Controllers\RoomSelectionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Admin\RoomsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\FolioController as AdminFolioController;
use App\Http\Controllers\Admin\FolioTransactionController as AdminFolioTransactionController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ExpensesController as AdminExpensesController;
use App\Http\Controllers\Admin\ReportsController as AdminReportsController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\InventoryMovementController as AdminInventoryMovementController;
use App\Http\Controllers\Admin\PurchaseOrderController as AdminPurchaseOrderController;

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

Route::get('/cancellation-policy', function() {
    return Inertia::render('Terms/Cancellation');
});
Route::get('/', [RoomFinderController::class, 'index']);
Route::resource('/available-rooms', RoomSelectionController::class);
Route::resource('/booking-details', BookingDetailsController::class);
Route::resource('/payment', PaymentController::class);
Route::post('/create-payment', [PaymentController::class, 'createPayMongoCheckoutSession'])
  ->name('payment.create');

Route::post('booking-payment-success', [PaymentController::class, 'handlePayMongoPaymentSuccess'])
  ->name('payment.success');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/guests', GuestController::class, ['names' => 'guests']);

    Route::resource('/rooms', RoomsController::class, ['names' => 'rooms']);
    Route::post('/rooms/block-date/{id}', [RoomsController::class, 'blockDate'])
      ->name('rooms.block-date');
    Route::post('/rooms/unblock-date/{id}', [RoomsController::class, 'unblockDate'])
      ->name('rooms.unblock-date');
    Route::post('rooms/upload-image/{id}', [RoomsController::class, 'uploadImage'])
      ->name('rooms.upload-image');
    Route::delete('rooms/delete-image/{imageId}', [RoomsController::class, 'deleteImage'])
      ->name('rooms.delete-image');
    Route::post('rooms/set-primary-image/{imageId}', [RoomsController::class, 'setPrimaryImage'])
      ->name('rooms.set-primary-image');

    Route::resource('/payments', AdminPaymentController::class, ['names' => 'payments']);
    Route::get('/manual-payments', [AdminPaymentController::class, 'showManualPayments'])
        ->name('payments.manual-payments');

    Route::resource('/bookings', AdminBookingController::class, ['names' => 'bookings']);
    Route::resource('/folios', AdminFolioController::class, ['names' => 'folios']);
    Route::resource('/folio-transactions', AdminFolioTransactionController::class, ['names' => 'folio-transactions']);
    Route::get('/folio-transactions-report/{folioId}', [AdminFolioTransactionController::class, 'printFolio'])
        ->name('folio-transactions.print');
    Route::get('/payments-export', [AdminPaymentController::class, 'export'])->name('payments.export');

    /* Services */
    Route::resource('/services', AdminServiceController::class, ['names' => 'services']);
    Route::post('/services/add-inventory-item/{service_id}', [AdminServiceController::class, 'addInventoryItem'])
      ->name('services.add-inventory-item');
    Route::delete('/services/remove-inventory-item/{service_id}', [AdminServiceController::class, 'removeInventoryItem'])
      ->name('services.remove-inventory-item');

    Route::resource('/expenses', AdminExpensesController::class, ['names' => 'expenses']);

    /* Inventory */
    Route::resource('inventory', AdminInventoryController::class);
    Route::resource('inventory-movement', AdminInventoryMovementController::class);

    /* Purchase Order */
    Route::resource('purchase-order', AdminPurchaseOrderController::class);
    Route::post('purchase-order/generate', [AdminPurchaseOrderController::class, 'generatePurchaseOrderFile'])
      ->name('purchase-order.generate');

    Route::group(['middleware' => ['can:manage reports']], function() {
        Route::resource('/reports', AdminReportsController::class, ['names' => 'reports']);
        Route::get('/reports-generate', [AdminReportsController::class, 'generateReport'])
            ->name('reports.generate');
    });
});
