<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReservasiController extends Controller
{
    public function reservasi()
    {
        $data = array(
            'dtl'    => DB::table('keranjang')->get(),
            'keranjang' => DB::table('keranjang')
                ->join('menu', 'keranjang.id_menu', '=', 'menu.id_menu')
                ->get(),

            'total' => DB::table('keranjang')
                ->where('jumlah', 'total_harga')
                ->sum(DB::raw('total_harga * jumlah'))
        );
        $reservasi = DB::table('reservasi')
            ->join('meja', 'reservasi.id_meja', '=', 'meja.id_meja')
            ->select('reservasi.*', 'meja.no_meja')
            ->where('reservasi.id_user', Auth::user()->id)
            ->orderBy('id_reservasi', 'DESC')
            ->get();

        $mejas = DB::table('meja')->get(); // Ambil data meja untuk select option

        return view('customer.reservasi.index', $data, compact('reservasi', 'mejas'));
    }

    // Menyimpan data reservasi
    public function submitreservasi(Request $req)
    {
        // Ambil tanggal dan waktu dari input dan konversi ke zona waktu Jakarta
        $tanggalLocal = Carbon::parse($req->tanggal)->setTimezone('Asia/Jakarta');
        $now = Carbon::now('Asia/Jakarta');

        // Jam buka dan tutup coffee shop
        $jamBuka = Carbon::createFromTime(7, 30, 0, 'Asia/Jakarta');
        $jamBukaSelesaiPersiapan = $jamBuka->copy()->addMinutes(15); // Jam 7:45 untuk mulai reservasi
        $jamTutup = Carbon::createFromTime(22, 0, 0, 'Asia/Jakarta');
        $jamTerakhirPenerimaanReservasi = Carbon::createFromTime(21, 0, 0, 'Asia/Jakarta'); // Jam terakhir untuk menerima reservasi

        // Cek apakah waktu reservasi berada sebelum jam buka
        if ($tanggalLocal->lt($jamBuka)) {
            return back()->withErrors(['message' => 'Coffee shop hanya buka dari jam 7:30 pagi hingga jam 22:00 malam.']);
        }

        // Cek apakah waktu reservasi antara jam buka dan jam 7:45 (persiapan)
        if ($tanggalLocal->lt($jamBukaSelesaiPersiapan)) {
            return back()->withErrors(['message' => 'Harap tunggu, coffee shop masih mempersiapkan alat-alat. Silakan pesan setelah jam 7:45.']);
        }

        // Cek apakah waktu reservasi kurang dari 15 menit dari sekarang
        if ($tanggalLocal->lt($now->copy()->addMinutes(15))) {
            return back()->withErrors(['message' => 'Waktu reservasi harus minimal 15 menit dari sekarang.']);
        }

        // Cek apakah waktu reservasi lebih dari jam terakhir penerimaan reservasi
        if ($tanggalLocal->gt($jamTerakhirPenerimaanReservasi)) {
            return back()->withErrors(['message' => 'Reservasi tidak dapat dilakukan setelah jam 21:00. Coffee shop akan segera tutup.']);
        }

        // Hitung waktu akhir reservasi
        $tanggalAkhir = $tanggalLocal->copy()->addHours(3);

        // Cek jika waktu akhir reservasi melebihi jam tutup
        if ($tanggalAkhir->gt($jamTutup)) {
            // Hitung durasi yang tersisa sebelum jam tutup
            $jamSisa = $jamTutup->diffInHours($tanggalLocal); // Durasi yang diperbolehkan sebelum jam tutup
            $tanggalAkhir = $tanggalLocal->copy()->addHours($jamSisa); // Set waktu akhir sesuai jam tutup
        }

        // Cek apakah waktu akhir reservasi melebihi jam tutup
        if ($tanggalAkhir->gt($jamTutup)) {
            return back()->withErrors(['message' => 'Waktu reservasi tidak dapat melebihi jam tutup coffee shop.']);
        }

        // Periksa apakah meja sudah dipesan pada waktu yang sama
        $mejaTerpesan = DB::table('reservasi')
            ->where('id_meja', $req->id_meja)
            ->where(function ($query) use ($tanggalLocal, $tanggalAkhir) {
                $query->whereBetween('tanggal', [$tanggalLocal, $tanggalAkhir])
                    ->orWhere(function ($query) use ($tanggalLocal, $tanggalAkhir) {
                        $query->where('tanggal', '<=', $tanggalLocal)
                            ->whereRaw('DATE_ADD(tanggal, INTERVAL 3 HOUR) >= ?', [$tanggalLocal]);
                    });
            })
            ->where('status', 'belum selesai')
            ->exists();

        if ($mejaTerpesan) {
            return back()->withErrors(['message' => 'Meja ini sudah dipesan pada waktu yang sama.']);
        }

        // Ambil id_reservasi terakhir dan increment
        $id_reservasi = DB::table('reservasi')->max('id_reservasi') + 1;

        // Insert data reservasi
        $insertPenjualan = DB::table('reservasi')->insert([
            'id_reservasi' => $id_reservasi,
            'id_meja' => $req->id_meja,
            'id_user' => Auth::user()->id,
            'no_hp' => $req->no_hp,
            'tanggal' => $tanggalLocal,
            'jumlah_tamu' => $req->jumlah_tamu,
            'total_harga' => $req->total_harga,
            'status' => 'belum selesai', // Set status awal sebagai belum selesai
        ]);

        if ($insertPenjualan) {
            $getKeranjang = DB::table('keranjang')->get(); // Mengambil item dari keranjang

            foreach ($getKeranjang as $row) {
                // Insert ke detail
                DB::table('detail')->insert([
                    'id_reservasi' => $id_reservasi,
                    'id_menu' => $row->id_menu,
                    'jumlah' => $row->jumlah,
                    'harga' => $row->total_harga,
                ]);

                // Kurangi stok menu
                DB::table('menu')
                    ->where('id_menu', $row->id_menu)
                    ->decrement('stok', $row->jumlah);
            }

            // Kosongkan keranjang setelah checkout
            DB::table('keranjang')->delete();

            // Mengubah status meja menjadi tidak tersedia
            DB::table('meja')->where('id_meja', $req->id_meja)->update(['status' => 'tidak tersedia']);

            // Pengecekan apakah waktu reservasi telah selesai
            $tanggalAkhir = $tanggalLocal->copy()->addHours(3);
            if (Carbon::now('Asia/Jakarta')->gte($tanggalAkhir)) {
                // Jika waktu sudah habis, ubah status reservasi menjadi selesai
                DB::table('reservasi')->where('id_reservasi', $id_reservasi)->update(['status' => 'selesai']);

                // Ubah status meja menjadi tersedia
                DB::table('meja')->where('id_meja', $req->id_meja)->update(['status' => 'tersedia']);
            }

            return redirect('/dashboard')->with('success', 'Pesanan berhasil dibuat.');
        } else {
            return back()->withErrors(['message' => 'Gagal melakukan reservasi.']);
        }
    }



    public function laporanharian(Request $request)
    {
        if ($request->ajax()) {
            // Ambil tanggal dari request, default ke tanggal hari ini jika tidak ada
            $tanggal = $request->get('tanggal', date('Y-m-d'));

            // Query untuk DataTables
            $users = User::query();

            return DataTables::of($users)
                ->make();
        }

        // Ambil tanggal dari request, default ke tanggal hari ini jika tidak ada
        $tanggal = request()->input('tanggal', date('Y-m-d'));

        // Query untuk data reservasi berdasarkan tanggal
        $data = array(
            'datareservasi' => DB::table('detail')
                ->join('reservasi', 'detail.id_reservasi', '=', 'reservasi.id_reservasi')
                ->join('menu', 'detail.id_menu', '=', 'menu.id_menu')
                ->join('users', 'reservasi.id_user', '=', 'users.id')
                ->whereDate('reservasi.tanggal', $tanggal) // Filter berdasarkan tanggal
                ->select('detail.*', 'reservasi.*', 'menu.*', 'users.id as id', 'users.name as name')
                ->get()
        );

        return view('admin.reservasi.harian', $data); // Ganti dengan nama view form reservasi Anda
    }

    public function laporan()
    {
        if (request()->ajax()) {
            $users = User::query();
            return DataTables::of($users)

                ->make();
        }
        // $data = array(
        //     'reservasi' => DB::table('reservasi')
        //         ->join('users', 'reservasi.id_user', '=', 'users.id')
        //         ->join('meja', 'reservasi.id_meja', '=', 'meja.id_meja')
        //         ->join('detail', 'reservasi.id_detail')
        //         ->get(),
        // );
        $data = array(
            'datareservasi' => DB::table('detail')
                ->join('reservasi', 'detail.id_reservasi', '=', 'reservasi.id_reservasi')
                ->join('menu', 'detail.id_menu', '=', 'menu.id_menu')
                ->join('users', 'reservasi.id_user', '=', 'users.id')
                ->select('detail.*', 'reservasi.*', 'menu.*', 'users.id as id', 'users.name as name')
                ->get()
        );
        return view('admin.reservasi.index', $data); // Ganti dengan nama view form reservasi Anda
    }

    //keranjang
    public function tambah(Request $req)
    {
        $query = DB::table('keranjang')
            ->insert([
                'id_menu'     => $req->id_menu,
                'jumlah'        => $req->jumlah,
                'total_harga'   => $req->total_harga,
            ]);

        if ($query) {
            return redirect()->back()->with('success', 'Menu berhasil dimasukkan.');
        } else {
            return redirect()->back()->with('danger', 'Menu gagal dimasukkan.');
        }
    }

    public function tambahorder(Request $req, $datadetail)
    {
        $query = DB::table('keranjang')
            ->where('id_keranjang', $datadetail)
            ->update([
                'jumlah' => $req->jumlah,
            ]);


        if ($query) {
            return redirect('/reservasi')->with('success', 'Jumlah pesanan berhasil ditambahkan.');
        } else {
            return redirect('/reservasi')->with('error', 'Jumlah pesanan gagal ditambahkan.');
        }
    }

    public function hapusorder($data)
    {
        $query = DB::table('keranjang')
            ->where('id_keranjang', $data)
            ->delete();

        if ($query) {
            return redirect('/reservasi')->with('success', 'Data pesanan berhasil dihapus.');
        } else {
            return redirect('/reservasi')->with('error', 'Data pesanan gagal dihapus.');
        }
    }
    function hapusreservasi($id_reservasi)
    {
        $query = DB::table('reservasi')
            ->where('id_reservasi', $id_reservasi)
            ->delete();
        $query = DB::table('reservasi')
            ->where('id_reservasi', $id_reservasi)
            ->delete();

        if ($query) {
            return redirect('/transaksi')->with('success', 'Data pesanan berhasil dihapus.');
        } else {
            return redirect('/transaksi')->with('error', 'Data pesanan gagal dihapus.');
        }
    }
}
