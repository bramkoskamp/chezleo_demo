<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\KeukenController;
use Illuminate\Http\Request;
use App\Models\Order;
require __DIR__ . '/auth.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    // INDEX-PAGINA
    Route::get('/', [MenuController::class, 'menu'])->name('index');

    // DASHBOARD
    Route::get('/dashboard', [ReservationController::class, 'guest_reservations'])->middleware(['auth', 'verified'])->name('dashboard');

    // RESERVEREN
    Route::get('/reservering', [ReservationController::class, 'view'])->name('reservering');
    Route::post('/reservering/step1', [ReservationController::class, 'step1']);
    Route::post('/reservering/step2', [ReservationController::class, 'step2'])->name('step2');
    Route::post('/reservering/step3', [ReservationController::class, 'step3']);

    // MENU GASTEN
    Route::get('/guest_menu', [MenuController::class, 'index'])->name('guest_menu');

    Route::middleware('auth')->group(function () {
    
    // PROFIEL
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->middleware(['auth', 'verified', 'role:3'])->name('profile.edit');
    Route::patch('/profile.update/{id}', [ProfileController::class, 'update'])->name('profile/update/{id}');
    Route::get('/profile/delete/{id}', [ProfileController::class, 'delete'])->middleware(['auth', 'verified', 'role:3'])->name('profile.delete');

    // MEDEWERKERS
    Route::get('/manage_employees', [ProfileController::class, 'index'])->middleware(['auth', 'verified', 'role:3'])->name('profile.index');

    // DASHBOARD
    Route::post('/dashboard/update', [ReservationController::class, 'editGuestReservation'])->name('dashboard.update');
    Route::delete('/dashboard/delete/{reservation}', [ReservationController::class, 'destroy'])->name('dashboard.delete');

    //RESERVERINGEN
    Route::post('/reservations/update', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/delete/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.delete');
    Route::get('reservations', [ReservationController::class, 'getReservations'])->name('reservations');

    // REKENINGEN
    Route::get('/receipt/receipt_overlay', [ReceiptController::class, 'index'])->middleware(['auth', 'verified', 'role:2,3'])->name('receipt_overlay');
    Route::post('/receipt/receipt_overlay/checkout/{reservation}', [ReceiptController::class, 'checkout'])->name('receipt.checkout');

    //PDF
    Route::get('/download_receipt/{reservation}', [ReceiptController::class, 'downloadReceipt'])->name('receipt.download');

    // MENU (BESTELLING OPNEMEN)
    Route::get('/menu', [MenuController::class, 'showMenu'])->name('menu.menu');
    Route::post('/menu_dashboard', [MenuController::class, 'store'])->name('menu_dashboard.store');
    Route::put('/menu_dashboard/{id}', [MenuController::class, 'update'])->name('menu_dashboard.update');
    Route::get('/menu/delete/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // ORDERS
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{id}/', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // KEUKEN
    Route::get('/keuken', [KeukenController::class, 'index'])->name('keuken');
    Route::post('/dashboard/kitchen/complete', [KeukenController::class, 'markOrderAsCompleted'])->name('kitchen.complete');


    // GASTEN
    Route::get('/manage_guests', [ProfileController::class, 'show_guests'])->middleware(['auth', 'verified', 'role:3'])->name('guests_profile.index');
    Route::get('/manage_guest/delete/{id}', [ProfileController::class, 'deleteGuest'])->middleware(['auth', 'verified', 'role:3'])->name('manage_guest.delete');

    // REVIEWS
    Route::get('/reviews', [ReviewController::class, 'get_reviews'])->name('reviews');
    Route::post('/reviews/analyze', [ReviewController::class, 'analyze'])->name('reviews.analyze');
    route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/delete/{review}', [ReviewController::class, 'destroy'])->name('reviews.delete');
});
