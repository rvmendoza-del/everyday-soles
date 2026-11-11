
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SettingsController;


// =====================================
// LOGIN AND REGISTRATION
// =====================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

});


// =====================================
// LOGOUT
// =====================================

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// =====================================
// ADMIN PROTECTED PAGES
// =====================================

Route::middleware(['auth', 'admin'])->group(function () {


    // =================================
    // DASHBOARD
    // =================================

    Route::get('/', function () {
        return view('welcome');
    })->name('home');


    // =================================
    // PRODUCT DATA AND INVENTORY TREND
    // =================================

    Route::get('/products/data', [ProductController::class, 'data'])
        ->name('products.data');

    Route::get('/inventory/trend', [ProductController::class, 'trend'])
        ->name('inventory.trend');


    // =================================
    // PRODUCT MANAGEMENT
    // =================================

    Route::resource('products', ProductController::class);


    // =================================
    // REPORTS
    // =================================

    Route::get('/reports', [ReportsController::class, 'index'])
        ->name('reports.index');


    // =================================
    // USERS MANAGEMENT
    // =================================

    Route::get('/users', [UsersController::class, 'index'])
        ->name('users.index');

    Route::patch('/users/{id}/role', [UsersController::class, 'updateRole'])
        ->name('users.updateRole');

    Route::delete('/users/{id}', [UsersController::class, 'destroy'])
        ->name('users.destroy');


    // =================================
    // SETTINGS MANAGEMENT
    // =================================

    Route::get('/settings', [SettingsController::class, 'index'])
        ->name('settings.index');

    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])
        ->name('settings.profile.update');

    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])
        ->name('settings.password.update');

});
