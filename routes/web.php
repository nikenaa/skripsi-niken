<?php

use App\Http\Controllers\AdminAbsenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminKelasController;
use App\Http\Controllers\AdminSiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaAbsenController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [AuthController::class, 'index']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/install', [AuthController::class, 'install']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::resource('/admin', AdminController::class)->middleware('is_admin');
Route::post('/password_admin/{admin:id}', [AdminController::class, 'password']);

Route::get('/data_karyawan', [AdminSiswaController::class, 'data_karyawan'])->middleware('is_admin');
Route::resource('/admin/karyawan', AdminSiswaController::class)->middleware('is_admin');

Route::get('/data_project', [AdminKelasController::class, 'index'])->middleware('is_admin');
Route::resource('/admin/project', AdminKelasController::class)->middleware('is_admin');

Route::get('/data_absensi', [AdminAbsenController::class, 'index'])->middleware('is_admin');
Route::resource('/admin/absensi', AdminAbsenController::class)->middleware('is_admin');
Route::post('/admin/sudah_absen', [AdminAbsenController::class, 'sudah_absen'])->middleware('is_admin');
Route::post('/admin/sudah_absen_keluar', [AdminAbsenController::class, 'sudah_absen_keluar'])->middleware('is_admin');
Route::post('/admin/belum_absen', [AdminAbsenController::class, 'belum_absen'])->middleware('is_admin');
Route::post('/admin/belum_absen_keluar', [AdminAbsenController::class, 'belum_absen_keluar'])->middleware('is_admin');
Route::get('/admin/cetakqr/{kode}', [AdminAbsenController::class, 'cetakqr'])->middleware('is_admin');
Route::get('/admin/cetak/{absensi:kode}', [AdminAbsenController::class, 'cetak'])->middleware('is_admin');
Route::get('/admin/detail/{absensi:kode}', [AdminAbsenController::class, 'detail'])->middleware('is_admin');
Route::get('/admin/absensi_keluar/{absensi:kode}', [AdminAbsenController::class, 'show_keluar'])->middleware('is_admin');
Route::get('/admin/izin/{absensi:kode}', [AdminAbsenController::class, 'izin'])->middleware('is_admin');
Route::get('/suket_izin/{suket}', [AdminAbsenController::class, 'suket'])->middleware('is_admin');
Route::get('/izinkan/{absensidetail:id}', [AdminAbsenController::class, 'izinkan'])->middleware('is_admin');


Route::get('/siswa_dashboard', [SiswaController::class, 'index'])->middleware('is_siswa');
Route::get('/siswa_profile', [SiswaController::class, 'profile'])->middleware('is_siswa');
Route::post('/siswa_profile', [SiswaController::class, 'edit'])->middleware('is_siswa');
Route::post('/siswa/password/{siswa:id}', [SiswaController::class, 'password'])->middleware('is_siswa');

Route::resource('/siswa/absensi', SiswaAbsenController::class)->middleware('is_siswa');
Route::get('/siswa/riwayat/absensi', [SiswaAbsenController::class, 'history'])->middleware('is_siswa');
Route::post('/siswa/absen_masuk', [SiswaAbsenController::class, 'absen_masuk'])->middleware('is_siswa');
Route::get('/siswa/absensi_keluar/{absensi:kode}', [SiswaAbsenController::class, 'show_keluar'])->middleware('is_siswa');
Route::post('/siswa/absen_keluar', [SiswaAbsenController::class, 'absen_keluar'])->middleware('is_siswa');

Route::get('/siswa/izin/{absensi:kode}', [SiswaAbsenController::class, 'izin'])->middleware('is_siswa');
Route::post('/siswa/izin/{absensi:kode}', [SiswaAbsenController::class, 'izin_'])->middleware('is_siswa');
Route::get('/siswa/suket/{suket}', [SiswaAbsenController::class, 'suket'])->middleware('is_siswa');
