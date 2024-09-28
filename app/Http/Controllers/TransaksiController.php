<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index()
    {
        // Dapatkan waktu sekarang menggunakan Carbon untuk konsistensi
        $now = Carbon::now();

        // Ambil data reservasi yang belum selesai
        $reservasiData = DB::table('reservasi')
            ->join('users', 'reservasi.id_user', '=', 'users.id')
            ->join('meja', 'reservasi.id_meja', '=', 'meja.id_meja')
            ->select('reservasi.*', 'users.name', 'meja.no_meja')
            ->orderBy('id_reservasi', 'DESC')
            ->get();

        // Array untuk menyimpan ID reservasi yang harus diupdate
        $reservasiToUpdate = [];

        // Iterasi setiap reservasi untuk memeriksa apakah sudah lebih dari 3 jam
        foreach ($reservasiData as $reservasi) {
            // Cek apakah waktu reservasi sudah lebih dari 3 jam
            $waktuMulai = Carbon::parse($reservasi->tanggal);
            $waktuSelesai = $waktuMulai->addHours(3);

            if ($now->greaterThan($waktuSelesai) && $reservasi->status != 'Selesai') {
                // Tambahkan ID reservasi ke array untuk diupdate
                $reservasiToUpdate[] = $reservasi->id_reservasi;
            }
        }

        // Update status menjadi 'Selesai' untuk semua reservasi yang sudah lebih dari 3 jam
        if (!empty($reservasiToUpdate)) {
            DB::table('reservasi')
                ->whereIn('id_reservasi', $reservasiToUpdate)
                ->update(['status' => 'Selesai']);
        }

        // Kirim data ke view
        return view('admin.transaksi.index', ['reservasi' => $reservasiData]);
    }

    public function updatereservasi(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:Belum Selesai,Selesai'
        ]);

        // Ambil status baru dari request
        $statusBaru = $request->status;

        // Update status reservasi
        DB::table('reservasi')
            ->where('id_reservasi', $id)
            ->update(['status' => $statusBaru]);

        // Jika status reservasi menjadi "Selesai", perbarui status meja menjadi "tersedia"
        if ($statusBaru == 'Selesai') {
            $idMeja = DB::table('reservasi')
                ->where('id_reservasi', $id)
                ->value('id_meja'); // Ambil ID meja dari reservasi

            DB::table('meja')
                ->where('id_meja', $idMeja)
                ->update(['status' => 'tersedia']); // Perbarui status meja menjadi "tersedia"
        }

        // Redirect kembali dengan pesan sukses
        return redirect()->route('transaksi')->with('success', 'Status berhasil diperbarui');
    }

    public function detailpesanan($id_reservasi)
{
    $userId = Auth::id(); // Mendapatkan ID pengguna yang terautentikasi

    // Query untuk mengambil data reservasi beserta detailnya dan rating dari pengguna terkait
    $datareservasi = DB::table('detail')
        ->join('reservasi', 'detail.id_reservasi', '=', 'reservasi.id_reservasi')
        ->join('menu', 'detail.id_menu', '=', 'menu.id_menu')
        ->join('users', 'reservasi.id_user', '=', 'users.id')
        ->leftJoin('rating', function($join) use ($userId) {
            $join->on('detail.id_menu', '=', 'rating.id_menu')
                 ->where('rating.id_user', '=', $userId); // Sesuaikan dengan ID user yang login
        })
        ->select(
            'detail.id_menu',
            'detail.jumlah',
            'detail.harga',
            'reservasi.id_reservasi',
            'reservasi.tanggal',
            'reservasi.status',
            'reservasi.id_meja',
            'menu.nama_menu',
            'users.id as user_id',
            'users.name as name',
            'rating.bintang',
            'rating.ulasan'
        )
        ->where('reservasi.id_user', $userId) // Sesuaikan dengan ID user yang login
        ->where('reservasi.id_reservasi', $id_reservasi) // Sesuaikan dengan ID reservasi yang dipilih
        ->limit(25) // Batas limit yang sesuai
        ->get();

    // Kirim data ke view
    return view('customer.reservasi.detail', [
        'datareservasi' => $datareservasi, // Data yang akan ditampilkan di view
        'id_reservasi' => $id_reservasi,   // ID reservasi yang ditampilkan
    ]);
}


    // function hapusreservasi($id_reservasi)
    // {    
    //     $query = DB::table('reservasi')
    //         ->where('id_reservasi', $id_reservasi)
    //         ->delete();

    //     if ($query) {
    //         return redirect('/reservasi')->with('success', 'Data pesanan berhasil dihapus.');
    //     } else {
    //         return redirect('/reservasi')->with('error', 'Data pesanan gagal dihapus.');
    //     }
    // }

    public function detail(Request $request)
    {
        $id = $request->id;
        $userId = Auth::id(); // Get the authenticated user's ID
        $detail = DB::table('detail')
            ->join('reservasi', 'detail.id_reservasi', '=', 'reservasi.id_reservasi')
            ->join('menu', 'detail.id_menu', '=', 'menu.id_menu')
            ->join('users', 'reservasi.id_user', '=', 'users.id')
            ->select('detail.*', 'reservasi.*', 'menu.*', 'users.id as id', 'users.name as name')
            ->where('users.id', $userId) // Filter by authenticated user's ID
            ->where('reservasi.id_reservasi', $id)
            ->first();

        dd($detail);

        return view('customer.reservasi.detail_modal', compact('detail'));
    }
}
