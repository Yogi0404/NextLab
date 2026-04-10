<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return redirect('/login');
});

Route::get('/userdashboard', [PeminjamanController::class, 'dashboardUser'])
    ->name('user.dashboard');

Route::get('/admin', [PeminjamanController::class, 'dashboardAdmin'])
    ->middleware('auth')
    ->name('admin.dashboard');

Route::get('/petugasdashboard', [PeminjamanController::class, 'dashboardPetugas']);



Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::prefix('user')->group(function () {

    Route::get('/alat', [PeminjamanController::class, 'userAlat'])->name('user.alat');;
    Route::post('/pinjam', [PeminjamanController::class, 'userPinjam'])->name('user.pinjam');;

    Route::get('/riwayat', [PeminjamanController::class, 'userRiwayat'])->name('user.riwayat');;
    Route::get('/bayar/{id}', [PeminjamanController::class, 'formBayarU'])
        ->name('user.bayar');

    // PROSES BAYAR
    Route::post('/bayar/{id}', [PeminjamanController::class, 'prosesBayarUser'])
        ->name('peminjaman.prosesBayarUser');
    Route::post('/kembali/{id}', [PeminjamanController::class, 'userRequestKembali']);
});

Route::get('/peminjaman', function () {
    return view('admin.peminjaman.index');
});

Route::get('/pengembalian', function () {
    return view('admin.pengembalian.index');
});
Route::get('/denda', [PeminjamanController::class, 'denda'])->name('denda.index');
Route::get('/laporan', [PeminjamanController::class, 'laporan'])->name('laporan');
Route::get('/pinjam/{id}', [PeminjamanController::class, 'pinjam']);
Route::get('/kembali/{id}', [PeminjamanController::class, 'kembali']);
Route::get('/laporan/export', [PeminjamanController::class, 'exportPdf'])->name('laporan.export');


Route::get('/peminjaman/{id}/bayar', [PeminjamanController::class, 'formBayar'])->name('peminjaman.formBayar');

Route::post('/peminjaman/{id}/bayar', [PeminjamanController::class, 'prosesBayar'])->name('peminjaman.prosesBayar');

Route::get('/peminjaman/{id}/struk', [PeminjamanController::class, 'struk'])->name('peminjaman.struk');
Route::get('user/peminjaman/{id}/struk', [PeminjamanController::class, 'strukUser'])->name('peminjaman.strukUser');
Route::resource('user', UserController::class);
Route::resource('alat', AlatController::class);
Route::resource('peminjaman', PeminjamanController::class);

Route::prefix('petugas')->group(function () {
    Route::get('/peminjaman', [PeminjamanController::class, 'indexpetugas'])
        ->name('petugas.peminjaman');
    Route::get('/pengembalian', [PeminjamanController::class, 'viewpengembalian'])
        ->name('petugas.pengembalian');
    Route::get('/pengembalian', [PeminjamanController::class, 'viewpengembalian'])
        ->name('petugas.pengembalian');
    Route::get('/laporan', [PeminjamanController::class, 'laporanpetugas'])
        ->name('petugas.laporan');
    Route::get('/exportpdf', [PeminjamanController::class, 'exportpdfpetugas'])
        ->name('laporan.pdf');
});
Route::get('/user/export-pdf', [UserController::class, 'exportPdfUser'])->name('user.export.pdf');
Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])
    ->name('peminjaman.kembalikan');
Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
Route::post('/peminjaman/{id}/approve-kembali', [PeminjamanController::class, 'approveKembali'])
    ->name('peminjaman.approveKembali');
Route::post('/peminjaman/{id}/tolak-kembali', [PeminjamanController::class, 'tolakKembali'])
    ->name('peminjaman.tolakKembali');
