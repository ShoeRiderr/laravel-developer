<?php

use App\Http\Controllers\Api\GolferController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('golfers', GolferController::class, [
    'only' => ['index'],
]);


Route::get('/golfers/download', [GolferController::class, 'downloadCsv']);
