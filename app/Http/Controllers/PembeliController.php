<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembeliController extends Controller
{
    public function index()
    {
        $data = array(
            'pembeli' => DB::table('reservasi')
                ->join('users', 'reservasi.id_user', '=', 'users.id')
                ->join('meja', 'reservasi.id_meja', '=', 'meja.id_meja')
                ->orderBy('id_reservasi', 'DESC')
                ->get(),
        );
        return view('admin.pembeli.index', $data);
    }
    public function meja()
    {
        $meja = array(
            'meja' => DB::table('meja')
                ->orderBy('id_meja', 'DESC')
                ->get(),
        );
        return view('admin.meja.index', $meja);
    }
    public function updateMejaStatus(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:tersedia,tidak tersedia',
        ]);

        // Update status meja berdasarkan pilihan dari dropdown
        DB::table('meja')
            ->where('id_meja', $id)
            ->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status meja berhasil diperbarui.');
    }
    public function tambah()
    {
        $meja = array(
            'meja' => DB::table('meja')
                ->get(),
        );
        return view('admin.meja.tambah', $meja);
    }
    public function editmeja($id_meja)
    {
        // dd('sd');
        $edit = array(
            'meja' => DB::table('meja')->where('id_meja', $id_meja)->get()
        );
        return view('admin.meja.edit', $edit);
    }
    public function submitmeja(Request $request)
    {
        $no_meja            = $request->no_meja;
        $kapasitas            = $request->kapasitas;
        // $password         = $request->password;

        // if ($request->hasFile('foto')) {
        //     $foto       = $no_meja . "." . $request->file('foto')->getClientOriginalExtension();
        // } else {
        //     $foto       = null;
        // }

        try {
            $data = [
                'no_meja'           => $no_meja,
                'kapasitas'          => $kapasitas,
                // 'role'          => 'Kasir',
                // 'foto'           => $foto,
                // 'password'       => bcrypt($password),
            ];
            $simpan     = DB::table('meja')->insert($data);
            if ($simpan) {
                // if ($request->hasFile('foto')) {
                //     $folderPath = "public/users";
                //     $request->file('foto')->storeAs($folderPath, $foto);
                // }
                return redirect('/meja')->with('Success', 'Data User berhasil disimpan.');
            }
        } catch (\Exception $e) {
            return redirect('/tambahmeja')->with('danger', 'Data User gagal disimpan.');
        }
    }
    public function deletemeja($id_meja)
    {
        DB::table('meja')->where('id_meja', $id_meja)->delete();
        return redirect('/meja')->with('success', 'Data Meja berhasil dihapus.');
    }
    public function updatemeja(Request $request, $id)
    {

        DB::table('meja')->where('id_meja', $id)->update([
            'no_meja' => $request->no_meja,
            'kapasitas' => $request->kapasitas,
        ]);

        return redirect()->route('meja')->with('success', 'Data Berhasil di Edit');
    }
}
