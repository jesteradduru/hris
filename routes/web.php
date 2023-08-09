<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Role;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('recruitment')
    ->name('recruitment.')
    ->middleware(['auth'])
    ->group(function () {
        Route::resource('job_posting', JobPostingController::class);
    });

    Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::name('dashboard')->get('dashboard', [AdminController::class, 'index']);

        Route::prefix('role_permission')
        ->name('role_permission.')
        ->group(function () {
            Route::name('index')->get('/', [RolePermissionController::class, 'index']);
            Route::resource('role', RoleController::class);
            Route::resource('permission', PermissionController::class);
        });
    });
});

require __DIR__.'/auth.php';
