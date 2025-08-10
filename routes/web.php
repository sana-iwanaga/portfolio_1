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
Route::get('/research', [RakutenBookController::class, 'search'])->name('research');
// Route::get('/books/quicksearch', [NdlBookController::class, 'quickSearch'])->name('books.quicksearch');
// Route::get('/books/ndl', [NdlBookController::class, 'search'])->name('books.ndl.search');
Route::get('/', [BookreviewController::class, 'index'])->name('index')->middleware('auth');
Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');
// web.php
Route::get('/books/{isbn}', [BookController::class, 'book'])->name('books.book');
Route::get('/reviews/create/{isbn}', [BookreviewController::class, 'create'])->name('reviews.create');
Route::post('/Bookreview', [BookreviewController::class, 'store'])->name('reviews.store');

Route::get('/Bookreview', [BookreviewController::class, 'Bookreview'])->name('Bookreview');
Route::get('/Home', [HomeController::class, 'Home'])->name('Home');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
