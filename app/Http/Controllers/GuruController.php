<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Hash;
use Illuminate\Http\Request;
use PhpParser\Builder\Use_;
use Redirect;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type_menu = 'kelola';

        // ambil data dari tabel guru berdasarkan nama jika terdapat request
        $keyword = trim($request->input('name'));
        $role = $request->input('role');

        // Query gurus dengan filter pencarian dan role
        $gurus = guru::when($keyword, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10);

        // Tambahkan parameter query ke pagination
        $gurus->appends(['name' => $keyword, 'role' => $role]);

        // arahkan ke file pages/gurus/index.blade.php
        return view('pages.gurus.index', compact('type_menu', 'gurus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_menu = 'guru';

        // arahkan ke file pages/gurus/create.blade.php
        return view('pages.gurus.create', compact('type_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data dari form tambah guru
        $validatedData = $request->validate([
            'user_id' => 'required',
            'no_telepon' => 'required',
        ]);
        // Handle the image upload if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move('img/guru/', $imagePath);
        }
        //masukan data kedalam tabel gurus
        Guru::create([
            'user_id' => $validatedData['guru'],
            'no_telepon'=> $validatedData['no_telepon'],

        ]);

        //jika proses berhsil arahkan kembali ke halaman gurus dengan status success
        return Redirect::route('guru.index')->with('success', 'guru ' . $validatedData['name'] . ' berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Guru $guru)
    {
        $type_menu = 'guru';

        // arahkan ke file pages/gurus/edit
        return view('pages.gurus.edit', compact('guru', 'type_menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, Guru $guru)
    {
        // Validate the form data
        $request->validate([
            'user_id' => 'required',
            'no_telepon' => 'required',
        ]);

        // Update the guru data
        $guru->update([
            'user_id' => $request->name,
            'no_telepon'=> $request->no_telepon,
        ]);

        return Redirect::route('guru.index')->with('success', 'Guru' . $guru->name . ' berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(guru $guru)
    {
        $guru->delete();
        return Redirect::route('guru.index')->with('success', 'Guru'. $guru->name . ' berhasil di hapus.');
    }
    public function show($id)
    {
        $type_menu = 'guru';
        $guru = guru::find($id);

        // arahkan ke file pages/gurus/edit
        return view('pages.gurus.show', compact('guru', 'type_menu'));
    }
}