<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kegiatan;
use App\Models\Santri;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'kegiatan';

        // ambil data dari tabel kegiatan berdasarkan nama jika terdapat request
        $keyword = trim($request->input('name'));
        $role = $request->input('role');

        // Query kegiatans dengan filter pencarian dan role
        $kegiatans = Kegiatan::when($keyword, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $kegiatans->appends(['name' => $keyword, 'role' => $role]);

        // arahkan ke file pages/kegiatans/index.blade.php
        return view('pages.kegiatan.index', compact('type_menu', 'kegiatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'kegiatan';

        // arahkan ke file pages/kegiatans/create.blade.php
        return view('pages.kegiatans.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data dari form tambah kegiatan
        $validatedData = $request->validate([
            'jadwal_id' => 'required',
            'santri_id' => 'required',
            'jenis_kegiatan' => 'required',
            'tanggal_kegiatan' => 'required',
            'status' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif',
            'catatan' => 'nullable',
        ]);
        // Handle the image upload if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('img/user/', $imagePath);
        }
        //masukan data kedalam tabel kegiatans
        $kegiatan = kegiatan::create([
            'jadwal_id' => $validatedData['jadwal_id'],
            'santri_id' => $validatedData['santri_id'],
            'jenis_kegiatan' => $validatedData['jenis_kegiatan'],
            'tanggal_kegiatan' => $validatedData['tanggal_kegiatan'],
            'status' => $validatedData['status'],
            'image' => $imagePath,
            'catatan' => $validatedData['catatan'],
        ]);

        //jika proses berhsil arahkan kembali ke halaman kegiatans dengan status success
        return Redirect::route('kegiatan.index')->with('success', 'kegiatan ' . $kegiatan->santri->nama . ' berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(kegiatan $kegiatan)
    {
        $type_menu = 'kegiatan';
        $jadwal = Jadwal::all();
        $santri = Santri::all();
        // arahkan ke file pages/kegiatans/edit
        return view('pages.kegiatans.edit', compact('kegiatan', 'type_menu', 'jadwal', 'santri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, kegiatan $kegiatan)
    {
        // Validate the form data
        $request->validate([
            'jadwal_id' => 'required',
            'santri_id' => 'required',
            'jenis_kegiatan' => 'required',
            'tanggal_kegiatan' => 'required',
            'status' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif',
            'catatan' => 'nullable',
        ]);

        // Update the kegiatan data
        $kegiatan->update([
            'jadwal_id' => $request->guru_id,
            'santri_id' => $request->mapel_id,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('img/kegitan/', $path);
            $kegiatan->update([
                'image' => $path
            ]);
        }

        return Redirect::route('kegiatan.index')->with('success', 'kegiatan ' . $kegiatan->santri->name . ' berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(kegiatan $kegiatan)
    {
        $kegiatan->delete();
        return Redirect::route('kegiatan.index')->with('success', 'kegiatan ' . $kegiatan->name . ' berhasil di hapus.');
    }
    public function show($id)
    {
        $type_menu = 'kegiatan';
        $kegiatan = kegiatan::find($id);

        // arahkan ke file pages/kegiatans/edit
        return view('pages.kegiatans.show', compact('kegiatan', 'type_menu'));
    }
}
