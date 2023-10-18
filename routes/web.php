<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\UploadTemporaryImageController;
Use App\Http\Controllers\DeleteTemporaryImageController;
Use App\Models\User;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('/upload', UploadTemporaryImageController::class);
    Route::delete('/revert', DeleteTemporaryImageController::class);

    Route::get('/posts',[PostController::class,'index'])->name('posts.index');
    Route::get('/posts/create',[PostController::class,'create'])->name('posts.create');
    Route::post('/posts',[PostController::class,'store'])->name('posts.store');
    Route::get('/posts/{post}/edit',[PostController::class,'show'])->name('posts.show');
    Route::post('/posts/update',[PostController::class,'update'])->name('posts.update');
    Route::get('/posts/{post}/delete',[PostController::class,'destroy'])->name('posts.destroy');
    Route::get('/images/{imagen}/delete',[PostController::class,'destroyimg'])->name('imagens.destroy');



    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit',[UserController::class,'show'])->name('users.show');
    Route::post('/users/update',[UserController::class,'update'])->name('users.update');
    Route::get('/users/{user}/delete',[UserController::class,'destroy'])->name('users.destroy');
});
