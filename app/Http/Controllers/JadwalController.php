<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Hash;
use Illuminate\Http\Request;
use Redirect;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'kelola';

        // ambil data dari tabel jadwal berdasarkan nama jika terdapat request
        $keyword = trim($request->input('name'));
        $role = $request->input('role');

        // Query jadwals dengan filter pencarian dan role
        $jadwals = Jadwal::when($keyword, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $jadwals->appends(['name' => $keyword, 'role' => $role]);

        // arahkan ke file pages/jadwals/index.blade.php
        return view('pages.jadwals.index', compact('type_menu', 'jadwals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'jadwal';

        // arahkan ke file pages/jadwals/create.blade.php
        return view('pages.jadwals.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data dari form tambah jadwal
        $validatedData = $request->validate([
            'guru_id' => 'required',
            'mapel_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'nullable',
            'jam_selesai' =>'nullable',
        ]);
    
        //masukan data kedalam tabel jadwals
        jadwal::create([
            'guru_id' => $validatedData['name'],
            'mapel_id' => $validatedData['email'],
            'hari' => $validatedData['password'],
            'jam_mulai' => $validatedData['role'],
            'jam_selesai'=> $validatedData['no_handphone'],
        ]);

        //jika proses berhsil arahkan kembali ke halaman jadwals dengan status success
        return Redirect::route('jadwal.index')->with('success', 'jadwal ' . $validatedData['name'] . ' berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(jadwal $jadwal)
    {
        $type_menu = 'jadwal';

        // arahkan ke file pages/jadwals/edit
        return view('pages.jadwals.edit', compact('jadwal', 'type_menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, jadwal $jadwal)
    {
        // Validate the form data
        $request->validate([
            'guru_id' => 'required',
            'mapel_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'nullable',
            'jam_selesai' =>'nullable',
        ]);

        // Update the jadwal data
        $jadwal->update([
            'guru_id' => $request->guruid,
            'mapel_id' => $request->mapelid,
            'hari' => $request->hari,
            'jam_mulai'=> $request->jam_mulai,
            'jam_selesai'=> $request->jam_selesai,
        ]);

        return Redirect::route('jadwal.index')->with('success', 'jadwal ' . $jadwal->name . ' berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(jadwal $jadwal)
    {
        $jadwal->delete();
        return Redirect::route('jadwal.index')->with('success', 'jadwal '. $jadwal->name . ' berhasil di hapus.');
    }
    public function show($id)
    {
        $type_menu = 'jadwal';
        $jadwal = jadwal::find($id);

        // arahkan ke file pages/jadwals/edit
        return view('pages.jadwals.show', compact('jadwal', 'type_menu'));
    }
}