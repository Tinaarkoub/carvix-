<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminDocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('home');
})->name('home');

Route::get('/catalogue', [VehiculeController::class, 'catalogue'])->name('catalogue.index');


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.documents.index');
        }
        if (auth()->user()->role === 'proprietaire') {
            return redirect()->route('seller.dashboard');
        }
        $reservations = \App\Models\Reservation::where('client_id', auth()->id())
            ->with('vehicule')
            ->latest()
            ->get();
        $enCours = $reservations->whereIn('statut', ['en_attente', 'payee', 'confirmee'])->count();
        $derniere = $reservations->first();
        return view('buyer.dashboard', compact('reservations', 'enCours', 'derniere'));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('admin/categories', CategoryController::class)->names('categories');
        Route::get('/admin/documents', [AdminDocumentController::class, 'index'])->name('admin.documents.index');
        Route::get('/admin/documents/{user}', [AdminDocumentController::class, 'show'])->name('admin.documents.show');
        Route::get('/admin/documents/{user}/file/{type}', [AdminDocumentController::class, 'viewFile'])->name('admin.documents.file');
        Route::post('/admin/documents/{user}/approve', [AdminDocumentController::class, 'approve'])->name('admin.documents.approve');
        Route::post('/admin/documents/{user}/reject', [AdminDocumentController::class, 'reject'])->name('admin.documents.reject');
    });

    Route::middleware('role:proprietaire')->group(function () {
        Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
        Route::get('/seller/products', [VehiculeController::class, 'sellerProducts'])->name('seller.products');
        Route::get('/seller/products/create', [VehiculeController::class, 'create'])->name('seller.products.create');
        Route::post('/seller/products', [VehiculeController::class, 'store'])->name('seller.products.store');
        Route::get('/seller/products/{product}/edit', [VehiculeController::class, 'edit'])->name('seller.products.edit');
        Route::put('/seller/products/{product}', [VehiculeController::class, 'update'])->name('seller.products.update');
        Route::delete('/seller/products/{product}', [VehiculeController::class, 'destroy'])->name('seller.products.destroy');
    });

    Route::middleware('role:client')->group(function () {
        Route::post('/vehicules/{vehicule}/reserver', [ReservationController::class, 'store'])->name('reservations.store');
        Route::get('/my-orders', [ReservationController::class, 'myOrders'])->name('orders.my');
        Route::get('/orders/{order}/pay', [ReservationController::class, 'pay'])->name('orders.pay');
        Route::post('/orders/{order}/pay', [ReservationController::class, 'processPayment'])->name('orders.pay.process');
        Route::get('/orders/{order}/contract', [ReservationController::class, 'contract'])->name('orders.contract');
        Route::post('/orders/{order}/sign', [ReservationController::class, 'signContract'])->name('orders.sign');
        Route::put('/orders/{order}/cancel', [ReservationController::class, 'cancel'])->name('orders.cancel');
        Route::get('/documents', [DocumentController::class, 'show'])->name('documents.show');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    });

    Route::get('/reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])
        ->name('reservations.confirm')
        ->middleware('signed');

});


require __DIR__.'/auth.php';