<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/login', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
// Route::get('/', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::get('/', [App\Http\Controllers\LoginController::class, 'dashboard'])->name('dashboard');
Route::post('proceed-login', [App\Http\Controllers\LoginController::class, 'login'])->name('proceed-login');
// Route::get('/', 'LoginController@showLoginForm')->name('login');
// Route::post('login', 'LoginController@login')->name('proceed-login');

// Role Super Admin
// Role Super Admin
// Role Super Admin
Route::middleware(['auth', 'checkRoleSuperAdmin'])->group(function () {
    //setting
    Route::get('/admin/setting', [App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
    Route::get('/admin/setting/create', [App\Http\Controllers\SettingController::class, 'create'])->name('setting.create');
    Route::get('/admin/setting/source', [App\Http\Controllers\SettingController::class, 'source'])->name('setting.source');
    Route::get('/admin/setting/{id}/edit', [App\Http\Controllers\SettingController::class, 'edit'])->name('setting.edit');
    Route::get('/admin/setting/{id}/show', [App\Http\Controllers\SettingController::class, 'show'])->name('setting.show');
    Route::get('/admin/setting/{id}/destroy', [App\Http\Controllers\SettingController::class, 'destroy'])->name('setting.destroy');
    Route::post('/admin/setting/store', [App\Http\Controllers\SettingController::class, 'store'])->name('setting.store');
    Route::post('/admin/setting/change', [App\Http\Controllers\SettingController::class, 'change'])->name('setting.change');
    Route::post('/admin/setting/{id}/update', [App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');

    //user
    Route::get('/admin/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/admin/user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::get('/admin/user/source', [App\Http\Controllers\UserController::class, 'source'])->name('user.source');
    Route::get('/admin/user/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::get('/admin/user/{id}/show', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');
    Route::get('/admin/user/{id}/destroy', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
    Route::post('/admin/user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::post('/admin/user/{id}/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::get('/admin/user/change', [App\Http\Controllers\UserController::class, 'change'])->name('user.change');
    Route::post('/admin/user/updatePassword', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('user.updatePassword');

    //role
    Route::get('/admin/role', [App\Http\Controllers\RoleController::class, 'index'])->name('role.index');
    Route::get('/admin/role/create', [App\Http\Controllers\RoleController::class, 'create'])->name('role.create');
    Route::get('/admin/role/source', [App\Http\Controllers\RoleController::class, 'source'])->name('role.source');
    Route::get('/admin/role/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('role.edit');
    Route::get('/admin/role/{id}/show', [App\Http\Controllers\RoleController::class, 'show'])->name('role.show');
    Route::get('/admin/role/{id}/destroy', [App\Http\Controllers\RoleController::class, 'destroy'])->name('role.destroy');
    Route::post('/admin/role/store', [App\Http\Controllers\RoleController::class, 'store'])->name('role.store');
    Route::post('/admin/role/{id}/update', [App\Http\Controllers\RoleController::class, 'update'])->name('role.update');
});

// Role Admin & Super Admin
// Role Admin & Super Admin
// Role Admin & Super Admin
Route::middleware(['auth', 'checkRoleAdminSuperAdmin'])->group(function () {
    //car
    Route::get('/admin/car/create', [App\Http\Controllers\CarController::class, 'create'])->name('car.create');
    Route::get('/admin/car/source', [App\Http\Controllers\CarController::class, 'source'])->name('car.source');
    Route::get('/admin/car/{id}/edit', [App\Http\Controllers\CarController::class, 'edit'])->name('car.edit');
    Route::get('/admin/car/{id}/show', [App\Http\Controllers\CarController::class, 'show'])->name('car.show');
    Route::get('/admin/car/{id}/destroy', [App\Http\Controllers\CarController::class, 'destroy'])->name('car.destroy');
    Route::post('/admin/car/store', [App\Http\Controllers\CarController::class, 'store'])->name('car.store');
    Route::post('/admin/car/{id}/update', [App\Http\Controllers\CarController::class, 'update'])->name('car.update');
    Route::get('/admin/car/{id}/getImage', [App\Http\Controllers\CarController::class, 'getImage'])->name('car.getImage');
    Route::get('/admin/car/{id}/destroyImage', [App\Http\Controllers\CarController::class, 'destroyImage'])->name('car.destroyImage');

    //manufacture
    Route::get('/admin/manufacture/create', [App\Http\Controllers\ManufactureController::class, 'create'])->name('manufacture.create');
    Route::get('/admin/manufacture/source', [App\Http\Controllers\ManufactureController::class, 'source'])->name('manufacture.source');
    Route::get('/admin/manufacture/{id}/edit', [App\Http\Controllers\ManufactureController::class, 'edit'])->name('manufacture.edit');
    Route::get('/admin/manufacture/{id}/show', [App\Http\Controllers\ManufactureController::class, 'show'])->name('manufacture.show');
    Route::get('/admin/manufacture/{id}/destroy', [App\Http\Controllers\ManufactureController::class, 'destroy'])->name('manufacture.destroy');
    Route::get('/admin/manufacture/getManufacture', [App\Http\Controllers\ManufactureController::class, 'getManufacture'])->name('manufacture.getManufacture');
    Route::post('/admin/manufacture/store', [App\Http\Controllers\ManufactureController::class, 'store'])->name('manufacture.store');
    Route::post('/admin/manufacture/{id}/update', [App\Http\Controllers\ManufactureController::class, 'update'])->name('manufacture.update');
    Route::get('/admin/manufacture/{id}/find', [App\Http\Controllers\ManufactureController::class, 'find'])->name('manufacture.find');
});

// Auth::routes(); ALL ROLE
Route::middleware(['auth'])->group(function () {

    //dashboard
    // Route::get('/dashboard', 'LoginController@dashboard')->name('dashboard');
    Route::get('/dashboard', [App\Http\Controllers\LoginController::class, 'dashboard'])->name('dashboard');

    //logout
    Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    //customer
    Route::get('/admin/customer', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.index');
    Route::get('/admin/customer/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('customer.create');
    Route::get('/admin/customer/source', [App\Http\Controllers\CustomerController::class, 'source'])->name('customer.source');
    Route::get('/admin/customer/{id}/edit', [App\Http\Controllers\CustomerController::class, 'edit'])->name('customer.edit');
    Route::get('/admin/customer/{id}/show', [App\Http\Controllers\CustomerController::class, 'show'])->name('customer.show');
    Route::get('/admin/customer/{id}/destroy', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('customer.destroy');
    Route::get('/admin/customer/getCustomer', [App\Http\Controllers\CustomerController::class, 'getCustomer'])->name('customer.getCustomer');
    Route::post('/admin/customer/store', [App\Http\Controllers\CustomerController::class, 'store'])->name('customer.store');
    Route::post('/admin/customer/{id}/update', [App\Http\Controllers\CustomerController::class, 'update'])->name('customer.update');

    //transaction
    Route::get('/admin/transaction', [App\Http\Controllers\TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/admin/transaction/create', [App\Http\Controllers\TransactionController::class, 'create'])->name('transaction.create');
    Route::get('/admin/transaction/history', [App\Http\Controllers\TransactionController::class, 'history'])->name('transaction.history');
    Route::get('/admin/transaction/{status}/source', [App\Http\Controllers\TransactionController::class, 'source'])->name('transaction.source');
    Route::get('/admin/transaction/{id}/edit', [App\Http\Controllers\TransactionController::class, 'edit'])->name('transaction.edit');
    Route::get('/admin/transaction/{id}/print', [App\Http\Controllers\TransactionController::class, 'print'])->name('transaction.print');
    Route::get('/admin/transaction/{id}/show', [App\Http\Controllers\TransactionController::class, 'show'])->name('transaction.show');
    Route::get('/admin/transaction/{id}/destroy', [App\Http\Controllers\TransactionController::class, 'destroy'])->name('transaction.destroy');
    Route::post('/admin/transaction/store', [App\Http\Controllers\TransactionController::class, 'store'])->name('transaction.store');
    Route::post('/admin/transaction/{id}/update', [App\Http\Controllers\TransactionController::class, 'update'])->name('transaction.update');
    Route::post('/admin/transaction/export', [App\Http\Controllers\TransactionController::class, 'export'])->name('transaction.export');
    Route::post('/admin/transaction/{id}/complete', [App\Http\Controllers\TransactionController::class, 'complete'])->name('transaction.complete');

    //car
    Route::get('/admin/car', [App\Http\Controllers\CarController::class, 'index'])->name('car.index');

    //manufacture
    Route::get('/admin/manufacture', [App\Http\Controllers\ManufactureController::class, 'index'])->name('manufacture.index');
});

// ...
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
