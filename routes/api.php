<?php

declare(strict_types=1);

use App\Http\Controllers\Author\AuthorController;
use Illuminate\Support\Facades\Route;

Route::resource('authors', AuthorController::class)
    ->only(['store']);
