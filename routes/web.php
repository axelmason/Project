<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/detail/{car_id}', [HomeController::class, 'detail'])->name('detail');
Route::post('/booking', [HomeController::class, 'booking'])->name('booking');

Route::middleware('notauth')->name('auth.')->group(function() {
    Route::get('/register', [AuthController::class, 'registerPage'])->name('registerPage');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/login', [AuthController::class, 'loginPage'])->name('loginPage');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function() {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('admin')->name('admin.')->prefix('admin/')->group(function() {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('cars', [AdminController::class, 'carsPage'])->name('carsPage');

    Route::get('cars/add', [AdminController::class, 'addCarPage'])->name('addCarPage');
    Route::post('cars/add', [AdminController::class, 'addCar'])->name('addCar');

    Route::get('cars/edit/{car_id}', [AdminController::class, 'editCarPage'])->name('editCarPage');
    Route::post('cars/edit/{car_id}', [AdminController::class, 'editCar'])->name('editCar');
    Route::delete('cars/delete/{car_id}', [AdminController::class, 'deleteCar'])->name('deleteCar');

    Route::get('cars/trash', [AdminController::class, 'carTrashPage'])->name('carTrashPage');
    Route::get('cars/restore/{car_id}', [AdminController::class, 'restoreCar'])->name('restoreCar');
});
