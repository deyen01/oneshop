<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediafileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index']);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/products/{product}/favadd', [ProductController::class, 'favadd'])->name('products.favadd');
    Route::get('/products/{product}/favdel', [ProductController::class, 'favdel'])->name('products.favdel');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/categories/{category}/setpicture', [CategoryController::class, 'setpicture'])->name('categories.setpicture');
    Route::get('/products/{product}/setpicture', [ProductController::class, 'setpicture'])->name('products.setpicture');
    Route::post('/mediafiles/attach', [MediafileController::class, 'attach'])->name('mediafiles.attach');
    Route::resources([
        'mediafiles' => MediafileController::class,
        'categories' => CategoryController::class,
        'products' => ProductController::class,
        'products.comments' => CommentController::class,
        'comments' => CommentController::class,
        'users' => UserController::class,
    ]);
});