<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kalender;
use App\Models\MataPelajaran;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
     public function index(Request $request)
    {
        $type_menu = 'dashboard';

        // Statistik
        $jumlah_user = User::count();
        $jumlah_guru = Guru::count();
        $jumlah_santri = Santri::count();
        $jumlah_mapel = MataPelajaran::count();

        $daftar_hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

       $kalender = Kalender::select('id', 'kegiatan', 'tanggal_awal', 'tanggal_akhir', 'keterangan')->get();

        $user = Auth::user();
        $role = strtolower($user->role);
        $filterHari = $request->input('hari');

        $jadwalQuery = Jadwal::with(['mapel', 'kelas', 'guru.user']);

        if ($role === 'guru') {
            $guru_id = optional($user->guru)->id;
            $jadwalQuery->where('guru_id', $guru_id ?: 0);
        } elseif ($role === 'orang tua') { 
            $kelas_id = optional($user->orangtua->santri)->kelas_id;
            $jadwalQuery->where('kelas_id', $kelas_id ?: 0);
        }
        if ($filterHari) {
            $jadwalQuery->where('hari', $filterHari);
        }

        // Urutan hari manual
        $jadwalQuery->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jam_mulai');

        // Paginate
        $jadwal = $jadwalQuery->paginate(5);

        return view('pages.dashboard.index', compact(
            'type_menu',
            'jumlah_user',
            'jumlah_guru',
            'jumlah_santri',
            'jumlah_mapel',
            'jadwal',
            'daftar_hari',
            'filterHari',
            'kalender',
        ));
    }
}
