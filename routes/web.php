<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

    Route::redirect('/', '/login');
//admin custom login page
 Route::get('/admin/login', [ProfileController::class, 'adminlogin']);
 //admin custom register page
 Route::get('/admin/register', [ProfileController::class, 'adminregister']);




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');;
    Route::resource('employees', EmployeeController::class);
    Route::resource('admins', UserController::class);


require __DIR__.'/auth.php';


//admin side all routes
// this html form all file for view form only and copy from here 
 Route::get('/admin/profile', [AdminDashboardController::class, 'adminprofile']);
 //admin custom profile edit 
 Route::get('/admin/custom/profile', [AdminDashboardController::class, 'customedit'])->name('profile.customedit');
 //admin custom pass edit custompassedit
Route::get('/admin/custom/edit', [AdminDashboardController::class, 'custompassedit'])->name('profile.custompassedit');
//admin dashbar setting route
Route::get('/admin/custom/setting', [AdminDashboardController::class, 'setting'])->name('profile.setting');