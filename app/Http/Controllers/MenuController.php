<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $users = User::query();
            return DataTables::of($users)->make();
        }

        // Query untuk mendapatkan menu terlaris berdasarkan jumlah pesanan
        $menu = DB::table('menu')
    ->leftJoin('detail', 'menu.id_menu', '=', 'detail.id_menu')
    ->select(
        'menu.id_menu',
        'menu.nama_menu',
        'menu.harga',
        'menu.kategori',
        'menu.stok',
        'menu.foto',
        DB::raw('MAX(menu.deskripsi) as deskripsi'), // Agregasi deskripsi
        DB::raw('COUNT(detail.id_menu) as total_orders') // Menghitung jumlah pesanan
    )
    ->groupBy('menu.id_menu', 'menu.nama_menu', 'menu.harga', 'menu.kategori', 'menu.stok', 'menu.foto') // Kolom-kolom yang digunakan di SELECT
    ->orderBy('total_orders', 'DESC')
    ->get();

        $data = array(
            'menu' => $menu,
        );

        return view('admin.menu.index', $data);
    }

    public function dashboard()
    {
        return view('customer.index');
    }
    public function tambah()
    {
        $data = array(
            'aksi' => url('submit')
        );
        return view('admin.menu.tambah', $data);
    }
    public function editmenu($id_menu)
    {
        $data = array(
            'judul' => 'Tambah Data Admin',
            'aksi' => url('submit'),
            'menu' => DB::table('menu')->where('id_menu', $id_menu)->get()
        );
        return view('admin.menu.edit', $data);
    }
    public function submit(Request $request)
    {
        $nama_menu = $request->nama_menu;
        $deskripsi = $request->deskripsi;
        $harga = $request->harga;
        $kategori = $request->kategori;
        $stok = $request->stok;

        if ($request->hasFile('foto')) {
            $foto = $nama_menu . '.' . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }

        try {
            $data = [
                'nama_menu' => $nama_menu,
                'deskripsi' => $deskripsi,
                'harga' => $harga,
                'kategori' => $kategori,
                'stok' => $stok,
                'foto' => $foto,
            ];
            $simpan = DB::table('menu')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/menu/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return redirect('/menu')->with('success', 'Data menu berhasil disimpan.');
            }
        } catch (\Exception $e) {
            return redirect('/tambahmenu')->with('danger', 'Data menu gagal disimpan.');
        }
    }

    public function deleteMenu($id_menu)
    {
        DB::table('menu')->where('id_menu', $id_menu)->delete();
        return redirect('/menu')->with('success', 'Data menu berhasil dihapus.');
    }

    public function updatemenu(Request $request, $id)
    {
        $menu = DB::table('menu')->where('id_menu', $id)->first();
        if (!$menu) {
            // Handle jika data tidak ditemukan
            return redirect()->route('edit')->with('error', 'Data tidak ditemukan');
        }
        $foto = $request->file('foto');
        $nama_file = $menu->foto;
        if ($foto) {
            // Hapus foto awal
            if (File::exists(public_path('menu/' . $nama_file))) {
                File::delete(public_path('menu/' . $nama_file));
            }
            // Upload foto baru
            $nama_file = time() . "_" . $foto->getClientOriginalName();
            $tujuan_upload = 'storage/menu';
            $foto->move($tujuan_upload, $nama_file);
        }
        DB::table('menu')->where('id_menu', $id)->update([
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'Harga' => $request->harga,
            'foto' => $nama_file,
        ]);

        return redirect()->route('menu')->with('success', 'Data Berhasil di Edit');

        // $id_menu = $request->id_menu;
        // $nama_menu = $request->nama_menu;
        // $deskripsi = $request->deskripsi;
        // $harga = $request->harga;
        // $kategori = $request->kategori;
        // $old_foto = $request->old_foto;

        // if ($request->hasFile('foto')) {
        //     $foto = $id_menu . '.' . $request->file('foto')->getClientOriginalExtension();
        // } else {
        //     $foto = $old_foto;
        // }

        // try {
        //     $data = [
        //         'nama_menu' => $nama_menu,
        //         'deskripsi' => $deskripsi,
        //         'harga' => $harga,
        //         'kategori' => $kategori,
        //         'foto' => $foto,
        //     ];
        //     $simpan = DB::table('menu')->where('id_menu', $id_menu)->update($data);
        //     if ($simpan) {
        //         if ($request->hasFile('foto')) {
        //             $folderPath = "public/menu";
        //             $folderPathOld = "public/menu/" . $old_foto;
        //             Storage::delete($folderPathOld);
        //             $request->file('foto')->storeAs($folderPath, $foto);
        //         }
        //         return redirect('/menu')->with('success', 'Data menu berhasil diperbarui.');
        //     }
        // } catch (\Exception $e) {
        //     return redirect('/edit')->with('danger', 'Data menu gagal diperbarui.');
        // }
    }
    //pelanggan
    public function pesanan()
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
        $reservasi = DB::table('reservasi')
            ->join('meja', 'reservasi.id_meja', '=', 'meja.id_meja')
            ->join('users', 'reservasi.id_user', '=', 'users.id')
            ->select('reservasi.*', 'meja.no_meja', 'users.name')
            ->where('reservasi.id_user', auth()->id()) // Pastikan hanya mengambil data user yang sedang login
            ->orderBy('id_reservasi', 'DESC')
            ->get();

        return view('customer.reservasi.laporan', compact('reservasi'));
    }
}
