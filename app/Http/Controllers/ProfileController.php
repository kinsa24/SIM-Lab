<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Data profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'min:6', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }

    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user = User::find(Auth::id());

        // Hapus foto lama jika ada
        if ($user->foto) {
            Storage::disk('public')->delete('foto/' . $user->foto);
        }

        $filename = time() . '_' . $user->id . '.' . $request->foto->extension();
        $request->foto->storeAs('foto', $filename, 'public');

        $user->foto = $filename;
        $user->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}
