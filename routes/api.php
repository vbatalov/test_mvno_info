<?php

use App\Http\Controllers\Api\BalanceTransferController;
use App\Http\Middleware\JsonResponseMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(JsonResponseMiddleware::class)->group(function () {
    Route::post("balance-transfer", BalanceTransferController::class)
        ->name("balance-transfer");

});
