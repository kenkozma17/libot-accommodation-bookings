<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BookingDetailsController;
use App\Http\Controllers\RoomSelectionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Admin\RoomsController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;

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

Route::get('/', function () {
    return Inertia::render('Booking/RoomFinder');
});
Route::resource('/available-rooms', RoomSelectionController::class);
Route::resource('/booking-details', BookingDetailsController::class);
Route::resource('/payment', PaymentController::class);
Route::post('/create-payment', [PaymentController::class, 'createPayMongoSession'])
  ->name('payment.create');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    
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
    Route::resource('/bookings', AdminBookingController::class, ['names' => 'bookings']);
});
