<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'     => 'required|string|max:255',
            'jabatan'  => 'nullable|string|max:255',
            'divisi'   => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $user->name    = $request->name;
        $user->jabatan = $request->jabatan;
        $user->divisi  = $request->divisi;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
