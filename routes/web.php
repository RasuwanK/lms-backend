<?php

use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Route;

//Route::get('/users', [UserController::class, 'getUserInfo']);

Route::fallback(function() {
    return ResponseHelper::notFound();
});
