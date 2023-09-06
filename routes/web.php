<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Product\ProductController;
//use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.profile');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

//User Management
Route::resource('user', UserController::class);

//User Management
Route::resource('category', CategoryController::class);

//Product Management
Route::resource('product', ProductController::class);
Route::resource('order', OrderController::class);

require __DIR__.'/auth.php';