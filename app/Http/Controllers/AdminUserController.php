<?php

// app/Http/Controllers/AdminUserController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
        public function dashboardStats()
    {
        $stats = User::select('role_id', DB::raw('count(*) as total'))
            ->groupBy('role_id')
            ->with('role')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->role->name => $item->total];
            });
        return response()->json($stats);
    }

    
    public function bulkDelete(Request $request)
    {
        $request->validate(['user_ids' => 'required|array']);
        
        User::whereIn('user_id', $request->user_ids)->delete();
        
        History::create([
            'user_id' => auth()->user()->user_id,
            'action' => 'Bulk Delete Users',
            'model_type' => User::class,
            'model_id' => 0,
            'details' => ['deleted_ids' => $request->user_ids]
        ]);

        return response()->json(['message' => 'Pengguna berhasil dihapus']);
    }

    
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $user->name = $validated['name'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        return response()->json(['message' => 'Profil berhasil diperbarui']);
    }
}