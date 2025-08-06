<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $type_menu = 'profile';
        $user = Auth::user();
        return view('pages.profile.index', compact('type_menu', 'user', ));
    }
    public function edit()
    {
        $type_menu = 'profile';
        $kelasList = Kelas::all(); // jika role siswa
        return view('pages.profile.edit', compact('type_menu', 'kelasList'));
    }

    public function update(Request $request, User $user)
    {
        $role = $user->role;

        // Validasi umum
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Role-based rules
        if ($role === 'Siswa') {
            $rules = array_merge($rules, [
                'nama' => 'required',
                'tanggal_lahir' => 'required',
                'nis' => 'required|unique:siswas,nis,' . optional($user->siswa)->id,
                'kelas_id' => 'required|exists:kelas,id',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'tanggal_masuk' => 'required',
                'alamat' => 'nullable',
                'no_telepon' => 'required|regex:/^628/',
            ]);
        } elseif ($role === 'Guru') {
            $rules = array_merge($rules, [
                'nip' => 'required|unique:gurus,nip,' . optional($user->guru)->id,
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'no_telepon' => 'required|regex:/^628/',
            ]);
        } elseif ($role === 'Orang Tua') {
            $rules = array_merge($rules, [
                'nama' => 'required',
                'tanggal_lahir' => 'required',
                'nis' => 'required|unique:santris,nis,' . optional(optional($user->orangtua)->santri)->id,
                'kelas_id' => 'required|exists:kelas,id',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'tanggal_masuk' => 'required',
                'alamat' => 'nullable',
                'no_telepon' => 'required|regex:/^628/',
            ]);
        }

        $validated = $request->validate($rules);

        // Handle foto profil
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('img/user'), $filename);

            // Hapus foto lama
            if ($user->image && file_exists(public_path('img/user/' . $user->image))) {
                unlink(public_path('img/user/' . $user->image));
            }

            $user->image = $filename;
        }

        // Update user
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        // === Role: Orang Tua ===
        if ($role === 'Orang Tua' && $user->orangtua && $user->orangtua->santri) {
            $user->orangtua->santri->update([
                'nama' => $validated['nama'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'nis' => $validated['nis'],
                'kelas_id' => $validated['kelas_id'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_masuk' => $validated['tanggal_masuk'],
            ]);

            $user->orangtua->update([
                'alamat' => $validated['alamat'],
                'no_telepon' => $validated['no_telepon'],
            ]);
        }

        // === Role: Guru ===
        if ($role === 'Guru' && $user->guru) {
            $user->guru->update([
                'nip' => $validated['nip'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_telepon' => $validated['no_telepon'],
            ]);
        }

        // === Role: Siswa ===
        if ($role === 'Siswa' && $user->siswa) {
            $user->siswa->update([
                'nama' => $validated['nama'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'nis' => $validated['nis'],
                'kelas_id' => $validated['kelas_id'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_masuk' => $validated['tanggal_masuk'],
                'alamat' => $validated['alamat'],
                'no_telepon' => $validated['no_telepon'],
            ]);
        }

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
    public function changePasswordForm()
    {
        $type_menu = 'profile';
        return view('pages.profile.change-password', compact('type_menu'));
    }
    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update the new password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile.index')->with('success', 'password Akun ' . $user->name . ' berhasil diperbarui.');
    }
}
