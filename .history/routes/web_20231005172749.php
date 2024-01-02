<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('admin-login', [AdminController::class, 'loginPage'])->name('admin');
Route::post('admin-login', [AdminController::class, 'loginAction'])->name('admin-login');
Route::get('log-out',[AdminController::class, 'logout'])->name('logout');

Route::middleware(['custom.auth'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'adminDashboard'])->name('dashboard');
    Route::get('pages', [AdminController::class, 'pages'])->name('pages');
    Route::get('general-setting', [AdminController::class, 'generalSetting'])->name('generalSetting');
    Route::post('general-setting', [AdminController::class, 'generelSettingAction'])->name('general-setting');
    Route::get('admin-profile', [AdminController::class, 'adminProfile'])->name('profile');
    Route::post('account-update', [AdminController::class, 'accountUpdate'])->name('account-update');
});
