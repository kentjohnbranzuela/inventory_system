<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/test-middleware', function () {
    return 'Middleware exists!';
})->middleware(AdminMiddleware::class);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/inventory/reports', [InventoryController::class, 'reports'])->name('inventory.reports');
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');

    // Move this route above the dynamic one
Route::delete('/admin/inventory/delete-all', [InventoryController::class, 'destroyAll'])
    ->name('inventory.destroyAll');
    Route::resource('/admin/inventory', InventoryController::class)->except(['show']);
    Route::get('/admin/inventory/{inventory}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/admin/inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::delete('/admin/inventory/{id}/delete', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::patch('/admin/inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::get('admin/inventory/reports', [InventoryController::class, 'reports'])->name('inventory.reports');
Route::get('admin/inventory/reports/export', [InventoryController::class, 'export'])->name('inventory.reports.export');
});

Route::get('/inventory/generateCode', function () {
    return response()->json(['item_code' => \App\Models\Inventory::getNextItemNumber()]);
})->name('inventory.generateCode');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/session-test', function () {
    session(['key' => 'Session is working!']);
    return session('key', 'Session not working!');
});
require __DIR__.'/auth.php';
