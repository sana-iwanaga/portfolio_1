<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookreviewController;
// use App\Http\Controllers\NdlBookController;
use App\Http\Controllers\RakutenBookController;
use App\Http\Controllers\BookController;
use App\Models\Bookreview;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BooklogController;

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
Route::get('/', [BooklogController::class, 'booklogsall'])->name('index')->middleware('auth');
Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');
// web.php
Route::get('/books/{isbn}', [BookController::class, 'book'])->name('books.book');
Route::get('/reviews/create/{isbn}', [BookreviewController::class, 'create'])->name('reviews.create');
Route::get('/Bookreview', [BookreviewController::class, 'index'])->name('reviews.index');
Route::post('/Bookreview', [BookreviewController::class, 'store'])->name('reviews.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
Route::get('/home', [HomeController::class, 'latestBooklog'])->name('home')->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::get('/booklogs', [BooklogController::class, 'booklogsall'])->name('booklogs.index');
    Route::get('/allbooklogs', [BooklogController::class, 'booklogsindex'])->name('booklogs.all');
    Route::post('/booklogs', [BooklogController::class, 'store'])->name('booklogs.store');
    Route::patch('/booklogs/{id}/status', [BooklogController::class, 'updateStatus'])->name('booklogs.updateStatus');
    Route::delete('/booklogs/{id}', [BooklogController::class, 'destroy'])->name('booklogs.destroy');
});

require __DIR__.'/auth.php';
