<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgenteController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\XmlFileController;
use App\Http\Controllers\DatatableController;
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
    ->middleware(['auth', 'verified'])->names('dashboard.users');

Route::resource('/dashboard/roles', RoleController::class)->except('show')
    ->middleware(['auth', 'verified'])->names('dashboard.roles');

Route::resource('/dashboard/ocomerciales', OcomercialeController::class)
    ->middleware(['auth', 'verified'])->names('dashboard.ocomerciales');

Route::resource('/dashboard/clientes', ClienteController::class)
    ->middleware(['auth', 'verified'])->names('dashboard.clientes');

Route::resource('/dashboard/agentes', AgenteController::class)
    ->middleware(['auth', 'verified'])->names('dashboard.agentes');

Route::match(['put', 'patch'], '/dashboard/agentes/addCliente/{agente}', [AgenteController::class, 'addCliente'])->name('dashboard.agentes.addCliente');
Route::match(['put', 'patch'], '/dashboard/agentes/removeCliente/{agente}', [AgenteController::class, 'removeCliente'])->name('dashboard.agentes.removeCliente');


Route::get('/dashboard', function () {
    return view('panel_admin');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard/xmlfiles', [XmlFileController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard.xmlfile');

Route::post('/dashboard/file/clientes', [XmlFileController::class, 'clientes'])->middleware(['auth', 'verified'])->name('dashboard.file.clientes');
Route::post('/dashboard/file/facturas', [XmlFileController::class, 'facturas'])->middleware(['auth', 'verified'])->name('dashboard.file.facturas');
Route::post('/dashboard/file/agentes', [XmlFileController::class, 'agentes'])->middleware(['auth', 'verified'])->name('dashboard.file.agentes');
Route::get('/dashboard/file/vaciarFacturas', [XmlFileController::class, 'vaciarFacturas'])->middleware(['auth', 'verified'])->name('dashboard.file.vaciarFacturas');


Route::get('datatable/clientes', [DatatableController::class, 'clientes'])->name('datatable.clientes');
Route::get('datatable/agentes', [DatatableController::class, 'agentes'])->name('datatable.agentes');
Route::get('datatable/clientes-agente/{agente}', [DatatableController::class, 'clientes_agente'])->name('datatable.cliente-agente');

Route::get('/dashboard/select/clientes', [AgenteController::class, 'selectClientes'])->name('dashboard.select.clientes');


// Route::get('/progress', [XmlFileController::class, 'getUploadProgress']);

require __DIR__ . '/auth.php';
