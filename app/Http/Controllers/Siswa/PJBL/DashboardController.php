<?php

namespace App\Http\Controllers\Siswa\PJBL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectMentor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Events\InvitationReceived;

class DashboardController extends Controller
{
    public function index()
    {
        $userName = auth()->user()->name;

        $myProjects = Project::whereHas('members', function ($query) use ($userName) {
                $query->where('nama_siswa', $userName)
                    ->where('status', 'accepted');
            })
            ->with(['members', 'mentors']) // FIX: Cukup 'mentors' saja
            ->latest()
            ->paginate(6);

        $myProjects->through(function ($project) {
            $project->nama_guru_utama = $project->mentors
                ->filter(fn($m) => $m->pivot->tipe === 'utama')
                ->pluck('name') 
                ->toArray();

            $project->nama_guru_umum = $project->mentors
                ->filter(fn($m) => $m->pivot->tipe === 'umum')
                ->pluck('name')
                ->toArray();

            $project->nama_industri = $project->mentors
                ->filter(fn($m) => $m->pivot->tipe === 'industri')
                ->pluck('name')
                ->toArray();

            return $project;
        });

        $undanganMasuk = ProjectMember::with('project')
            ->where('nama_siswa', $userName)
            ->where('is_leader', false)
            ->where('status', 'pending') 
            ->get();

        $totalUndangan = $undanganMasuk->count();

        $proyeks = Project::whereHas('members', function ($q) use ($userName) {
                $q->where('nama_siswa', $userName)
                ->where('status', 'accepted');
            })
            ->with('mentors')
            ->latest()
            ->get();

        $totalProyek = $proyeks->count();

        $proyekSelesai = $proyeks->filter(function ($project) {
            if ($project->mentors->isEmpty()) {
                return false;
            }

            return $project->mentors->every(fn($mentor) => $mentor->pivot->status === 'approved');
        })->count();

        $proyekBerjalan = $totalProyek - $proyekSelesai;

        return view('siswa.projek.dashboard.index', compact(
            'totalProyek',
            'proyekBerjalan',
            'proyekSelesai',
            'totalUndangan',
            'undanganMasuk',
            'proyeks',
            'myProjects'
        ));
    }

    public function create()
    {
        $gurus = User::where('role', 'guru')->get(['id', 'name', 'subject']); 
        $siswas = User::where('role', 'siswa')->get(['id', 'name', 'major', 'offering']);
        $industris = User::where('role', 'industri')->get(['id', 'name', 'company_name']);

        return view('siswa.projek.dashboard.create', compact('gurus', 'siswas', 'industris'));
    }


