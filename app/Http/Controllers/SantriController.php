<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;
use Redirect;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'Santri';

        // ambil data dari tabel santri berdasarkan nama jika terdapat request
        $keyword = trim($request->input('name'));
        $role = $request->input('role');

        // Query santris dengan filter pencarian dan role
        $santris = Santri::when($keyword, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $santris->appends(['name' => $keyword, 'role' => $role]);

        // arahkan ke file pages/santris/index.blade.php
        return view('pages.santris.index', compact('type_menu', 'santris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'santri';

        // arahkan ke file pages/santris/create.blade.php
        return view('pages.santris.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data dari form tambah santri
        $validatedData = $request->validate([
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'nis' => 'required',
            'kelas_id' => 'required',
            'tanggal_masuk' =>'required',
        ]);
    
        //masukan data kedalam tabel santris
        santri::create([
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'nis' => $validatedData['nis'],
            'kelas_id' => $validatedData['kelas_id'],
            'tanggal_masuk'=> $validatedData['tanggal_masuk'],
        ]);

        //jika proses berhsil arahkan kembali ke halaman santris dengan status success
        return Redirect::route('santri.index')->with('success', 'santri ' . $validatedData['name'] . ' berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(santri $santri)
    {
        $type_menu = 'santri';

        // arahkan ke file pages/santris/edit
        return view('pages.santris.edit', compact('santri', 'type_menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, santri $santri)
    {
        // Validate the form data
        $request->validate([
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'nis' => 'required',
            'kelas_id' => 'required',
            'tanggal_masuk' =>'required',
        ]);

        // Update the santri data
        $santri->update([
            'tanggal_lahir' => $request->tanggallahir,
            'jenis_kelamin' => $request->jeniskelamin,
            'nis' => $request->nis,
            'kelas_id'=> $request->kelas_id,
            'tanggal_masuk'=> $request->tanggalmasuk,
        ]);

        return Redirect::route('santri.index')->with('success', 'santri ' . $santri->name . ' berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(santri $santri)
    {
        $santri->delete();
        return Redirect::route('santri.index')->with('success', 'santri '. $santri->name . ' berhasil di hapus.');
    }
    public function show($id)
    {
        $type_menu = 'santri';
        $santri = santri::find($id);

        // arahkan ke file pages/santris/edit
        return view('pages.santris.show', compact('santri', 'type_menu'));
    }
}
