<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LandingpageController;

/* Auth Controlller */
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/* Controller Admin */
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminVerificationController;
use App\Http\Controllers\Admin\Manajemen_Siswa\DashboardController as AdminSiswaDashboardController;
use App\Http\Controllers\Admin\Manajemen_Guru\DashboardController as AdminGuruDashboardController;
use App\Http\Controllers\Admin\Manajemen_Industri\DashboardController as AdminIndustriDashboardController;
use App\Http\Controllers\Admin\CertificateTemplateController;

/* Controller Industri */
use App\Http\Controllers\Industri\DashboardController as IndustriDashboardController;
use App\Http\Controllers\Industri\Project\DashboardController as IndustriProjekDashboardController;
use App\Http\Controllers\Industri\Project\UndanganController as IndustriUndanganController;
use App\Http\Controllers\Industri\Project\Task\DashboardController as IndustriTaskController;
use App\Http\Controllers\Industri\Kompetensi\ProjectbasedController as IndustriKompetensiController;

/* Controller Guru */
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\ProfilController as GuruProfilController;
use App\Http\Controllers\Guru\PJBL\DashboardController as GuruPJBLDashboardController;
use App\Http\Controllers\Guru\Kompetensi\ProjectbasedController as GuruKompetensiProjectbasedController;
use App\Http\Controllers\Guru\Kompetensi\GuruCertificateController;

/* Undangan Controller */
use App\Http\Controllers\Guru\PJBL\UndanganController as GuruUndanganController;

/* Tefa Guru */
use App\Http\Controllers\Guru\TefaController as GuruTefaController;
use App\Http\Controllers\Guru\UndanganTefaController as GuruUndanganTefaController;

/* Controller Siswa */
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\ProfilController;
use App\Http\Controllers\Siswa\PJBL\DashboardController as SiswaPJBLDashboardController;
use App\Http\Controllers\Siswa\PJBL\UndanganController as SiswaPJBLUndanganController;
use App\Http\Controllers\Siswa\PJBL\Tasks\DashboardController as SiswaPJBLTaskController;
use App\Http\Controllers\Siswa\Kompetensi\SertifikasiController as StudentCertificateController;
/* Siswa Tefa Controller */
use App\Http\Controllers\Siswa\TefaController as SiswaTefaController;
use App\Http\Controllers\Siswa\UndanganTefaController as SiswaUndanganTefaController;





Route::get('/', [LandingpageController::class, 'index']);

// Auth Routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Rute Registrasi
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Rute Verifikasi Email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');


