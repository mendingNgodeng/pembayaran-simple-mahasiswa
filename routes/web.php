<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\BayarController;
use Illuminate\Support\Facades\Route;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pembayaran;
use App\Models\Mahasiswa;
use App\Models\User;
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

Route::redirect('/', '/login');
// me being lazy :)
Route::get('/dashboard', function () {
    $mahasiswa = Mahasiswa::count();
    $pembayaran = Pembayaran::count();
    $total = Pembayaran::sum('jumlah');
    $total_admin = User::count();
    return view('dashboard',compact('mahasiswa','pembayaran','total','total_admin'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth','verified'])->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // mahasiswa
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::post('/mahasiswa/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

    // pembayaran
    Route::get('/bayar', [BayarController::class, 'index'])->name('bayar.index');
    Route::post('/bayar/store', [BayarController::class, 'store'])->name('bayar.store');
    Route::put('/bayar/{id}', [BayarController::class, 'update'])->name('bayar.update');
    Route::delete('/bayar/{id}', [BayarController::class, 'destroy'])->name('bayar.delete');

// Print pembayaran PDF
Route::get('/bayar/export/pdf', function () {
    $data = Pembayaran::with('mahasiswa')->get();
    $pdf = Pdf::loadView('bayar.export-all', compact('data'));
    return $pdf->download('pembayaran.pdf');
});

Route::get('/bayar/export/pdf/{id}', function ($id) {
    $data = Pembayaran::with('mahasiswa')->findOrFail($id);
    $pdf = Pdf::loadView('bayar.export-single', compact('data'));
    return $pdf->download('pembayaran_'.$id.'.pdf');
});
});

require __DIR__.'/auth.php';
