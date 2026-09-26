<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\EnquiryController;
use Illuminate\Support\Facades\Route;

// Admin authentication (public)
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

// Protected admin routes
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Enquiries
    Route::get('/enquiries', [\App\Http\Controllers\Backend\EnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('/enquiries/{enquiry}', [\App\Http\Controllers\Backend\EnquiryController::class, 'show'])->name('enquiries.show');
    Route::patch('/enquiries/{enquiry}/toggle-read', [\App\Http\Controllers\Backend\EnquiryController::class, 'toggleRead'])->name('enquiries.toggle-read');
    Route::delete('/enquiries/{enquiry}', [\App\Http\Controllers\Backend\EnquiryController::class, 'destroy'])->name('enquiries.destroy');

    // CMS Resources
    Route::resource('products', \App\Http\Controllers\Backend\ProductController::class)->except('show');
    Route::resource('services', \App\Http\Controllers\Backend\ServiceController::class)->except('show');
    Route::resource('materials', \App\Http\Controllers\Backend\MaterialController::class)->except(['create', 'store', 'show', 'destroy']);
    Route::resource('hero-stories', \App\Http\Controllers\Backend\HeroStoryController::class)->except('show');
    Route::get('company', [\App\Http\Controllers\Backend\CompanyController::class, 'edit'])->name('company.edit');
    Route::put('company', [\App\Http\Controllers\Backend\CompanyController::class, 'update'])->name('company.update');
    Route::resource('certifications', \App\Http\Controllers\Backend\CertificationController::class)->except('show');
    Route::resource('pages', \App\Http\Controllers\Backend\PageController::class)->except(['create', 'store', 'show', 'destroy']);
});
