<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Redirect;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'kelola';

        // ambil data dari tabel matapelajaran berdasarkan nama jika terdapat request
        $keyword = trim($request->input('name'));
        $role = $request->input('role');

        // Query matapelajarans dengan filter pencarian dan role
        $matapelajarans = MataPelajaran::when($keyword, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $matapelajarans->appends(['name' => $keyword, 'role' => $role]);

        // arahkan ke file pages/matapelajarans/index.blade.php
        return view('pages.matapelajarans.index', compact('type_menu', 'matapelajarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'matapelajaran';

        // arahkan ke file pages/matapelajarans/create.blade.php
        return view('pages.matapelajarans.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data dari form tambah matapelajaran
        $validatedData = $request->validate([
            'guru_id' => 'required',
            'mata_pelajaran' => 'required',
        ]);
    
        //masukan data kedalam tabel matapelajarans
        matapelajaran::create([
            'guru_id' => $validatedData['guru'],
            'mata_pelajaran' => $request->matapelajaran,
        ]);

        //jika proses berhsil arahkan kembali ke halaman matapelajarans dengan status success
        return Redirect::route('matapelajaran.index')->with('success', 'matapelajaran ' . $validatedData['name'] . ' berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(matapelajaran $matapelajaran)
    {
        $type_menu = 'matapelajaran';

        // arahkan ke file pages/matapelajarans/edit
        return view('pages.matapelajarans.edit', compact('matapelajaran', 'type_menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, matapelajaran $matapelajaran)
    {
        // Validate the form data
        $request->validate([
            'nama' => 'required',
        ]);

        // Update the matapelajaran data
        $matapelajaran->update([
            'nama' => $request->nama,
        ]);

        return Redirect::route('matapelajaran.index')->with('success', 'matapelajaran ' . $matapelajaran->name . ' berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(matapelajaran $matapelajaran)
    {
        $matapelajaran->delete();
        return Redirect::route('matapelajaran.index')->with('success', 'matapelajaran '. $matapelajaran->name . ' berhasil di hapus.');
    }
    public function show($id)
    {
        $type_menu = 'matapelajaran';
        $matapelajaran = matapelajaran::find($id);

        // arahkan ke file pages/matapelajarans/edit
        return view('pages.matapelajarans.show', compact('matapelajaran', 'type_menu'));
    }
}
