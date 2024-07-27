<?php

use App\Http\Controllers\AjuanMagangController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BuktiDokumenController;
use App\Http\Controllers\CetakDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataAjuanMahasiswaController;
use App\Http\Controllers\DataBuktiController;
use App\Http\Controllers\DataSelesaiMagangController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ManajemenUser\AdminController;
use App\Http\Controllers\ManajemenUser\CDCController;
use App\Http\Controllers\ManajemenUser\DekanatController;
use App\Http\Controllers\ManajemenUser\DosenController;
use App\Http\Controllers\ManajemenUser\MahasiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SelesaiMagangController;
use App\Http\Controllers\TamplateController;
use App\Http\Controllers\UnitController;
use App\Models\AjuanMagang;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('landingpage');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth/login');
    })->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('prosesLogin');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register/post', [RegisterController::class, 'register'])->name('register.post');
});

//mahasiswa
Route::middleware(['auth'])->group(function () {

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settingsUpdate', [AdminController::class, 'settingsUpdate'])->name('settingsUpdate');


    Route::prefix('/')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/pengajuanmagang', [AjuanMagangController::class, 'index'])->name('pengajuanmahasiswa');
        Route::post('/ajuan', [AjuanMagangController::class, 'store'])->name('ajuan');
    });

    //Superadmin-cdc
    Route::prefix('/dataprodi')->name('dataprodi.')->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('index');
        Route::post('/store', [UnitController::class, 'store'])->name('store');
        Route::put('/update/{id}', [UnitController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UnitController::class, 'destroy'])->name('delete');
    });

    //Manajemen User

    //Mahasiswa
    Route::prefix('/datamahasiswa')->name('datamahasiswa.')->group(function () {
        Route::get('/', [MahasiswaController::class, 'index'])->name('index');
        Route::post('/store', [MahasiswaController::class, 'store'])->name('store');
        Route::put('/update/{id}', [MahasiswaController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [MahasiswaController::class, 'destroy'])->name('delete');
        Route::get('/ubahstatus/{id}', [MahasiswaController::class, "ubahstatus"])->name('ubahstatus');
    });

    //Tim CDC
    Route::prefix('/datatimcdc')->name('datatimcdc.')->group(function () {
        Route::get('/', [CDCController::class, 'index'])->name('index');
        Route::post('/store', [CDCController::class, 'store'])->name('store');
        Route::put('/update/{id}', [CDCController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CDCController::class, 'destroy'])->name('delete');
        Route::get('/ubahstatus/{id}', [CDCController::class, "ubahstatus"])->name('ubahstatus');
    });

    //Admin
    Route::prefix('/dataadmin')->name('dataadmin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::post('/store', [AdminController::class, 'store'])->name('store');
        Route::put('/update/{id}', [AdminController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('delete');
        Route::get('/ubahstatus/{id}', [AdminController::class, "ubahstatus"])->name('ubahstatus');
    });

    Route::prefix('/template',)->name('tamplate.')->group(function() {
        Route::get('/', [TamplateController::class, 'index'])->name('index');
        Route::put('/update/{id}', [TamplateController::class, 'update'])->name('update');
    });

    //Dekanat
    Route::prefix('/datadekanat')->name('datadekanat.')->group(function () {
        Route::get('/', [DekanatController::class, 'index'])->name('index');
        Route::post('/store', [DekanatController::class, 'store'])->name('store');
        Route::put('/update/{id}', [DekanatController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [DekanatController::class, 'destroy'])->name('delete');
        Route::get('/ubahstatus/{id}', [DekanatController::class, "ubahstatus"])->name('ubahstatus');
    });

    //Dosen Pembimbing
    Route::prefix('/datadosen')->name('datadosen.')->group(function () {
        Route::get('/', [DosenController::class, 'index'])->name('index');
        Route::post('/store', [DosenController::class, 'store'])->name('store');
        Route::put('/update/{id}', [DosenController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [DosenController::class, 'destroy'])->name('delete');
        Route::get('/ubahstatus/{id}', [DosenController::class, "ubahstatus"])->name('ubahstatus');
    });

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    //Ajuan Magang
    Route::prefix('/datapengajuan')->name('datapengajuan.')->group(function () {
        Route::get('/', [DataAjuanMahasiswaController::class, 'index'])->name('index');
        Route::put('/update/{id}', [DataAjuanMahasiswaController::class, 'update'])->name('update');
        Route::put('admin/update/{id}', [DataAjuanMahasiswaController::class, 'store'])->name('store');
        Route::put('approve/{id}', [DataAjuanMahasiswaController::class, 'approve'])->name('approve');
        Route::delete('/delete/{id}', [DataAjuanMahasiswaController::class, 'delete'])->name('delete');
        Route::put('/upload/{id}', [DataAjuanMahasiswaController::class, 'upload'])->name('upload');
        Route::put('/selesaiMagang/{id}', [SelesaiMagangController::class, 'update'])->name('selesaiMagang');
    });

    Route::get('/success', [AjuanMagangController::class, 'success'])->name('viewsuccess');

    //Dokumen
    Route::prefix('/dokumenmagang')->name('dokumenmagang.')->group(function () {
        Route::get('/', [BuktiDokumenController::class, 'index'])->name('index');
        Route::put('/store/{id}', [BuktiDokumenController::class, 'store'])->name('store');
        Route::get('/get/databukti', [DataBuktiController::class, 'bukti'])->name('bukti');
        Route::put('/surat-tugas/{id}', [DataAjuanMahasiswaController::class, 'surattugas'])->name('surattugas');
    });

    //Profile
    Route::get('/profile/edit', [ProfileController::class, 'profileDosen'])->name('editprofile');
    Route::post('/profile/update', [ProfileController::class, 'insertProfile'])->name('profileUpdate');


    // Update Nilai Magang
    Route::post('/updateNilai/{id}', [SelesaiMagangController::class, 'updateNilai'])->name('updateNilai');
    Route::post('/updateLaporanAkhir/{id}', [SelesaiMagangController::class, 'updateLaporanAkhir'])->name('updateLaporanAkhir');
    Route::post('/suratSelesai/{id}', [SelesaiMagangController::class, 'suratSelesai'])->name('suratSelesai');
});
//Cetak Data Pengajuan
Route::prefix('/cetakdata')->name('cetakdata.')->group(function () {
    Route::get('/', [CetakDataController::class, 'index'])->name('index');
    Route::get('/export-dataajuan', [CetakDataController::class, 'export'])->name('export.dataajuan');
});

    Route::get('/get-categories', [AjuanMagangController::class, 'getCategories']);
    Route::get('/get-instansi', [AjuanMagangController::class, 'getInstansi']);


    Route::get('/pengantar/export-docx/{id}', [DataAjuanMahasiswaController::class, 'exportDocxPengantar'])->name('export.docx.pengantar');
    Route::get('/tugas/export-docx/{id}', [DataAjuanMahasiswaController::class, 'exportDocxTugas'])->name('export.docx.tugas');
