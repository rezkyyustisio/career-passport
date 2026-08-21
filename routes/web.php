<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpaDashboardController;
use App\Http\Controllers\StudentCareerPortalController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('scms')->name('upa.')->group(function () {
    Route::get('/dashboard', [UpaDashboardController::class, 'index'])->name('dashboard');
    Route::post('/score/{id}', [UpaDashboardController::class, 'processScoring'])->name('score');
});

Route::prefix('career-passport')->name('passport.')->group(function () {
    Route::get('/student/{studentId}', [StudentCareerPortalController::class, 'showPassport'])->name('show');
    Route::get('/student/{studentId}/download', [StudentCareerPortalController::class, 'downloadPdf'])->name('download');
});
