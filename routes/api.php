<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/copy-image/{filename}', function ($filename) {
    // Admin側の storage ディスク
    $path = Storage::disk('public')->path("goods_images/{$filename}");

    if (!file_exists($path)) {
        return response()->json(['error' => 'File not found'], 404);
    }

    // 画像データを返す
    return response()->file($path);
})->name('api.copy-image');