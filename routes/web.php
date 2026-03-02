<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

Route::get('/assets/{path}', function ($path) {
    $fullPath = public_path('assets/' . $path);

    if (!File::exists($fullPath)) {
        abort(404);
    }

    return Response::file($fullPath, [
        'Access-Control-Allow-Origin' => 'https://omamori-frontend-react.vercel.app',
        'Access-Control-Allow-Methods' => 'GET',
        'Access-Control-Allow-Headers' => '*',
    ]);
})->where('path', '.*');