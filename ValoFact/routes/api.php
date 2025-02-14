<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\blog\BlogPostController; 
use app\Http\Controllers\blog\BlogCategoryController;
use app\Http\Controllers\{OrderController, BidController, ItemCategoryController, AdminController};
use App\Http\Controllers\Auth\{RegisterController, LoginController, LogoutController, EmailVerificationController, PasswordResetController};


// Public routes (no authentication)
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [PasswordResetController::class, 'reset']);
// Protected routes (require Sanctum token)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::post('/email/verify', [EmailVerificationController::class, 'verify']);
    Route::post('/email/resend', [EmailVerificationController::class, 'resend']);
});



//Order Management Routes
Route::get('/orders', 'App\Http\Controllers\OrderController@index');
Route::get('/orders/{id}', 'App\Http\Controllers\OrderController@show');
/*
Route::middleware('auth')->group(function(){
    //Route::get('/create-order', [OrderController::class, 'create'])->name('order.create');
    Route::post('/create-order', [OrderController::class, 'store'])->name('order.store');
    Route::put('/order/{order}', [OrderController::class, 'update'])->name('order.update');
});


//Bid Management Routes
Route::middleware('auth')->group(function(){
    Route::get('/store-bid-{bid}', [BidController::class, 'store'])->name('bid.store');
});



//Item's Category Management Routes
/*
Route::get('/item-categories', [ItemCategoryController::class, 'index'])->name('itemcategory.index');
Route::get('/create-item-category', [ItemCategoryController::class, 'create'])->name('itemcategory.create');
Route::post('/create-item-category', [ItemCategoryController::class, 'store'])->name('itemcategory.store');
Route::get('/edit-item-category/{itemCategory}', [ItemCategoryController::class, 'edit'])->name('itemcategory.edit');
Route::put('/update-item-category/{itemCategory}', [ItemCategoryController::class, 'update'])->name('itemcategory.update');
Route::delete('/delete-item-category/{itemCategory}', [ItemCategoryController::class, 'destroy'])->name('itemcategory.destroy');
Route::get('/item-categories', [ItemCategoryController::class, 'fetchItemCategories'])->name('itemcategory.fetch');
*/





//Blog's Category Management Routes
/*
Route::get('/blog-categories', [BlogCategoryController::class, 'index'])->name('category.index');
Route::get('/create-blog-category', [BlogCategoryController::class, 'create'])->name('category.create');
Route::post('/create-blog-category', [BlogCategoryController::class, 'store'])->name('category.store');
Route::get('/edit-blog-category/{blogCategory}', [BlogCategoryController::class, 'edit'])->name('category.edit');
Route::put('/update-blog-category/{blogCategory}', [BlogCategoryController::class, 'update'])->name('category.update');
Route::delete('/delete-blog-category/{blogCategory}', [BlogCategoryController::class, 'destroy'])->name('category.destroy');
*/


//Blog's Post Management Routes
Route::get('/blog-posts/{id}', 'App\Http\Controllers\blog\BlogPostController@show');
Route::get('/blog-posts', 'App\Http\Controllers\blog\BlogPostController@index');





/*
Route::get('/create-blog-post', [BlogPostController::class, 'create'])->name('post.create');
Route::post('/create-blog-post', [BlogPostController::class, 'store'])->name('post.store');
Route::get('/edit-blog-post/{blogPost}', [BlogPostController::class, 'edit'])->name('post.edit');
Route::put('/update-blog-post/{blogPost}', [BlogPostController::class, 'update'])->name('post.update');
Route::delete('/delete-blog-post/{blogPost}', [BlogPostController::class, 'destroy'])->name('post.destroy');
*/




















//User activation route (ADMIN)
Route::get('/activateprofile/{user}', 'App\Http\Controllers\AdminController@activateUser')->name('activateuser');

//Check Authentication
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});