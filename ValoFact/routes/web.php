<?php

//use App\Http\Controllers\{AdminController,  OrderController, ItemCategoryController, ProfileController, BidController, PublicController};
//use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\blog\{BlogCategoryController, BlogPostController};
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/', [PublicController::class, 'index'])->name('public.home');

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//Profile management routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


*/




//require __DIR__.'/auth.php';


// Serve the Vue.js app for all frontend routes
Route::get('/{any}', function () {
    return view('app'); // This will load your Vue.js app
})->where('any', '.*');


