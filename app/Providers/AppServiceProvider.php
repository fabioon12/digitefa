<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\ProjectMember;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(8)         
                ->mixedCase()               
                ->numbers()                 
                ->symbols()                 
                ->uncompromised();          
        });

        /* Undangan Pending Daftar Guru */
        View::composer('*', function ($view) {
            $pendingGuruCount = User::where('role', 'guru')
                                    ->where('status', 'pending')
                                    ->count();
            
            $view->with('pendingGuruCount', $pendingGuruCount);
        });

        /* Undangan Pending Daftar Siswa */
        View::composer('*', function ($view) {
            $pendingSiswaCount = User::where('role', 'siswa')
                                    ->where('status', 'pending')
                                    ->count();
            
            $view->with('pendingSiswaCount', $pendingSiswaCount);
        });

        /* Undangan Pending Daftar Industri */
        View::composer('*', function ($view) {
            $pendingIndustriCount = User::where('role', 'industri')
                ->where('status', 'pending')
                ->count();

            $view->with('pendingIndustriCount', $pendingIndustriCount);
        });

        /* Undangan Proyek Siswa */
        View::composer('*', function ($view) {
        if (Auth::check()) {
            $user = Auth::user();

            $undanganProyek = ProjectMember::with(['project', 'leader'])
                ->where('nama_siswa', $user->name)
                ->where('is_leader', 0)
                ->where('status', 'pending')
                ->latest()
                ->get();

            $view->with([
                'undanganProyek' => $undanganProyek,
                'totalUndangan'  => $undanganProyek->count()
            ]);
        }
        
        });
        //undangan Proyek Industri
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $industriId = Auth::id();

                // 1. Ambil Query Dasar untuk Undangan Pending
                $pendingQuery = Project::whereHas('mentors', function ($q) use ($industriId) {
                    $q->where('project_mentors.user_id', $industriId)
                    ->where('project_mentors.tipe', 'industri')
                    ->where('project_mentors.status', 'pending');
                });

                // 2. Ambil 5 List Notifikasi Terbaru (Untuk Popover Header)
                $notifications = (clone $pendingQuery)
                    ->with('creator')
                    ->latest('created_at')
                    ->take(5)
                    ->get();

                // 3. Hitung Total Undangan Pending (Untuk Badge Header & Sidebar)
                $unreadNotifCount = $pendingQuery->count();
                $pendingCount     = $unreadNotifCount; // Alias agar kompatibel dengan komponen Sidebar Anda

                // 4. Share semua variabel ke Blade View
                $view->with(compact('notifications', 'unreadNotifCount', 'pendingCount'));
            }
        });
    }
}
