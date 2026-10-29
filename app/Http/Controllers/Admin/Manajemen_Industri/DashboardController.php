<?php

namespace App\Http\Controllers\Admin\Manajemen_Industri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'industri');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")          
                  ->orWhere('sector', 'like', "%{$search}%")        
                  ->orWhere('pic_name', 'like', "%{$search}%")      
                  ->orWhere('email', 'like', "%{$search}%")         
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $industris = $query->latest()->paginate(10);

        return view('admin.manajemen_industri.dashboard.index', compact('industris'));
        
        }
        public function create()
        {
            return view('admin.manajemen_industri.dashboard.create');
        }

        public function store(Request $request)
        {
            $validated = $request->validate([
                'name'                  => 'required|string|max:255',
                'username'              => 'required|string|max:255|unique:users,username',
                'email'                 => 'required|email|unique:users,email',
                'password'              => 'required|string|min:8|confirmed',
                'company_name'          => 'nullable|string|max:255',
                'sector'                => 'nullable|string|max:50',
                'position'              => 'nullable|string|max:255',
                'nip'                   => 'nullable|string|max:50', // Ditambahkan agar tidak undefined key
                'subject'               => 'nullable|string|max:255',
                'gender'                => 'nullable|in:L,P',
                'status'                => 'required|in:approved,pending,rejected',
                'image'                 => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'must_change_password'  => 'nullable|boolean',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('profile_photos', 'public');
            }

            User::create([
                'name'                 => $validated['name'],
                'username'             => $validated['username'],
                'email'                => $validated['email'],
                'password'             => Hash::make($validated['password']),
                'role'                 => 'industri', 
                'company_name'         => $validated['company_name'] ?? null,
                'sector'               => $validated['sector'] ?? null,
                'position'             => $validated['position'] ?? null,
                'nip'                  => $validated['nip'] ?? null,
                'subject'              => $validated['subject'] ?? null,
                'gender'               => $validated['gender'] ?? null,
                'status'               => $validated['status'],
                'image'                => $imagePath,
                'must_change_password' => $request->has('must_change_password') ? 1 : 0,
            ]);

            return redirect()->route('admin.manajemen-industri.dashboard')
                ->with('success', 'Akun industri berhasil dibuat.');
    }
    public function edit($id)
    {
        $industri = User::where('role', 'industri')->findOrFail($id);
        return view('admin.manajemen_industri.dashboard.edit', compact('industri'));
    }
    public function update(Request $request,$id){
        $industri = User::where('role', 'industri')->findOrFail($id);

        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'username'              => 'required|string|max:255|unique:users,username,' . $industri->id,
            'email'                 => 'required|email|unique:users,email,' . $industri->id,
            'password'              => 'nullable|string|min:8|confirmed',
            'company_name'          => 'nullable|string|max:255',
            'sector'                => 'nullable|string|max:255',
            'position'              => 'nullable|string|max:255',
            'nip'                   => 'nullable|string|max:50',
            'subject'               => 'nullable|string|max:255',
            'gender'                => 'nullable|in:L,P',
            'status'                => 'required|in:approved,pending,rejected',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'must_change_password'  => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($industri->image && Storage::disk('public')->exists($industri->image)) {
                Storage::disk('public')->delete($industri->image);
            }
            $validated['image'] = $request->file('image')->store('profile_photos', 'public');
        } else {
            unset($validated['image']);
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $validated['must_change_password'] = $request->has('must_change_password') ? 1 : 0;

        $industri->update($validated);

        return redirect()->route('admin.manajemen-industri.dashboard')
            ->with('success', 'Data industri berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $industri = User::where('role', 'industri')->findOrFail($id);

        if ($industri->image && Storage::disk('public')->exists($industri->image)) {
            Storage::disk('public')->delete($industri->image);
        }

        $industri->delete();

        return redirect()->route('admin.manajemen-industri.dashboard')
            ->with('success', 'Data industri beserta foto profil berhasil dihapus.');
    }
}
