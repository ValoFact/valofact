<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('public.home');

//Order Management Routes
Route::middleware('auth')->group(function(){
    Route::get('/create-order', [OrderController::class, 'create'])->name('order.create');
    Route::post('/create-order', [OrderController::class, 'store'])->name('order.store');
    Route::put('/order/{order}', [OrderController::class, 'update'])->name('order.update');
});



//Item's Category Management Routes
Route::get('/list-item-category', [ItemCategoryController::class, 'index'])->name('itemcategory.index');
Route::get('/create-item-category', [ItemCategoryController::class, 'create'])->name('itemcategory.create');
Route::post('/create-item-category', [ItemCategoryController::class, 'store'])->name('itemcategory.store');
Route::get('/edit-item-category/{itemCategory}', [ItemCategoryController::class, 'edit'])->name('itemcategory.edit');
Route::put('/update-item-category/{itemCategory}', [ItemCategoryController::class, 'update'])->name('itemcategory.update');
Route::delete('/delete-item-category/{itemCategory}', [ItemCategoryController::class, 'destroy'])->name('itemcategory.destroy');
Route::get('/item-categories', [ItemCategoryController::class, 'fetchItemCategories'])->name('itemcategory.fetch');








Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




//User activation route (ADMIN)
Route::get('/activateprofile/{user}', [AdminController::class, 'activateUser'])->name('activateuser');

//Profile management routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
