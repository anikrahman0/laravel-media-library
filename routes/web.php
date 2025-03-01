<?php

use Illuminate\Support\Facades\Route;
use Noobtrader\LaravelMediaLibrary\Http\Controllers\ImageArchiveController;

Route::post('/archive/image/upload', [ImageArchiveController::class,'uploadImgToArchive'])->name('archive.image.upload');
Route::post('/archive/image/update', [ImageArchiveController::class,'updateArchive'])->name('archive.image.update');
Route::get('/image/archive/search', [ImageArchiveController::class,'imgSearch'])->name('archive.image.search');
