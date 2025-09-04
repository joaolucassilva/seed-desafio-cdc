<?php

declare(strict_types=1);

use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Category\CategoryController;
use Illuminate\Support\Facades\Route;

Route::resource('authors', AuthorController::class)
    ->only(['store'])
    ->names('authors');

Route::resource('categories', CategoryController::class)
    ->only(['store'])
    ->names('categories');
