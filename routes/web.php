<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', function () {
    return Inertia::render('Products');
})->middleware(['auth', 'verified'])->name('products')
    ->uses('App\Http\Controllers\ProductController@index');

Route::post('/products/delete', [\App\Http\Controllers\ProductController::class, 'destroy'])
    ->middleware(['auth', 'verified'])->name('products.delete');

Route::get('/products/{product}', function () {
    return Inertia::render('ProductView');
})->middleware(['auth', 'verified'])->name('products.show')
    ->uses('App\Http\Controllers\ProductController@show');

Route::post('/products/import', [\App\Http\Controllers\ProductController::class, 'import'])
    ->middleware(['auth', 'verified'])->name('products.import');


Route::get('/articles', function () {
    return Inertia::render('Articles');
})->middleware(['auth', 'verified'])->name('articles')
    ->uses('App\Http\Controllers\ArticleController@index');

Route::post('/articles/import', [\App\Http\Controllers\ArticleController::class, 'import'])
    ->middleware(['auth', 'verified'])->name('articles.import');

require __DIR__ . '/auth.php';
