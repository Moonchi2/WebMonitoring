<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware(['auth'])->group(function () {
  // beranda
  Route::resource('dashboard', dashboardController::class);
  // users
  Route::resource('user', UsersController::class);
  // Profile
  Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
  Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::post('/profile/update/{user}', [ProfileController::class, 'update'])->name('profile.update');
  Route::get('profile/change-password', [ProfileController::class, 'changePasswordForm'])->name('profile.change-password-form');
  Route::post('profile/change-password/{user}', [ProfileController::class, 'changePassword'])->name('profile.change-password');
  Route::resource('kalender', KalenderController::class);
  Route::resource('kegiatan', KegiatanController::class);
  Route::resource('guru', GuruController::class);
  Route::resource('jadwal', JadwalController::class);
  Route::resource('kelas', KelasController::class)->parameters([
    'kelas' => 'kelas'
  ]);
  Route::resource('matapelajaran', MataPelajaranController::class);
  Route::resource('santri', SantriController::class);
});