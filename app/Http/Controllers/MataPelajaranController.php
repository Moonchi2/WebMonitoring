<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'kelola';
        $keyword = trim($request->input('nama'));

        $matapelajaran = MataPelajaran::with('guru.user')
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('nama', 'like', '%' . $keyword . '%')
                        ->orWhereHas('guru.user', function ($sub) use ($keyword) {
                            $sub->where('name', 'like', '%' . $keyword . '%');
                        });
                });
            })
            ->latest()
            ->paginate(10);

        $matapelajaran->appends(['nama' => $keyword]);

        return view('pages.mapel.index', compact('type_menu', 'matapelajaran'));
    }

    public function create()
    {
        $type_menu = 'kelola';
        $gurus = Guru::with('user')->get();

        return view('pages.mapel.create', compact('type_menu', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:mata_pelajarans,kode',
        ]);

        $matapelajaran = MataPelajaran::create([
            'guru_id' => $request->guru_id,
            'nama' => $request->nama,
            'kode' => $request->kode,
        ]);

        return Redirect::route('matapelajaran.index')
            ->with('success', 'Mata Pelajaran ' . $matapelajaran->nama . ' berhasil ditambahkan.');
    }

    public function edit(MataPelajaran $matapelajaran)
    {
        $type_menu = 'kelola';
        $gurus = Guru::with('user')->get();

        return view('pages.mapel.edit', compact('type_menu', 'matapelajaran', 'gurus'));
    }

    public function update(Request $request, MataPelajaran $matapelajaran)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:mata_pelajarans,kode,' . $matapelajaran->id,
        ]);

        $matapelajaran->update([
            'guru_id' => $request->guru_id,
            'nama' => $request->nama,
            'kode' => $request->kode,
        ]);

        return Redirect::route('matapelajaran.index')
            ->with('success', 'Mata Pelajaran ' . $matapelajaran->nama . ' berhasil diubah.');
    }

    public function destroy(MataPelajaran $matapelajaran)
    {
        $matapelajaran->delete();

        return Redirect::route('matapelajaran.index')
            ->with('success', 'Mata Pelajaran ' . $matapelajaran->nama . ' berhasil dihapus.');
    }
}
