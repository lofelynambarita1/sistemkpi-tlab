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
        $stats = User::select('role', DB::raw('count(*) as total'))
            ->whereIn('role', ['associate', 'intermediate', 'senior', 'lead', 'principle', 'hr', 'manager'])
            ->groupBy('role')
            ->pluck('total', 'role');

        return view('admin.dashboard', compact('user', 'stats'));
    }

    /**
     * Daftar semua user
     */
    public function users(Request $request)
    {
        $user  = Auth::user();
        $query = User::withTrashed();

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
        return view('admin.users.create', compact('user'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:8',
            'role'        => 'required|in:associate,intermediate,senior,lead,principle,hr,manager',
            'employee_id' => 'nullable|string|unique:users,employee_id',
            'department'  => 'nullable|string|max:255',
            'jabatan'     => 'nullable|string|max:255',
            'status_akun' => 'required|in:aktif,nonaktif',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'employee_id' => $request->employee_id,
            'department'  => $request->department,
            'jabatan'     => $request->jabatan,
            'status_akun' => $request->status_akun,
        ]);

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function editUser(User $user)
    {
        $authUser = Auth::user();
        return view('admin.users.edit', ['user' => $user, 'authUser' => $authUser]);
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,'.$user->id,
            'role'        => 'required|in:associate,intermediate,senior,lead,principle,hr,manager',
            'employee_id' => 'nullable|string|unique:users,employee_id,'.$user->id,
            'department'  => 'nullable|string|max:255',
            'jabatan'     => 'nullable|string|max:255',
            'status_akun' => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->only(['name','email','role','employee_id','department','jabatan','status_akun']);
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.users')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroyUser(User $user)
    {
        $user->delete(); // soft delete
        return back()->with('success', 'Pengguna berhasil dihapus/dinonaktifkan!');
    }

    /**
     * Bulk delete
     */
    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        User::whereIn('id', $request->ids)->delete();
        return back()->with('success', count($request->ids) . ' pengguna berhasil dihapus!');
    }

    /**
     * Import user via CSV
     */
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
                    'department'  => $data['department'] ?? null,
                    'jabatan'     => $data['jabatan'] ?? null,
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