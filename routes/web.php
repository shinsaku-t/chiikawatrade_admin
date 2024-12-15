<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/copy-image/{filename}', function ($filename) {
    $path = storage_path("app/public/goods_images/{$filename}"); // ファイルのフルパス

    if (!file_exists($path)) {
        return response()->json(['error' => 'File not found'], 404);
    }

    return response()->file($path); // ファイルを返す
})->name('copy-image');