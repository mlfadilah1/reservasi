<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KasirController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $users = User::query();
            return DataTables::of($users)->make();
        }
        $users = User::where('role', 'Kasir')
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.kasir.index', compact('users'));
    }
    function deleteuser($id)
    {
        $query = DB::table('users')
            ->where('id', $id)
            ->delete();

        if ($query) {
            return redirect('/kasir')->with('Success', 'Data kasir berhasil dihapus');
        } else {
            return redirect('/kasir')->with('Error', 'Data kasir gagal dihapus');
        }
    }
    public function tambah()
    {
        $data = array(
            'users' => DB::table('users')
                ->get(),
        );
        return view('admin.kasir.tambah', $data);
    }
    public function submitkasir(Request $request)
    {
        $name            = $request->name;
        $email            = $request->email;
        $password         = $request->password;

        // if ($request->hasFile('foto')) {
        //     $foto       = $name . "." . $request->file('foto')->getClientOriginalExtension();
        // } else {
        //     $foto       = null;
        // }

        try {
            $data = [
                'name'           => $name,
                'email'          => $email,
                'role'          => 'Kasir',
                // 'foto'           => $foto,
                'password'       => bcrypt($password),
            ];
            $simpan     = DB::table('users')->insert($data);
            if ($simpan) {
                // if ($request->hasFile('foto')) {
                //     $folderPath = "public/users";
                //     $request->file('foto')->storeAs($folderPath, $foto);
                // }
                return redirect('/kasir')->with('Success', 'Data User berhasil disimpan.');
            }
        } catch (\Exception $e) {
            return redirect('/tambahkasir')->with('danger', 'Data User gagal disimpan.');
        }
    }
}
