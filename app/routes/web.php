<?php

use App\Http\Controllers\MileageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserSettingsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Dashboard (requires auth & verified)
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Mileage module routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])
    ->prefix('mileage')
    ->name('mileage.')
    ->group(function () {
        // Pages
        Route::get('/', [MileageController::class, 'index'])->name('index');
        Route::get('/list', [MileageController::class, 'list'])->name('list');
        Route::get('/vehicles', [MileageController::class, 'vehicles'])->name('vehicles');
        Route::get('/organizations', [MileageController::class, 'organizations'])->name('organizations');
        Route::get('/routes', [MileageController::class, 'routes'])->name('routes');

        // API endpoints
        Route::prefix('api')->name('api.')->group(function () {
            Route::get('/companies', [MileageController::class, 'getCompanies'])->name('companies');
            Route::get('/drivers', [MileageController::class, 'getDrivers'])->name('drivers');
            Route::get('/addresses', [MileageController::class, 'getAddresses'])->name('addresses');
        });
    });

// Redirect /mileage to /mileage/list for better UX
Route::redirect('/mileage', '/mileage/list')->middleware(['auth', 'verified']);

/*
|--------------------------------------------------------------------------
| Profile & User Settings
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Settings
    Route::prefix('settings')->group(function () {
        Route::patch('/language', [UserSettingsController::class, 'updateLanguage'])->name('settings.language.update');
    });
});

/*
|--------------------------------------------------------------------------
| Debug routes
|--------------------------------------------------------------------------
*/
Route::get('/debug', function () {
    $value = 42;
    return 'debug: ' . $value;
});

/*
|--------------------------------------------------------------------------
| Auth routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
