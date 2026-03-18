<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\PublisherController;

Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');


Route::get('/books', [BooksController::class, 'index'])->name('books.index');
Route::get('/books/create', [BooksController::class, 'create'])->name('books.create');




// Publisher Routes
Route::get('/publishers', [PublisherController::class, 'index'])->name('publishers.index');

Route::get('/publishers/create', [PublisherController::class, 'create'])->name('publishers.create');

Route::post('/publishers/store', [PublisherController::class, 'store'])->name('publishers.store');

Route::get('/publishers/edit/{id}', [PublisherController::class, 'edit'])->name('publishers.edit');

Route::put('/publishers/update/{id}', [PublisherController::class, 'update'])->name('publishers.update');

Route::delete('/publishers/delete/{id}', [PublisherController::class, 'destroy'])->name('publishers.destroy');
