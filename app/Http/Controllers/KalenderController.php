<?php

namespace App\Http\Controllers;

use App\Models\Kalender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class KalenderController extends Controller
{
    public function index(Request $request)
    {
        $type_menu = 'kalender';

        // Ambil keyword pencarian dari input nama (digunakan untuk pencarian keterangan kalender)
        $keyword = trim($request->input('nama'));

        // Ambil data kalender berdasarkan pencarian jika ada
        $kalender = Kalender::when($keyword, function ($query, $nama) {
            $query->where('keterangan', 'like', '%' . $nama . '%');
        })
            ->orderByDesc('tanggal_awal')
            ->paginate(10);

        // Menambahkan query string agar tetap tersimpan saat pindah halaman
        $kalender->appends(['nama' => $keyword]);

        // Kirim ke view
        return view('pages.kalender.index', compact('type_menu', 'kalender'));
    }


    public function create()
    {
        $type_menu = 'kalender';

        return view('pages.kalender.create', compact('type_menu'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'kegiatan' => 'required',
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',
            'keterangan' => 'required',
        ]);
        kalender::create([
            'kegiatan' => $request->input('kegiatan'),
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'keterangan' => $request->keterangan,
        ]);

        return Redirect::route('kalender.index')->with('success', 'kalender  berhasil di tambah.');
    }

    public function edit(kalender $kalender)
    {
        $type_menu = 'kalender';

        return view('pages.kalender.edit', compact('kalender', 'type_menu'));

    }
    public function update(Request $request, kalender $kalender)
    {
        $request->validate([
            'kegiatan' => 'required',
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',
            'keterangan' => 'required',
        ]);

        $kalender->update([
            'kegiatan' => $request->kegiatan,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'keterangan' => $request->keterangan,
        ]);

        return Redirect::route('kalender.index')->with('success', 'kalender berhasil di ubah.');
    }
    public function destroy(kalender $kalender)
    {
        $kalender->delete();
        return Redirect::route('kalender.index')->with('success', 'kalender berhasil di hapus.');
    }
    public function show(Kalender $kalender)
    {
        $type_menu = 'kalender';
        return view('pages.kalender.show', compact('kalender', 'type_menu'));
    }

}
