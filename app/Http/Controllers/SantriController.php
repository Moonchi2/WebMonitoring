<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'santri';
        $keyword = trim($request->input('search'));
        $kelasId = $request->input('kelas');

        // Ambil semua data santri terlebih dahulu
        $allSantris = Santri::with('kelas')
            ->when($kelasId, fn($q) => $q->where('kelas_id', $kelasId))
            ->get();

        // Jika ada keyword, lakukan pencarian manual menggunakan DAC
        if ($keyword) {
            $filtered = $this->searchSantriDAC($allSantris->toArray(), $keyword);
            //  dd($filtered);
            $santris = collect($filtered);
        } else {
            $santris = $allSantris;
        }

        // Manual pagination
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $pagedData = new LengthAwarePaginator(
            $santris->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $santris->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $listKelas = Kelas::all();

        return view('pages.santri.index', [
            'type_menu' => $type_menu,
            'santris' => $pagedData,
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
            'nama' => 'required',
            'user_id' => 'required',
            'kelas_id' => 'required',
            'tanggal_lahir' => 'required|date',
            'nis' => 'required|unique:santris,nis',
            'jenis_kelamin' => 'required',
            'tanggal_masuk' => 'required|date',
            'alamat' => 'required',
            'no_telepon' => [
                'required',
                'regex:/^628/',
            ],
        ]);

        try {
            $santri = Santri::create([
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'kelas_id' => $request->kelas_id,
                'nis' => $request->nis,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);

            OrangTua::create([
                'user_id' => $request->user_id,
                'santri_id' => $santri->id,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
            ]);

            return redirect()->route('santri.index')->with('success', 'Data santri' . $santri->nama . 'berhasil disimpan');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }
    public function edit(Santri $santri)
    {
        $type_menu = 'santri';
        $listKelas = Kelas::all();
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
            'nama' => 'required',
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal_lahir' => 'required|date',
            'nis' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_masuk' => 'required|date',
            'alamat' => 'required',
            'no_telepon' => [
                'required',
                'regex:/^628/', // Hanya nomor HP Indonesia dengan awalan 628
            ],
        ]);

        try {
            // Update data santri
            $santri->update([
                'nama' => $request->nama,
                'tanggal_lahir' => $request->tanggal_lahir,
                'kelas_id' => $request->kelas_id,
                'nis' => $request->nis,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);

            // Ambil atau buat data orang tua
            $orang_tua = $santri->orangTua; // Pastikan relasi orangTua() ada di model Santri

            if ($orang_tua) {
                $orang_tua->update([
                    'user_id' => $request->user_id,
                    'alamat' => $request->alamat,
                    'no_telepon' => $request->no_telepon,
                ]);
            } else {
                // Jika belum ada, buat baru
                $santri->orangTua()->create([
                    'user_id' => $request->user_id,
                    'alamat' => $request->alamat,
                    'no_telepon' => $request->no_telepon,
                ]);
            }

            return redirect()->route('santri.index')->with('success', 'Data ' . $santri->nama . ' berhasil diperbarui');
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
        return Redirect::route('santri.index')->with('success', $santri->nama . 'berhasil di hapus.');
    }
    private function searchSantriDAC(array $data, string $keyword): array
    {
        // Basis: Jika hanya 1 item, cek apakah cocok
        if (count($data) <= 1) {
            if (!empty($data) && stripos($data[0]['nama'], $keyword) !== false) {
                return [$data[0]];
            }
            return [];
        }

        // Bagi array jadi dua
        $mid = floor(count($data) / 2);
        $left = array_slice($data, 0, $mid);
        $right = array_slice($data, $mid);

        // Rekursif ke kiri dan kanan
        $leftResult = $this->searchSantriDAC($left, $keyword);
        $rightResult = $this->searchSantriDAC($right, $keyword);

        // Gabungkan hasil
        return array_merge($leftResult, $rightResult);
    }
}
