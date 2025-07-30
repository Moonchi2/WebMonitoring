<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'santri';

        $keyword = trim($request->input('search'));
        $kelasId = $request->input('kelas'); // kelas yang dipilih

        $query = Santri::with(['user', 'kelas']);

        if ($keyword) {
            $query->whereHas('user', function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            });
        }

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $siswas = $query->latest()->paginate(10);
        $siswas->appends($request->only(['search', 'kelas']));

        $listKelas = Kelas::all();

        return view('pages.santri.index', [
            'type_menu' => $type_menu,
            'siswas' => $siswas,
            'listKelas' => $listKelas,
            'kelasId' => $kelasId,
            'keyword' => $keyword
        ]);
    }
    public function create()
    {
        $type_menu = 'santri';
        $listKelas = Kelas::all();
        $listUser = User::where('role', 'Orang Tua')->get();

        return view('pages.santri.create', [
            'type_menu' => $type_menu,
            'listKelas' => $listKelas,
            'listUser' => $listUser
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|unique:orangtuas,user_id',
            'kelas_id' => 'required',
            'tanggal_lahir' => 'required|date',
            'nis' => 'required|unique:santris,nis',
            'jenis_kelamin' => 'required',
            'tanggal_masuk' => 'required',
            'alamat' => 'required',
            'no_telepon' => [
                'required',
                'regex:/^628/',
            ],
        ]);

        try {
            $santri = Santri::create([
                'tanggal_lahir' => $request->tanggal_lahir,
                'kelas_id' => $request->kelas_id,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telepon' => $request->no_telepon,
            ]);

            OrangTua::create([
                'user_id' => $request->user_id,
                'santri_id' => $santri->id,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon_ortu,
            ]);

            return redirect()->route('santri.index')->with('success', 'Data santri berhasil disimpan');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }
    public function edit(Santri $santri)
    {
        $type_menu = 'santri';
        $listKelas = Kelas::where('status', 'Aktif')->get();
        $listUser = User::where('role', 'Orang Tua')->get();

        // Ambil data orang tua berdasarkan siswa_id
        $ortu = OrangTua::where('santri_id', $santri->id)->first();
        $hubunganOptions = ['Ayah', 'Ibu', 'Wali'];

        return view('pages.santri.edit', compact(
            'type_menu',
            'listKelas',
            'listUser',
            'santri',
            'ortu',
            'hubunganOptions'
        ));
    }

    public function update(Request $request, Santri $santri)
    {
        $request->validate([
            'user_id' => 'required|unique:orangtuas,user_id',
            'kelas_id' => 'required',
            'tanggal_lahir' => 'required|date',
            'nis' => 'required|unique:santris,nis',
            'jenis_kelamin' => 'required',
            'tanggal_masuk' => 'required',
            'alamat' => 'required',
            'no_telepon' => [
                'required',
                'regex:/^628/',
            ],
        ]);

        try {
            // Update data siswa
            $santri->update([
                'tanggal_lahir' => $request->tanggal_lahir,
                'kelas_id' => $request->kelas_id,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telepon' => $request->no_telepon,
            ]);

            // Update atau buat data orang tua
            OrangTua::updateOrCreate(
                ['santri_id' => $santri->id],
                [
                    'user_id' => $request->user_id,
                    'alamat' => $request->alamat,
                    'no_telepon' => $request->no_telepon_ortu,
                ]
            );

            return redirect()->route('santri .index')->with('success', 'Data ' . $santri . ' berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Santri $santri)
    {
        $type_menu = 'santri';
        $ortu = OrangTua::where('santri_id', $santri->id)->first();

        return view('pages.santri.show', compact(
            'type_menu',
            'santri',
            'ortu'
        ));
    }

    public function destroy(Santri $santri)
    {
        $santri->delete();
        return Redirect::route('santri.index')->with('success', $santri . 'berhasil di hapus.');
    }
}
