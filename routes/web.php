<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Professor\AnnouncementController as ProfessorAnnouncementController;
use App\Http\Controllers\Professor\UploadController as ProfessorUploadController;
use App\Http\Controllers\Professor\ScheduleController as ProfessorScheduleController;
use App\Http\Controllers\Student\DownloadController as StudentDownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnnouncementPublicController;
use App\Http\Controllers\ScheduleController as PublicScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth','professor'])->prefix('professor')->name('professor.')->group(function () {
    Route::get('/dashboard', [ProfessorController::class, 'dashboard'])->name('dashboard');
    Route::resource('announcements', ProfessorAnnouncementController::class);
    Route::resource('uploads', ProfessorUploadController::class)->only(['index','create','store','destroy']);
    Route::resource('schedules', ProfessorScheduleController::class)->except(['show']);
});

Route::middleware(['auth','student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('uploads', [StudentDownloadController::class, 'index'])->name('uploads.index');
    Route::get('uploads/{upload}/download', [StudentDownloadController::class, 'download'])->name('uploads.download');
});

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Http\Controllers\Admin\DashboardController::class)->name('dashboard');
    Route::resource('schedules', \App\Http\Controllers\Admin\ScheduleController::class)->except(['show']);
    Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Public announcement show (guest accessible)
Route::get('/announcements/{announcement}', [AnnouncementPublicController::class, 'show'])->name('public.announcements.show');

// Public schedules
Route::get('/schedule', [PublicScheduleController::class, 'index'])->name('schedule.index');
Route::get('/schedule/{schedule}/view', [PublicScheduleController::class, 'view'])->name('schedule.view');
Route::get('/schedule/{schedule}/download', [PublicScheduleController::class, 'download'])->name('schedule.download');