/* Logout Route */
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Admin Dashboard Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rute Admin - Dashboard Manajemen Siswa   
    Route::get('/manajemen-siswa/dashboard', [AdminSiswaDashboardController::class, 'index'])->name('manajemen-siswa.dashboard');
    Route::get('/manajemen-siswa/create', [AdminSiswaDashboardController::class, 'create'])->name('manajemen-siswa.create');
    Route::post('/manajemen-siswa/store', [AdminSiswaDashboardController::class, 'store'])->name('manajemen-siswa.store');
    Route::get('/manajemen-siswa/{id}/edit', [AdminSiswaDashboardController::class, 'edit'])->name('manajemen-siswa.edit');
    Route::put('/manajemen-siswa/{id}/update', [AdminSiswaDashboardController::class, 'update'])->name('manajemen-siswa.update');
    Route::delete('/manajemen-siswa/{id}/delete', [AdminSiswaDashboardController::class, 'destroy'])->name('manajemen-siswa.destroy');
    
    // Rute Admin - Verifikasi Akun Siswa
    Route::get('/manajemen-siswa/verifikasi-akun', [AdminVerificationController::class, 'siswa'])->name('verifikasi.siswa');
    Route::patch('/manajemen-siswa/verifikasi/{id}/approve', [AdminVerificationController::class, 'approve'])->name('verifikasi.approve');
    Route::patch('/manajemen-siswa/verifikasi/{id}/reject', [AdminVerificationController::class, 'reject'])->name('verifikasi.reject');
    
    // Rute Admin - Dashboard Manajemen Guru
    Route::get('/manajemen-guru/dashboard', [AdminGuruDashboardController::class, 'index'])->name('manajemen-guru.dashboard');
    Route::get('/manajemen-guru/create', [AdminGuruDashboardController::class, 'create'])->name('manajemen-guru.create');
    Route::post('/manajemen-guru/store', [AdminGuruDashboardController::class, 'store'])->name('manajemen-guru.store');
    Route::get('/manajemen-guru/{id}/edit', [AdminGuruDashboardController::class, 'edit'])->name('manajemen-guru.edit');
    Route::put('/manajemen-guru/{id}/update', [AdminGuruDashboardController::class, 'update'])->name('manajemen-guru.update');
    Route::delete('/manajemen-guru/{id}/delete', [AdminGuruDashboardController::class, 'destroy'])->name('manajemen-guru.destroy');
    
    // Rute Admin - Verifikasi Akun Guru
    Route::get('/manajemen-guru/verifikasi-akun', [AdminVerificationController::class, 'guru'])->name('verifikasi.guru');
    Route::patch('/manajemen-guru/verifikasi/{id}/approve', [AdminVerificationController::class, 'approve'])->name('verifikasi.approve');
    Route::patch('/manajemen-guru/verifikasi/{id}/reject', [AdminVerificationController::class, 'reject'])->name('verifikasi.reject');

    //Rute Admin - Dashboard Industri
    Route::get('/manajemen-industri/dashboard', [AdminIndustriDashboardController::class, 'index'])->name('manajemen-industri.dashboard');
    Route::get('/manajemen-industri/create', [AdminIndustriDashboardController::class, 'create'])->name('manajemen-industri.create');
    Route::post('/manajemen-industri/store', [AdminIndustriDashboardController::class, 'store'])->name('manajemen-industri.store');
    Route::get('/manajemen-industri/{id}/edit', [AdminIndustriDashboardController::class, 'edit'])->name('manajemen-industri.edit');
    Route::put('/manajemen-industri/{id}/update', [AdminIndustriDashboardController::class, 'update'])->name('manajemen-industri.update');
    Route::delete('/manajemen-industri/{id}/delete', [AdminIndustriDashboardController::class, 'destroy'])->name('manajemen-industri.destroy');

    //Rute Admin - Verifikasi Akun Industri
    Route::get('/manajemen-industri/verifikasi-akun', [AdminVerificationController::class, 'industri'])->name('verifikasi.industri');
    Route::patch('/manajemen-industri/verifikasi/{id}/approve', [AdminVerificationController::class, 'approve'])->name('verifikasi.approve');
    Route::patch('/manajemen-industri/verifikasi/{id}/reject', [AdminVerificationController::class, 'reject'])->name('verifikasi.reject');

    Route::get('/Template', [CertificateTemplateController::class, 'index'])->name('certificate-templates.index');
    Route::get('/Template/create', [CertificateTemplateController::class, 'create'])->name('certificate-templates.create');
    Route::post('/Template', [CertificateTemplateController::class, 'store'])->name('certificate-templates.store');
    Route::get('/Template/{certificate_template}', [CertificateTemplateController::class, 'show'])->name('certificate-templates.show');
    Route::get('/Template/{certificate_template}/edit', [CertificateTemplateController::class, 'edit'])->name('certificate-templates.edit');
    Route::put('/Template/{certificate_template}', [CertificateTemplateController::class, 'update'])->name('certificate-templates.update');
    Route::delete('/Template/{certificate_template}', [CertificateTemplateController::class, 'destroy'])->name('certificate-templates.destroy');

    
});


// Industri Dashboard Routes
Route::middleware(['auth', 'role:industri'])->prefix('Industri')->name('industri.')->group(function () {
    Route::get('/Dashboard', [IndustriDashboardController::class, 'index'])->name('dashboard');

    Route::get('PjBL/Dashboard', [IndustriProjekDashboardController::class, 'index'])->name('pjbl.dashboard');

    Route::get('/pjbl/undangan', [IndustriUndanganController::class, 'index'])->name('pjbl.undangan.index');
    Route::post('/pjbl/undangan/{id}/approve', [IndustriUndanganController::class, 'approve'])->name('pjbl.undangan.approve');
    Route::post('/pjbl/undangan/{id}/reject', [IndustriUndanganController::class, 'reject'])->name('pjbl.undangan.reject');
    Route::get('/pjbl/undangan/{id}', [IndustriUndanganController::class, 'show'])->name('pjbl.undangan.show');
    Route::get('/pjbl/undangan/{id}/download-proposal', [IndustriUndanganController::class, 'download'])->name('pjbl.undangan.download');

    Route::get('/PjBL/Dashboard/{projectId}/monitor', [IndustriTaskController::class, 'monitor'])->name('pjbl.dashboard.monitor');
    Route::get('/PjBL/Dashboard/{projectId}/tasks/{taskId}', [IndustriTaskController::class, 'showTask'])->name('pjbl.dashboard.tasks.show');
    Route::put('/PjBL/Dashboard/{projectId}/tasks/{taskId}/review', [IndustriTaskController::class, 'updateCatatan'])->name('pjbl.dashboard.tasks.review');

    Route::get('/Kompetensi', [IndustriKompetensiController::class, 'index'])->name('kompetensi.pjbl.index');
    Route::get('/Kompetensi/Project/{project}/Student/{student}', [IndustriKompetensiController::class, 'create'])->name('kompetensi.pjbl.create');
    Route::post('/Kompetensi/Project/{project}/Student/{student}', [IndustriKompetensiController::class, 'store'])->name('kompetensi.pjbl.store');

    

});

