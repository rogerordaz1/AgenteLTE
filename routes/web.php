<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\OcomercialeController;

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
    return view('auth.login');
});

Route::resource('/dashboard/users', UserController::class)
->middleware(['auth' , 'verified'])->names('dashboard.users');

Route::resource('/dashboard/roles', RoleController::class)->except('show')
->middleware(['auth' , 'verified'])->names('dashboard.roles');

Route::resource('/dashboard/ocomerciales', OcomercialeController::class)
->middleware(['auth' , 'verified'])->names('dashboard.ocomerciales');


Route::get('/dashboard', function () {
    return view('panel_admin');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
