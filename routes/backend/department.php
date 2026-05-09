<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;

Route::resource('departments', DepartmentController::class)->middleware('permission:view department');

