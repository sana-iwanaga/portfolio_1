<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookreviewController;
// use App\Http\Controllers\NdlBookController;
use App\Http\Controllers\RakutenBookController;
use App\Http\Controllers\BookController;
use App\Models\Bookreview;
use App\Http\Controllers\HomeController;

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
Route::get('/Books_research', [RakutenBookController::class, 'search'])->name('Books_research');
// Route::get('/books/quicksearch', [NdlBookController::class, 'quickSearch'])->name('books.quicksearch');
// Route::get('/books/ndl', [NdlBookController::class, 'search'])->name('books.ndl.search');
Route::get('/', [BookreviewController::class, 'index'])->name('index')->middleware('auth');
Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');
// web.php
Route::get('/books/{isbn}', [BookController::class, 'book'])->name('books.show');
Route::get('/reviews/create/{isbn}', [BookreviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews', [BookreviewController::class, 'store'])->name('reviews.store');

Route::get('/Review_Posts', [BookreviewController::class, 'Review_Posts'])->name('Review_Posts');
Route::get('/Home', [HomeController::class, 'Home'])->name('Home');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
