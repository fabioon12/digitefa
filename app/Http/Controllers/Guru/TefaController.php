<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tefa;
use App\Models\TefaMember;
use Illuminate\Support\Facades\Auth;

class TefaController extends Controller
{
    public function index(Request $request)
    {
        $guruId       = Auth::id();
        $filterKelas  = $request->query('kelas', 'all');
        $filterStatus = $request->query('status', 'berjalan'); 
        $search       = $request->query('search');

        $query = Tefa::with(['creator', 'members.user', 'mentors'])
                        ->whereHas('mentors', function ($q) use ($guruId) {
                            $q->where('tefa_mentors.user_id', $guruId)
                            ->where('tefa_mentors.status', 'approved'); 
                        });


        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $projects = $query->latest()->get();

        return view('guru.tefa.index', compact('projects', 'filterKelas', 'filterStatus', 'search'));
    }
}