    public function store(Request $request)
    {

        $pembimbingUtama = is_string($request->pembimbing_utama) ? json_decode($request->pembimbing_utama, true) : $request->pembimbing_utama;
        $pembimbingUmum = is_string($request->pembimbing_umum) ? json_decode($request->pembimbing_umum, true) : $request->pembimbing_umum;
        $pembimbingIndustri = is_string($request->pembimbing_industri) ? json_decode($request->pembimbing_industri, true) : $request->pembimbing_industri;
        $anggotaInput = is_string($request->anggota) ? json_decode($request->anggota, true) : $request->anggota;

        $pembimbingUtama = array_values(array_filter((array) $pembimbingUtama));
        $pembimbingUmum = array_values(array_filter((array) $pembimbingUmum));
        $pembimbingIndustri = array_values(array_filter((array) $pembimbingIndustri));
        $anggotaInput = array_values(array_filter((array) $anggotaInput));

        $request->merge([
            'pembimbing_utama'    => $pembimbingUtama,
            'pembimbing_umum'     => $pembimbingUmum,
            'pembimbing_industri' => $pembimbingIndustri,
            'anggota'             => $anggotaInput,
        ]);

  
        $request->validate([
            'tipe'                  => 'required|in:individu,kelompok',
            'judul'                 => 'required|string|max:255',
            'deskripsi'             => 'required|string',
            'kategori'              => 'required|string',
            'proposal'              => 'required|file|mimes:pdf|max:5120',
            'tanggal_mulai'         => 'required|date',
            'tanggal_selesai'       => 'required|date|after_or_equal:tanggal_mulai',

  
            'pembimbing_utama'      => 'required|array|min:1',
            'pembimbing_utama.*'    => 'required|exists:users,id',
            'pembimbing_umum'       => 'nullable|array',
            'pembimbing_umum.*'     => 'nullable|exists:users,id',
            'pembimbing_industri'   => 'nullable|array',
            'pembimbing_industri.*' => 'nullable|exists:users,id',

            /* Validasi Anggota Kelompok */
            'anggota'               => 'required_if:tipe,kelompok|array',
            'anggota.*.siswa_id'    => 'required_if:tipe,kelompok|exists:users,id',
            'anggota.*.peran'       => 'required_if:tipe,kelompok|string',
        ]);

        DB::beginTransaction();

        try {
         
            $proposalPath = $request->file('proposal')->store('proposals', 'public');

     
            $project = Project::create([
                'user_id'         => auth()->id(),
                'tipe'            => $request->tipe,
                'judul'           => $request->judul,
                'deskripsi'       => $request->deskripsi,
                'kategori'        => $request->kategori,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'proposal_path'   => $proposalPath,
                'status'          => 'pending',
            ]);


            $mentorsToInsert = [];

            foreach ($pembimbingUtama as $mentorId) {
                $mentorsToInsert[] = [
                    'project_id' => $project->id,
                    'user_id'    => $mentorId,
                    'tipe'       => 'utama',
                    'status'     => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            foreach ($pembimbingUmum as $mentorId) {
                $mentorsToInsert[] = [
                    'project_id' => $project->id,
                    'user_id'    => $mentorId,
                    'tipe'       => 'umum',
                    'status'     => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            foreach ($pembimbingIndustri as $mentorId) {
                $mentorsToInsert[] = [
                    'project_id' => $project->id,
                    'user_id'    => $mentorId,
                    'tipe'       => 'industri',
                    'status'     => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            ProjectMentor::insert($mentorsToInsert);


            $currentUser = auth()->user();

            if ($request->tipe === 'individu') {
                ProjectMember::create([
                    'project_id' => $project->id,
                    'user_id'    => $currentUser->id,
                    'nama_siswa' => $currentUser->name,
                    'peran'      => 'Ketua Proyek',
                    'is_leader'  => true,
                    'status'     => 'accepted',
                ]);
            } else {
 
                ProjectMember::create([
                    'project_id' => $project->id,
                    'user_id'    => $currentUser->id,
                    'nama_siswa' => $currentUser->name,
                    'peran'      => 'Ketua Kelompok',
                    'is_leader'  => true,
                    'status'     => 'accepted',
                ]);

                foreach ($request->anggota as $item) {
                    if (!empty($item['siswa_id']) && $item['siswa_id'] != $currentUser->id) {
                        $siswaUser = User::find($item['siswa_id']);
                        if ($siswaUser) {
                            ProjectMember::create([
                                'project_id' => $project->id,
                                'user_id'    => $siswaUser->id,
                                'nama_siswa' => $siswaUser->name,
                                'peran'      => $item['peran'] ?? 'Anggota',
                                'is_leader'  => false,
                                'status'     => 'pending',
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status'   => 'success',
                'message'  => 'Proyek berhasil diajukan!',
                'redirect' => route('siswa.pjbl.dashboard')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($proposalPath) && Storage::disk('public')->exists($proposalPath)) {
                Storage::disk('public')->delete($proposalPath);
            }
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan proyek: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Respon Undangan Kelompok oleh Siswa Anggota
     */
    public function respond(Request $request)
    {
        $request->validate([
            'id'     => 'required|integer|exists:project_members,id',
            'action' => 'required|in:accept,reject',
        ]);

        $user = auth()->user();

        $member = ProjectMember::where('id', $request->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $status = ($request->action === 'accept') ? 'accepted' : 'rejected';

        $member->update([
            'status' => $status
        ]);

        $message = ($status === 'accepted') 
            ? 'Anda berhasil bergabung dengan kelompok proyek!' 
            : 'Undangan kelompok berhasil ditolak.';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'success', 'message' => $message]);
        }

        return redirect()->back()->with('success', $message);
    }
    public function destroy($id)
    {
        $project = Project::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        DB::beginTransaction();

        try {
            if ($project->proposal_path && Storage::disk('public')->exists($project->proposal_path)) {
                Storage::disk('public')->delete($project->proposal_path);
            }

            $project->members()->delete();

            if (method_exists($project, 'tasks')) {
                $project->tasks()->delete();
            }

            $project->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Proyek berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus proyek: ' . $e->getMessage());
        }
    }
}
