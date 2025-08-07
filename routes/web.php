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
  // kalender
  Route::resource('kalender', KalenderController::class);
  // kegiatan
  Route::get('/kegiatan/add/{kegiatan}', [KegiatanController::class, 'add'])->name('kegiatan.add');
  Route::post('/kegiatan/add/{kegiatan}', [KegiatanController::class, 'store'])->name('kegiatan.store');
  Route::get('/kegiatan/{id}/view/', [KegiatanController::class, 'view'])->name('kegiatan.view');
  Route::resource('kegiatan', KegiatanController::class);
  //  guru
  Route::resource('guru', GuruController::class);
  // jadwal
  Route::resource('jadwal', JadwalController::class);
  // kelas
  Route::resource('kelas', KelasController::class)->parameters([
    'kelas' => 'kelas'
  ]);
  // mata pelajaran
  Route::resource('matapelajaran', MataPelajaranController::class);
  // santri
  Route::resource('santri', SantriController::class);
});