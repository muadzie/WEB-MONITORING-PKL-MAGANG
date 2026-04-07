<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ==================== AUTHENTICATION ROUTES ====================
// Jetstream sudah menyediakan route login, register, dll

// ==================== PROTECTED ROUTES ====================
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Notifikasi
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', [NotifikasiController::class, 'index'])->name('index');
        Route::post('/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('read-all');
        Route::delete('/{id}', [NotifikasiController::class, 'destroy'])->name('destroy');
    });
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/photo', [ProfileController::class, 'updatePhoto'])->name('photo');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
    });
    
    // Approval Routes
    Route::prefix('approval')->name('approval.')->group(function () {
        Route::post('/logbook/dosen/{logbook}', [ApprovalController::class, 'approveLogbookDosen'])->name('logbook.dosen');
        Route::post('/logbook/pt/{logbook}', [ApprovalController::class, 'approveLogbookPt'])->name('logbook.pt');
        Route::post('/laporan/{laporan}', [ApprovalController::class, 'reviewLaporan'])->name('laporan');
    });
    
    // ==================== ADMIN ROUTES ====================
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen Users
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::post('/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
        
        // Manajemen Dosen
        Route::resource('dosens', App\Http\Controllers\Admin\DosenController::class);
        
        // Manajemen Perusahaan
        Route::resource('perusahaans', App\Http\Controllers\Admin\PerusahaanController::class);
        Route::post('/perusahaans/{perusahaan}/toggle-status', [App\Http\Controllers\Admin\PerusahaanController::class, 'toggleStatus'])->name('perusahaans.toggle-status');
        
        // Manajemen Kelompok PKL
        Route::resource('kelompok', App\Http\Controllers\Admin\KelompokController::class);
        Route::post('/kelompok/{kelompok}/approve', [App\Http\Controllers\Admin\KelompokController::class, 'approve'])->name('kelompok.approve');
        
        // ========== EXPORT ROUTES ==========
        Route::prefix('export')->name('export.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ExportController::class, 'index'])->name('index');
        Route::get('/kelompok', [App\Http\Controllers\Admin\ExportController::class, 'exportKelompok'])->name('kelompok');
        Route::get('/nilai', [App\Http\Controllers\Admin\ExportController::class, 'exportNilai'])->name('nilai');
        Route::get('/siswa', [App\Http\Controllers\Admin\ExportController::class, 'exportSiswa'])->name('siswa');
        });
        
        // ========== LAPORAN ROUTES ==========
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('index');
            Route::get('/pending', [App\Http\Controllers\Admin\LaporanController::class, 'pending'])->name('pending');
            Route::get('/approved', [App\Http\Controllers\Admin\LaporanController::class, 'approved'])->name('approved');
            Route::get('/rejected', [App\Http\Controllers\Admin\LaporanController::class, 'rejected'])->name('rejected');
            Route::get('/{laporan}', [App\Http\Controllers\Admin\LaporanController::class, 'show'])->name('show');
            Route::get('/{laporan}/download/{type}', [App\Http\Controllers\Admin\LaporanController::class, 'download'])->name('download');
        });
        
        // ========== REKAP ROUTES ==========
        Route::get('/rekap/siswa-export', [App\Http\Controllers\Admin\ExportController::class, 'rekapSiswa'])->name('rekap.siswa-export');
    Route::get('/rekap/kelompok-export', [App\Http\Controllers\Admin\ExportController::class, 'rekapKelompok'])->name('rekap.kelompok-export');
    Route::get('/rekap/logbook-export', [App\Http\Controllers\Admin\ExportController::class, 'rekapLogbook'])->name('rekap.logbook-export');
    Route::get('/rekap/perusahaan-export', [App\Http\Controllers\Admin\ExportController::class, 'rekapPerusahaan'])->name('rekap.perusahaan-export');
    Route::get('/rekap/tahunan-export', [App\Http\Controllers\Admin\ExportController::class, 'rekapTahunan'])->name('rekap.tahunan-export');
        
        // Monitoring & Laporan (legacy)
        Route::get('/laporan-rekap', [App\Http\Controllers\Admin\LaporanController::class, 'rekap'])->name('laporan.rekap');
        Route::get('/logbook-all', [App\Http\Controllers\Admin\LogbookController::class, 'index'])->name('logbook.index');
    });
    
    // ==================== DOSEN ROUTES ====================
    // ==================== DOSEN ROUTES ====================
