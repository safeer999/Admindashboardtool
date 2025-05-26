<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmailVerifierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SingleEmailVerifyController;
use App\Http\Controllers\BulkEmailVerifyController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;



    
//admin custom login page
 Route::get('/admin/login', [ProfileController::class, 'adminlogin']);
 //admin custom register page
 Route::get('/admin/register', [ProfileController::class, 'adminregister']);

 // middleware for auth profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// middleware for  role= admin
Route::middleware(['auth', 'role:admin'])->group(function () {
      Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
     //admin custom profile edit 
 Route::get('/admin/custom/profile', [AdminDashboardController::class, 'customedit'])->name('profile.customedit');
 //admin custom pass edit custompassedit
 Route::get('/admin/custom/edit', [AdminDashboardController::class, 'custompassedit'])->name('profile.custompassedit');
//admin dashbar setting route
 Route::get('/admin/custom/setting', [AdminDashboardController::class, 'setting'])->name('profile.setting');
  Route::resource('employees', EmployeeController::class);
   Route::resource('emailverify', EmailVerifierController::class);
   Route::resource('students', StudentController::class);
    Route::resource('admins', UserController::class);
});

// middleware for  role= user
// Route::middleware(['auth', 'role:user'])->group(function () {
//     //Route::get('/', fn() => view('frontend.index'));
// });

require __DIR__.'/auth.php';


//admin side all routes
// this html form all file for view form only and copy from here 
 Route::get('/admin/profile', [AdminDashboardController::class, 'adminprofile']);




 // Public user page (frontend) for everyone
Route::get('/', [UserController::class, 'index'])->name('frontend.home');


//single email verify routes
Route::post('/single/verify', [SingleEmailVerifyController::class, 'signleverify'])->name('single.verify');
// Bulk email file upload
 Route::post('/bulk-email-verifier/upload', [BulkEmailVerifyController::class, 'handleUploadAndVerify'])->name('bulk.upload.verify');
 // bulk test index fiel 
 Route::get('/bulk/index', [BulkEmailVerifyController::class, 'index'])->name('bulk.index');
 //show live progress baar

Route::get('/bulk-verification/{task}/progress', [BulkEmailVerifyController::class, 'getTaskProgress'])->name('bulk.progress');