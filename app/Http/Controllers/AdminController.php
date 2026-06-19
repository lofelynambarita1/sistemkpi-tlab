<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\KpiDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user  = Auth::user();
        $roleCounts = User::select('role', DB::raw('count(*) as total'))
            ->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle', 'hr', 'manager', 'admin'])
            ->groupBy('role')
            ->pluck('total', 'role');

        return view('dashboard.admin', compact('user', 'roleCounts'));
    }

    /**
     * Daftar semua user
     */
    public function users(Request $request)
    {
        $user  = Auth::user();
        $query = User::query()->with('atasan');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%')
                  ->orWhere('employee_id', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('status')) {
            $query->where('status_akun', $request->status);
        }

        $sortBy  = $request->get('sort', 'created_at');
        $sortDir = $request->get('dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        $users = $query->paginate(15)->withQueryString();
        return view('admin.users.index', compact('user', 'users'));
    }

    public function createUser()
    {
        $user = Auth::user();
        $users = User::where('status_akun', 'aktif')->orderBy('name')->get();
        return view('admin.users.create', compact('user', 'users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:8|confirmed',
            'role'        => 'required|in:associate,intermediate,senior,lead,principle,hr,lead_hr,manager,admin',
            'employee_id' => 'nullable|string|unique:users,employee_id',
            'divisi'      => 'nullable|string|max:255',
            'jabatan'     => 'nullable|string|max:255',
            'atasan_id'   => 'nullable|exists:users,id',
            'status_akun' => 'required|in:aktif,nonaktif',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'employee_id' => $request->employee_id,
            'department'  => $request->divisi,
            'jabatan'     => $request->jabatan,
            'atasan_id'   => $request->atasan_id,
            'status_akun' => $request->status_akun,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function showUser(User $user)
    {
        $authUser = Auth::user();
        $user->load('atasan');
        return view('admin.users.show', compact('user', 'authUser'));
    }

    public function toggleStatus(User $user)
    {
        $user->status_akun = $user->status_akun === 'aktif' ? 'nonaktif' : 'aktif';
        $user->save();
        return back()->with('success', 'Status pengguna berhasil diubah!');
    }

    public function editUser(User $user)
    {
        $authUser = Auth::user();
        $users = User::where('status_akun', 'aktif')
            ->where('id', '!=', $user->id)
            ->orderBy('name')
            ->get();
        return view('admin.users.edit', ['user' => $user, 'authUser' => $authUser, 'users' => $users]);
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,'.$user->id,
            'role'        => 'required|in:associate,intermediate,senior,lead,principle,hr,lead_hr,manager,admin',
            'employee_id' => 'nullable|string|unique:users,employee_id,'.$user->id,
            'divisi'      => 'nullable|string|max:255',
            'jabatan'     => 'nullable|string|max:255',
            'atasan_id'   => 'nullable|exists:users,id',
            'status_akun' => 'required|in:aktif,nonaktif',
        ]);

        $data = [
            'name'        => $request->name,
            'email'       => $request->email,
            'role'        => $request->role,
            'employee_id' => $request->employee_id,
            'department'  => $request->divisi,
            'jabatan'     => $request->jabatan,
            'atasan_id'   => $request->atasan_id,
            'status_akun' => $request->status_akun,
        ];
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        User::whereIn('id', $request->ids)->delete();
        return back()->with('success', count($request->ids) . ' pengguna berhasil dihapus!');
    }

    public function importUsers(Request $request)
    {
        $request->validate(['file' => 'required|mimes:csv,txt|max:2048']);
        $file = $request->file('file');
        $rows = array_map('str_getcsv', file($file->getRealPath()));
        $header = array_shift($rows);
        $count  = 0;

        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $data = array_combine($header, $row);
                if (User::where('email', $data['email'])->exists()) continue;
                User::create([
                    'name'        => $data['name'] ?? '',
                    'email'       => $data['email'] ?? '',
                    'password'    => Hash::make($data['password'] ?? 'password123'),
                    'role'        => $data['role'] ?? 'associate',
                    'employee_id' => $data['employee_id'] ?? null,
                    'department'  => $data['divisi'] ?? $data['department'] ?? null,
                    'jabatan'     => $data['jabatan'] ?? null,
                    'atasan_id'   => $data['atasan_id'] ?? null,
                    'status_akun' => 'aktif',
                ]);
                $count++;
            }
            DB::commit();
            return back()->with('success', "{$count} pengguna berhasil diimport!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function exportUsers()
    {
        $users = User::with('atasan')->orderBy('name')->get();

        $total = $users->count();
        $aktif = $users->where('status_akun', 'aktif')->count();
        $karyawan = $users->whereIn('role', ['associate','intermediate','senior','lead','principle'])->count();
        $adminManager = $users->whereIn('role', ['admin','manager','lead_hr','hr'])->count();

        return view('admin.users.export', compact('users', 'total', 'aktif', 'karyawan', 'adminManager'));
    }

    /**
     * Profile admin
     */
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'     => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $data = ['name' => $request->name];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}