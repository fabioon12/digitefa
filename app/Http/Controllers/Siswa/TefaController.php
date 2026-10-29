<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tefa;
use App\Models\TefaMember;
use App\Models\TefaMentor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Events\InvitationReceived;
use Illuminate\Support\Facades\Auth;


class TefaController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $user = Auth::user();
        $userId = auth()->id();
        $keyword = $request->input('search'); 

        $query = Tefa::whereHas('members', function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->where(function ($subQ) {
                  // Jika dia ketua (leader), langsung tampil
                  $subQ->where('is_leader', true)
                       // Jika dia anggota biasa, status undangannya harus sudah 'accepted'
                       ->orWhere('status', 'accepted');
              });
        })
        ->with(['members', 'mentors']);

        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                ->orWhere('kategori', 'like', "%{$keyword}%")
                ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        $proyeks = $query->latest()->get(); 
   
        $totalProyek = $proyeks->count();

        $proyekSelesai = $proyeks->filter(function ($project) {
            if ($project->mentors->isEmpty()) {
                return false;
            }
            return $project->mentors->every(fn($mentor) => $mentor->pivot->status === 'approved');
        })->count();

        $proyekBerjalan = $totalProyek - $proyekSelesai;

        $undanganMasuk = TefaMember::with('tefa')
            ->where('user_id', $userId)
            ->where('is_leader', false)
            ->where('status', 'pending')
            ->get();

        $totalUndangan = $undanganMasuk->count();

        return view('siswa.tefa.index', compact(
            'totalProyek',
            'proyekBerjalan',
            'proyekSelesai',
            'totalUndangan',
            'undanganMasuk',
            'proyeks',
            'user',
        ));
    }
    public function create()
    {
        $gurus = User::where('role', 'guru')->get(['id', 'name', 'subject']); 
        $siswas = User::where('role', 'siswa')->get(['id', 'name', 'major', 'offering']);
        $industris = User::where('role', 'industri')->get(['id', 'name', 'company_name']);

        return view('siswa.tefa.create', compact('gurus','siswas','industris')); 
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

     
            $tefa = Tefa::create([
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
                    'tefa_id' => $tefa->id,
                    'user_id'    => $mentorId,
                    'tipe'       => 'utama',
                    'status'     => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            foreach ($pembimbingUmum as $mentorId) {
                $mentorsToInsert[] = [
                    'tefa_id' => $tefa->id,
                    'user_id'    => $mentorId,
                    'tipe'       => 'umum',
                    'status'     => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            foreach ($pembimbingIndustri as $mentorId) {
                $mentorsToInsert[] = [
                    'tefa_id' => $tefa->id,
                    'user_id'    => $mentorId,
                    'tipe'       => 'industri',
                    'status'     => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            TefaMentor::insert($mentorsToInsert);


            $currentUser = auth()->user();

            if ($request->tipe === 'individu') {
                TefaMember::create([
                    'tefa_id' => $tefa->id,
                    'user_id'    => $currentUser->id,
                    'nama_siswa' => $currentUser->name,
                    'peran'      => 'Ketua Proyek',
                    'is_leader'  => true,
                    'status'     => 'accepted',
                ]);
            } else {
 
                TefaMember::create([
                    'tefa_id' => $tefa->id,
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
                            TefaMember::create([
                                'tefa_id' => $tefa->id,
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
                'redirect' => route('siswa.tefa')
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
    public function respondInvitation(Request $request)
    {
        $request->validate([
            'id'     => 'required|integer|exists:tefa_members,id',
            'action' => 'required|in:accept,reject',
        ]);

        $user = auth()->user();

        $member = TefaMember::where('id', $request->id)
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
        $tefa = Tefa::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        DB::beginTransaction();

        try {
            if ($tefa->proposal_path && Storage::disk('public')->exists($tefa->proposal_path)) {
                Storage::disk('public')->delete($tefa->proposal_path);
            }

            $tefa->members()->delete();

            if (method_exists($tefa, 'tasks')) {
                $tefa->tasks()->delete();
            }

            $tefa->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Proyek berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus proyek: ' . $e->getMessage());
        }
    }
}
