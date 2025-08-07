<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kegiatan;
use App\Models\Kelas;
use App\Models\Santri;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Cek role dan relasi
        if ($user->role === 'Guru') {
            $guru = $user->guru;
            if (!$guru) {
                dd('Guru tidak ditemukan untuk user ID ' . $user->id);
            }
        } elseif ($user->role === 'Orang Tua') {
            $orangtua = $user->orangtua;
            if (!$orangtua) {
                dd('Orang Tua tidak ditemukan untuk user ID ' . $user->id);
            }
        }

        // Mulai query
        $query = Jadwal::with(['kelas', 'mapel', 'guru.user']);

        if ($user->role === 'Guru') {
            $guru = $user->guru;
            $query->where('guru_id', $guru->id);
        } elseif ($user->role === 'OrangTua') {
            $orangtua = $user->orangtua;
            $santri = Santri::where('id', $orangtua->santri_id)->get();
            $query->where('kelas_id', $santri->kelas_id);
        }

        // Filter dan search
        if ($request->filled('q')) {
            $query->where(function ($q1) use ($request) {
                $q1->whereHas('guru.user', function ($q2) use ($request) {
                    $q2->where('name', 'like', '%' . $request->q . '%');
                })->orWhereHas('mapel', function ($q3) use ($request) {
                    $q3->where('nama', 'like', '%' . $request->q . '%');
                });
            });
        }

        if ($request->filled('kelas_id') && $user->role !== 'siswa') {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        $jadwals = $query->paginate(10)->withQueryString();
        $kelasList = ($user->role !== 'Siswa') ? Kelas::all() : [];

        return view('pages.kegiatan.index', [
            'type_menu' => 'kegiatan',
            'jadwals' => $jadwals,
            'kelasList' => $kelasList,
            'selectedKelas' => $request->kelas_id,
            'selectedHari' => $request->hari,
            'searchQuery' => $request->q,
        ]);
    }
    public function add(Jadwal $kegiatan)
    {
        $santris = Santri::where('kelas_id', $kegiatan->kelas_id)->get();

        return view('pages.kegiatan.create', [
            'type_menu' => 'absen',
            'jadwals' => $kegiatan,
            'santris' => $santris,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'santri_id' => 'required|array',
            'jenis_kegiatan' => 'required|array',
            'jenis_kegiatan.*' => 'required|string|in:Belajar,Hafalan,Ujian',
            'status' => 'required|array',
            'status.*' => 'required|string|in:Hadir,Izin,Sakit',
            'catatan' => 'nullable|array',
            'catatan.*' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jadwal_id' => 'required|integer|exists:jadwals,id',
        ]);

        $santriIds = $request->input('santri_id');
        $jenis_kegiatan = $request->input('jenis_kegiatan');
        $status = $request->input('status');
        $catatan = $request->input('catatan', []);
        $jadwalId = $request->input('jadwal_id');

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/kegiatan/'), $imagePath);
        }

        foreach ($santriIds as $santriId) {
            Kegiatan::create([
                'tanggal_kegiatan' => now(),
                'jenis_kegiatan' => $jenis_kegiatan[$santriId] ?? null,
                'status' => $status[$santriId] ?? null,
                'catatan' => $catatan[$santriId] ?? null,
                'image' => $imagePath,
                'jadwal_id' => $jadwalId,
                'santri_id' => $santriId,
            ]);
        }

        return redirect()->route('kegiatan.index')->with('success', 'Data Kegiatan berhasil disimpan.');
    }

    public function edit(Jadwal $kegiatan)
    {
        $santris = Santri::where('kelas_id', $kegiatan->kelas_id)->get();

        // Ambil semua kegiatan yang terkait jadwal tersebut
        $kegiatanData = Kegiatan::where('jadwal_id', $kegiatan->id)
            ->get()
            ->keyBy('santri_id'); // supaya bisa diakses dengan $kegiatanData[$santri->id]

        return view('pages.kegiatan.edit', [
            'type_menu' => 'absen',
            'jadwals' => $kegiatan,
            'santris' => $santris,
            'kegiatanData' => $kegiatanData,
        ]);
    }

    public function update(Request $request, Jadwal $kegiatan)
    {
        $request->validate([
            'santri_id' => 'required|array',
            'jenis_kegiatan' => 'required|array',
            'jenis_kegiatan.*' => 'required|string|in:Belajar,Hafalan,Ujian',
            'status' => 'required|array',
            'status.*' => 'required|string|in:Hadir,Izin,Sakit',
            'catatan' => 'nullable|array',
            'catatan.*' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $santriIds = $request->input('santri_id');
        $jenis_kegiatan = $request->input('jenis_kegiatan');
        $status = $request->input('status');
        $catatan = $request->input('catatan', []);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/kegiatan/'), $imagePath);
        }

        foreach ($santriIds as $santriId) {
            $kegiatan = Kegiatan::where('jadwal_id', $kegiatan->id)
                ->where('santri_id', $santriId)
                ->first();

            if ($kegiatan) {
                $kegiatan->update([
                    'jenis_kegiatan' => $jenis_kegiatan[$santriId] ?? $kegiatan->jenis_kegiatan,
                    'status' => $status[$santriId] ?? $kegiatan->status,
                    'catatan' => $catatan[$santriId] ?? $kegiatan->catatan,
                    'image' => $imagePath ?? $kegiatan->image,
                ]);
            }
        }

        return redirect()->route('kegiatan.index')->with('success', 'Data Kegiatan berhasil diperbarui.');
    }

    public function show(Request $request, $id)
    {
        $jadwal = Jadwal::with('kelas', 'mapel')->findOrFail($id);
        $kelasList = Kelas::orderBy('nama')->get(); // Ambil daftar kelas

        // Ambil semua data kegiatan yang sesuai filter
        $allKegiatan = Kegiatan::with('jadwal.kelas')
            ->where('jadwal_id', $id)
            ->when(
                $request->filled('hari'),
                fn($q) =>
                $q->whereHas('jadwal', fn($q2) => $q2->where('hari', $request->hari))
            )
            ->when(
                $request->filled('kelas_id'),
                fn($q) =>
                $q->whereHas('jadwal.kelas', fn($q2) => $q2->where('id', $request->kelas_id))
            )
            ->when(
                $request->filled('tanggal'),
                fn($q) =>
                $q->whereDate('tanggal_kegiatan', $request->tanggal)
            )
            ->get();

        // Group berdasarkan pertemuan dan tanggal
        $grouped = $allKegiatan->groupBy(fn($item) => $item->tanggal_kegiatan);

        // Buat data koleksi baru
        $data = $grouped->map(function ($group) {
            $first = $group->first();
            return (object) [
                'id' => $first->id,
                'tanggal_kegiatan' => $first->tanggal_kegiatan,
                'jadwal' => $first->jadwal,
                'total_santri' => $group->count(),
                'total_status' => $group->where('status', 'Hadir')->count(),
            ];
        })->values(); // Reset index

        // Manual pagination
        $page = $request->input('page', 1);
        $perPage = 10;
        $pagedData = new \Illuminate\Pagination\LengthAwarePaginator(
            $data->forPage($page, $perPage),
            $data->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $type_menu = 'kegiatan';

        return view('pages.kegiatan.show', [
            'type_menu' => $type_menu,
            'kegiatan' => $pagedData,
            'jadwal' => $jadwal,
            'kelasList' => $kelasList,
        ]);
    }
    public function view($id)
    {
        $user = Auth::user();
        $type_menu = 'kegiatan';

        // Ambil satu kegiatan sebagai referensi (tanggal & jadwal)
        $kegiatan = Kegiatan::with('jadwal')->findOrFail($id);

        // Ambil semua kegiatan yang sama (tanggal & jadwal sama)
        $query = Kegiatan::with('santri', 'jadwal')
            ->where('tanggal_kegiatan', $kegiatan->tanggal_kegiatan)
            ->where('jadwal_id', $kegiatan->jadwal_id);

        // Filter berdasarkan role
        if ($user->role === 'Orang Tua') {
            $santriId = $user->orangtua->santri_id ?? null;
            $query->where('santri_id', $santriId);
        }

        $daftarKegiatan = $query->get();

        return view('pages.kegiatan.view', [
            'type_menu' => $type_menu,
            'kegiatan' => $kegiatan,
            'daftarKegiatan' => $daftarKegiatan,
        ]);
    }
}
