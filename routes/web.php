<?php

use App\Http\Controllers\DailyTimeRecordController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\LndFormController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\PDS\ExportPdsController;
use App\Http\Controllers\Profile\RewardAndRecognitionController;
use App\Http\Controllers\Profile\SpmsController;
use App\Http\Controllers\ProfileController;
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
    return Inertia::render('Dashboard');
})->name('dashboard');

// Routes for Recruiment Page
Route::prefix('recruitment')
->name('recruitment.')
->group(function () {
    Route::resource('job_posting', JobPostingController::class)->only(['index', 'show']);
    //Route::name('job_posting.apply')->get('/job_posting/{job_posting}/apply', [JobApplicationController::class, 'create']);
});

// Job Application
Route::resource('job_application', JobApplicationController::class)->middleware(['auth']);


//export pds
Route::name('pds.export')->get('pds/export', ExportPdsController::class);



Route::middleware('auth')->group(function () {
    // notifications
    Route::resource('notification', NotificationController::class)->only(['index']);
    Route::name('notification.seen')->put('notification/{notification}/seen', NotificationSeenController::class);
    // end of notifications

    
    Route::prefix('profile')
    ->name('profile.')
    ->group(function () {
        Route::get('/settings', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::get('/', [ProfileController::class, 'index'])->name('index');

        Route::resource('rewards', RewardAndRecognitionController::class);
        Route::resource('spms', SpmsController::class);
    });

    // lnd forms
    Route::resource('lnd_forms', LndFormController::class);

    Route::resource('daily_time_record', DailyTimeRecordController::class);
});

require __DIR__.'/auth.php';
require __DIR__.'/pds.php';
require __DIR__.'/admin.php';