Route::prefix('dosen')->name('dosen.')->middleware(['auth', 'role:dosen'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Dosen\BimbinganController::class, 'dashboard'])->name('dashboard');
    
    // Bimbingan
    Route::get('/bimbingan', [App\Http\Controllers\Dosen\BimbinganController::class, 'index'])->name('bimbingan.index');
    Route::get('/bimbingan/{kelompok}', [App\Http\Controllers\Dosen\BimbinganController::class, 'show'])->name('bimbingan.show');
    
    // Logbook
    Route::get('/logbook/pending', [App\Http\Controllers\Dosen\BimbinganController::class, 'logbookPending'])->name('logbook.pending');
    Route::get('/logbook/{logbook}/review', [App\Http\Controllers\Dosen\BimbinganController::class, 'reviewLogbook'])->name('logbook.review');
    Route::post('/logbook/{logbook}/approve', [App\Http\Controllers\Dosen\BimbinganController::class, 'approveLogbook'])->name('logbook.approve');
    
    // Laporan
    Route::get('/laporan', [App\Http\Controllers\Dosen\BimbinganController::class, 'laporanIndex'])->name('laporan.index');
    Route::get('/laporan/{laporan}/review', [App\Http\Controllers\Dosen\BimbinganController::class, 'reviewLaporan'])->name('laporan.review');
    Route::post('/laporan/{laporan}/review', [App\Http\Controllers\Dosen\BimbinganController::class, 'submitReviewLaporan'])->name('laporan.submit-review');
    Route::get('/laporan/{laporan}/download/{type}', [App\Http\Controllers\Dosen\BimbinganController::class, 'downloadLaporan'])->name('laporan.download');

    
    // Penilaian
    Route::resource('penilaian', App\Http\Controllers\Dosen\PenilaianController::class);

    // Absensi
    Route::get('/absensi/siswa', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'index'])->name('absensi.siswa');
    Route::get('/absensi/rekap', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'rekap'])->name('absensi.rekap');
    Route::get('/absensi/export-excel', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'exportExcel'])->name('absensi.export-excel');
    Route::get('/absensi/export-rekap-siswa', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'exportRekapSiswa'])->name('absensi.export-rekap-siswa');
    Route::post('/absensi/absen-siswa/{siswaId}', [App\Http\Controllers\Dosen\AbsensiDosenController::class, 'absenSiswa'])->name('absensi.absen-siswa');

    // Izin Sakit
    Route::get('/ijin-sakit', [App\Http\Controllers\Dosen\IjinSakitController::class, 'index'])->name('ijin-sakit.index');
    Route::post('/ijin-sakit/{id}/approve', [App\Http\Controllers\Dosen\IjinSakitController::class, 'approve'])->name('ijin-sakit.approve');
    Route::post('/ijin-sakit/{id}/reject', [App\Http\Controllers\Dosen\IjinSakitController::class, 'reject'])->name('ijin-sakit.reject');
});
    
    // ==================== PT ROUTES ====================
    Route::prefix('pt')->name('pt.')->middleware(['auth', 'role:pt'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Perusahaan\MonitoringController::class, 'dashboard'])->name('dashboard');
        
        // Monitoring Siswa
        Route::get('/monitoring', [App\Http\Controllers\Perusahaan\MonitoringController::class, 'index'])->name('monitoring.index');
        Route::get('/monitoring/{kelompok}', [App\Http\Controllers\Perusahaan\MonitoringController::class, 'show'])->name('monitoring.show');
        
        // Logbook
        Route::get('/logbook', [App\Http\Controllers\Perusahaan\MonitoringController::class, 'logbookIndex'])->name('logbook.index');
        Route::get('/logbook/pending', [App\Http\Controllers\Perusahaan\MonitoringController::class, 'logbookPending'])->name('logbook.pending');
        Route::get('/logbook/{logbook}/review', [App\Http\Controllers\Perusahaan\MonitoringController::class, 'reviewLogbook'])->name('logbook.review');
        Route::post('/logbook/{logbook}/approve', [App\Http\Controllers\Perusahaan\MonitoringController::class, 'approveLogbook'])->name('logbook.approve');
        Route::post('/logbook/{logbook}/reject', [App\Http\Controllers\Perusahaan\MonitoringController::class, 'rejectLogbook'])->name('logbook.reject');
        Route::get('/logbook/{logbook}/download', [App\Http\Controllers\Perusahaan\MonitoringController::class, 'downloadLogbook'])->name('logbook.download');
        
        // Penilaian
        Route::resource('penilaian', App\Http\Controllers\Perusahaan\PenilaianPtController::class);
      
        
        // Laporan
        Route::get('/laporan', [App\Http\Controllers\Perusahaan\MonitoringController::class, 'laporanIndex'])->name('laporan.index');
        Route::get('/laporan/{laporan}', [App\Http\Controllers\Perusahaan\MonitoringController::class, 'viewLaporan'])->name('laporan.show');
        Route::get('/laporan/{laporan}/download', [App\Http\Controllers\Perusahaan\MonitoringController::class, 'downloadLaporan'])->name('laporan.download');
    });
    
    // ==================== SISWA ROUTES ====================
    Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {
        
        // Absensi
        Route::get('/absensi', [App\Http\Controllers\Siswa\AbsensiController::class, 'index'])->name('absensi.index');
        Route::post('/absensi/store', [App\Http\Controllers\Siswa\AbsensiController::class, 'store'])->name('absensi.store');
        Route::post('/absensi/keluar', [App\Http\Controllers\Siswa\AbsensiController::class, 'absenKeluar'])->name('absensi.keluar');
        
        // Ijin/Sakit
        Route::resource('ijin-sakit', App\Http\Controllers\Siswa\IjinSakitController::class);
        
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
        
        // Logbook
        Route::resource('logbook', App\Http\Controllers\Siswa\LogbookController::class);
        
        // Laporan
        Route::resource('laporan', App\Http\Controllers\Siswa\LaporanController::class);
        Route::post('/laporan/{laporan}/submit', [App\Http\Controllers\Siswa\LaporanController::class, 'submit'])->name('laporan.submit');
        Route::get('/laporan/{laporan}/download/{type}', [App\Http\Controllers\Siswa\LaporanController::class, 'download'])->name('laporan.download');
        
        // Penilaian
        Route::get('/penilaian', [App\Http\Controllers\Siswa\PenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('/penilaian/{penilaian}', [App\Http\Controllers\Siswa\PenilaianController::class, 'show'])->name('penilaian.show');
        
        // Profile
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [App\Http\Controllers\Siswa\ProfileController::class, 'edit'])->name('edit');
            Route::put('/', [App\Http\Controllers\Siswa\ProfileController::class, 'update'])->name('update');
            Route::post('/photo', [App\Http\Controllers\Siswa\ProfileController::class, 'updatePhoto'])->name('photo');
            Route::put('/password', [App\Http\Controllers\Siswa\ProfileController::class, 'updatePassword'])->name('password');
        });
    });
});

// ==================== TEST & UTILITY ROUTES ====================
Route::get('/check-csrf', function() {
    return [
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'app_url' => config('app.url'),
        'session_domain' => config('session.domain'),
    ];
});

Route::get('/test-role', function() {
    return 'Middleware role berfungsi!';
})->middleware(['auth', 'role:admin']);

// ==================== EMAIL VERIFICATION ROUTES ====================
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ==================== FALLBACK ROUTE ====================
Route::fallback(function () {
    return view('errors.404');
});