<?php

use App\Http\Controllers\CrawlerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CrawlerController::class, 'index']);
