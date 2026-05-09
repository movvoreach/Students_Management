<?php
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;


Route::prefix('subjects')
    ->name('subjects.')
    ->controller(SubjectController::class)
    ->group(function () {

        // ================= VIEW =================
        Route::get('/', 'index')
            ->middleware('permission:view subject')
            ->name('index');

        Route::get('/{subject}', 'show')
            ->middleware('permission:view subject')
            ->name('show');

        // ================= CREATE =================
        Route::get('/create', 'create')
            ->middleware('permission:create subject')
            ->name('create');

        Route::post('/', 'store')
            ->middleware('permission:create subject')
            ->name('store');

        // ================= EDIT =================
        Route::get('/{subject}/edit', 'edit')
            ->middleware('permission:edit subject')
            ->name('edit');

        Route::put('/{subject}', 'update')
            ->middleware('permission:edit subject')
            ->name('update');

        // ================= DELETE =================
        Route::delete('/{subject}', 'destroy')
            ->middleware('permission:delete subject')
            ->name('destroy');
    });
