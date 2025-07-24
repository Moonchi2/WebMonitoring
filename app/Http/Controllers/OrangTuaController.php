<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use Illuminate\Http\Request;
use Redirect;

class OrangTuaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'orangtua';

        // ambil data dari tabel orangtua berdasarkan nama jika terdapat request
        $keyword = trim($request->input('name'));
        $role = $request->input('role');

        // Query orangtuas dengan filter pencarian dan role
        $orangtuas = OrangTua::when($keyword, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $orangtuas->appends(['name' => $keyword, 'role' => $role]);

        // arahkan ke file pages/orangtuas/index.blade.php
        return view('pages.orangtuas.index', compact('type_menu', 'orangtuas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'orangtua';

        // arahkan ke file pages/orangtuas/create.blade.php
        return view('pages.orangtuas.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data dari form tambah orangtua
        $validatedData = $request->validate([
            'user_id' => 'required',
            'santri_id' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required',
        ]);
    
        //masukan data kedalam tabel orangtuas
        orangtua::create([
            'user_id' => $validatedData['user_id'],
            'santri_id' => $validatedData['santri_id'],
            'alamat' => $validatedData['alamat'],
            'no_telepon' => $validatedData['no_telepon']
        ]);

        //jika proses berhsil arahkan kembali ke halaman orangtuas dengan status success
        return Redirect::route('orangtua.index')->with('success', 'orangtua ' . $validatedData['name'] . ' berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(orangtua $orangtua)
    {
        $type_menu = 'orangtua';

        // arahkan ke file pages/orangtuas/edit
        return view('pages.orangtuas.edit', compact('orangtua', 'type_menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, orangtua $orangtua)
    {
        // Validate the form data
        $request->validate([
            'user_id' => 'required',
            'santri_id' => 'required|unique:orangtuas',
            'alamat' => 'required',
            'no_telepon' => 'required',
        ]);

        // Update the orangtua data
        $orangtua->update([
            'user_id' => $request->user_id,
            'santri_id' => $request->santri_id,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
        ]);

        return Redirect::route('orangtua.index')->with('success', 'orangtua ' . $orangtua->name . ' berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(orangtua $orangtua)
    {
        $orangtua->delete();
        return Redirect::route('orangtua.index')->with('success', 'orangtua '. $orangtua->name . ' berhasil di hapus.');
    }
    public function show($id)
    {
        $type_menu = 'orangtua';
        $orangtua = orangtua::find($id);

        // arahkan ke file pages/orangtuas/edit
        return view('pages.orangtuas.show', compact('orangtua', 'type_menu'));
    }
}