// Admin Dashboard Guru Routes
Route::middleware(['auth', 'role:guru'])->prefix('Guru')->name('guru.')->group(function () {
    Route::get('/Dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

    // Rute Guru - Profil
    Route::get('/Profile', [GuruProfilController::class, 'index'])->name('profile.index');
    Route::put('/Profile', [GuruProfilController::class, 'update'])->name('profile.update');

    Route::get('/PjBL/Dashboard', [GuruPJBLDashboardController::class, 'index'])->name('pjbl.dashboard');

    Route::get('/PjBL/Undangan', [GuruUndanganController::class, 'index'])->name('pjbl.undangan.index');
    Route::get('/PjBL/Undangan/{id}', [GuruUndanganController::class, 'show'])->name('pjbl.undangan.show');
    Route::get('/PjBL/Undangan/{id}/download-proposal', [GuruUndanganController::class, 'downloadProposal'])->name('pjbl.undangan.download');

    Route::post('/PjBL/Undangan/{id}/approve', [GuruUndanganController::class, 'approve'])->name('pjbl.undangan.approve');
    Route::post('/PjBL/Undangan/{id}/reject', [GuruUndanganController::class, 'reject'])->name('pjbl.undangan.reject');

    Route::get('/PjBL/Dashboard/projects/{project}/monitor', [GuruPJBLDashboardController::class, 'monitor'])->name('pjbl.monitor');
    Route::get('/PjBL/Dashboard/projects/{project}/tasks/{task}', [GuruPJBLDashboardController::class, 'showTask'])->name('pjbl.tasks.show');
    Route::put('/PjBL/Dashboard/projects/{project}/tasks/{task}/review', [GuruPJBLDashboardController::class, 'updateCatatanGuru'])->name('pjbl.tasks.review');
    
    Route::get('/Kompetensi/PjBL', [GuruKompetensiProjectbasedController::class, 'index'])->name('kompetensi.pjbl.index');
    Route::get('/Kompetensi/PjBL/{project}/{student}/create', [GuruKompetensiProjectbasedController::class, 'create'])->name('kompetensi.pjbl.create');
    Route::post('/Kompetensi/PjBL/{project}/{student}', [GuruKompetensiProjectbasedController::class, 'store'])->name('kompetensi.pjbl.store');
    Route::get('/generate-certificate/{evaluation}/{template}', [GuruKompetensiProjectbasedController::class, 'generate'])->name('certificate.generate');

    Route::get('/Sertifikat', [GuruCertificateController::class, 'index'])->name('sertifikat.index');
    Route::get('/Sertifikat/{evaluation}/generate', [GuruCertificateController::class, 'generatePdf'])->name('sertifikat.generate');

    Route::get('/Tefa/Dashboard', [GuruTefaController::class, 'index'])->name('tefa.dashboard');
    Route::get('/Tefa/Undangan', [GuruUndanganTefaController::class, 'index'])->name('tefa.undangan.index');
    Route::get('/Tefa/Undangan/{id}', [GuruUndanganTefaController::class, 'show'])->name('tefa.undangan.show');
    Route::get('/Tefa/Undangan/{id}/download-proposal', [GuruUndanganTefaController::class, 'downloadProposal'])->name('tefa.undangan.download');

    Route::post('/Tefa/Undangan/{id}/approve', [GuruUndanganTefaController::class, 'approve'])->name('tefa.undangan.approve');
    Route::post('/Tefa/Undangan/{id}/reject', [GuruUndanganTefaController::class, 'reject'])->name('tefa.undangan.reject');
});



Route::get('/Guru/TEFA', function () {
    return view('guru.tefa.index');
});

Route::get('/Guru/Kompetensi', function () {
    return view('guru.kompetensi.index');
});

Route::get('/Guru/Kompetensi/TEFA', function () {
    return view('guru.kompetensi.tefa.index');
});
Route::get('/Guru/Laporan', function () {
    return view('guru.laporan.index');
});




// Siswa Dashboard Routes
Route::middleware(['auth', 'role:siswa'])->prefix('Siswa')->name('siswa.')->group(function () {
    Route::get('/Dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    // Rute Siswa - Profil
    Route::get('/Profile', [ProfilController::class, 'edit'])->name('profile.edit');
    Route::put('/Profile', [ProfilController::class, 'update'])->name('profile.update');

    // Rute Siswa - Dashboard PjBL
    Route::get('/PjBL/Dashboard', [SiswaPJBLDashboardController::class, 'index'])->name('pjbl.dashboard');
    Route::get('/PjBL/Dashboard/Invitation', [SiswaPJBLDashboardController::class, 'respond'])->name('pjbl.invitation.response');
    Route::get('/PjBL/Dashboard/Create', [SiswaPJBLDashboardController::class, 'create'])->name('pjbl.create');
    Route::post('/PjBL/Dashboard/Store', [SiswaPJBLDashboardController::class, 'store'])->name('pjbl.store');
    Route::delete('/PjBL/Dashboard/{id}', [SiswaPJBLDashboardController::class, 'destroy'])->name('pjbl.destroy');

    //Rute Siswa - Undangan PJBL
    Route::get('/PjBL/Invitation', [SiswaPJBLUndanganController::class, 'indexInvitation'])->name('pjbl.invitation.index');
    Route::get('PjBL/Invitation/{id}/accept', [SiswaPJBLUndanganController::class, 'accept'])->name('pjbl.invitation.accept');
    Route::get('PjBL/Invitation/{id}/reject', [SiswaPJBLUndanganController::class, 'reject'])->name('pjbl.invitation.reject');

    //Rute Siswa - Task PJBL
    Route::get('/PjBL/Dashboard/Project/{projectId}/Tasks', [SiswaPJBLTaskController::class, 'index'])->name('pjbl.tasks.index');
    Route::post('/PjBL/Dashboard/Project/{projectId}/Tasks/Store', [SiswaPJBLTaskController::class, 'store'])->name('pjbl.tasks.store');
    Route::patch('/PjBL/Dashboard/Tasks/{taskId}/Update-Status', [SiswaPJBLTaskController::class, 'updateStatus'])->name('pjbl.tasks.update-status');
    Route::delete('/PjBL/Dashboard/Project/{projectId}/Tasks/{taskId}', [SiswaPJBLTaskController::class, 'destroy'])->name('pjbl.tasks.destroy');

    //Rute Siswa - Task Progress PJBL
    Route::get('/PjBL/Dashboard/Project/{projectId}/Tasks/{taskId}', [SiswaPJBLTaskController::class, 'show'])->name('pjbl.tasks.show');
    Route::post('/PjBL/Dashboard/Project/{projectId}/Tasks/{taskId}/Progress/Store', [SiswaPJBLTaskController::class, 'storeProgress'])->name('pjbl.tasks.progress.store');
    Route::delete('/PjBL/Dashboard/Project/{projectId}/Tasks/{taskId}/Progress/{progressId}', [SiswaPJBLTaskController::class, 'destroyProgress'])->name('pjbl.tasks.progress.destroy');

    Route::get('/Sertifikat', [StudentCertificateController::class, 'index'])->name('sertifikat.index');
    Route::get('/Sertifikat/{evaluation}/download', [StudentCertificateController::class, 'downloadPdf'])->name('sertifikat.download');

    /* Route TEFA Siswa */
    Route::get('/Tefa/Dashboard', [SiswaTefaController::class, 'index'])->name('tefa');
    Route::get('/Tefa/Create', [SiswaTefaController::class, 'create'])->name('tefa.create');
    Route::post('/Tefa/Store', [SiswaTefaController::class, 'store'])->name('tefa.store');
    Route::delete('/Tefa{id}', [SiswaTefaController::class, 'destroy'])->name('tefa.destroy');
    /* Undangan Tefa */
    Route::get('Tefa/invitations', [SiswaUndanganTefaController::class, 'index'])->name('invitations');
    Route::get('Tefa/Invitation/{id}/accept', [SiswaUndanganTefaController::class, 'accept'])->name('invitation.accept');
    Route::get('Tefa/Invitation/{id}/reject', [SiswaUndanganTefaController::class, 'reject'])->name('invitation.reject');
    Route::get('/Tefa/Invitation', [SiswaTefaController::class, 'respondInvitation'])->name('tefa.invitation.response');


});


