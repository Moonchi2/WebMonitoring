<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Redirect;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'kelola';

        // ambil data dari tabel kelas berdasarkan nama jika terdapat request
        $keyword = trim($request->input('name'));
        $role = $request->input('role');

        // Query kelass dengan filter pencarian dan role
        $kelass = kelas::when($keyword, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $kelass->appends(['name' => $keyword, 'role' => $role]);

        // arahkan ke file pages/kelass/index.blade.php
        return view('pages.kelas.index', compact('type_menu', 'kelass'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'kelas';

        // arahkan ke file pages/kelass/create.blade.php
        return view('pages.kelass.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data dari form tambah kelas
        $validatedData = $request->validate([
            'nama' => 'required',
        ]);
    
        //masukan data kedalam tabel kelass
        kelas::create([
            'nama' => $validatedData['nama'],
        ]);

        //jika proses berhsil arahkan kembali ke halaman kelass dengan status success
        return Redirect::route('kelas.index')->with('success', 'kelas ' . $validatedData['name'] . ' berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        $type_menu = 'kelas';

        // arahkan ke file pages/kelas/edit
        return view('pages.kelas.edit', compact('kelas', 'type_menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, kelas $kelas)
    {
        // Validate the form data
        $request->validate([
            'nama' => 'required',
        ]);

        // Update the kelas data
        $kelas->update([
            'nama' => $request->nama,
        ]);

        return Redirect::route('kelas.index')->with('success', 'kelas ' . $kelas->name . ' berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(kelas $kelas)
    {
        $kelas->delete();
        return Redirect::route('kelas.index')->with('success', 'kelas '. $kelas->name . ' berhasil di hapus.');
    }
    public function show($id)
    {
        $type_menu = 'kelas';
        $kelas = kelas::find($id);

        // arahkan ke file pages/kelass/edit
        return view('pages.kelass.show', compact('kelas', 'type_menu'));
    }
}
