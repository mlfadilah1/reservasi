<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = date('Y-m-d');
        $transaksiCount = Transaksi::count();
        $reservationCount = Reservasi::count();
        $reservationharianCount = Transaksi::whereDate('tanggal', $today)->count();
        $menuCount = Menu::count();
        $pembeliCount = Transaksi::count();

        $mostPopularMenus = DB::table('detail')
            ->join('menu', 'detail.id_menu', '=', 'menu.id_menu')
            ->select('menu.kategori', 'menu.nama_menu', 'menu.id_menu', DB::raw('COUNT(detail.id_menu) as jumlah'))
            ->groupBy('menu.kategori', 'menu.id_menu', 'menu.nama_menu')
            ->orderBy('jumlah', 'desc')
            ->get()
            ->groupBy('kategori') // Mengelompokkan hasil per kategori
            ->map(function ($items) {
                // Mengambil menu dengan jumlah pesanan terbanyak untuk setiap kategori
                return $items->sortByDesc('jumlah')->first();
            });

        return view('admin.index', compact('menuCount', 'reservationCount', 'reservationharianCount', 'transaksiCount', 'pembeliCount', 'mostPopularMenus'));
    }

    public function detailmenu($id_menu)
    {
        $mostPopularMenus = DB::table('detail')
            ->join('menu', 'detail.id_menu', '=', 'menu.id_menu') // Gabungkan dengan tabel menu
            ->join('reservasi', 'detail.id_reservasi', '=', 'reservasi.id_reservasi') // Gabungkan dengan tabel reservasi
            ->join('users', 'reservasi.id_user', '=', 'users.id') // Gabungkan dengan tabel pengguna
            ->select(
                'menu.kategori',
                'menu.nama_menu',
                DB::raw('COUNT(detail.id_menu) as jumlah'), // Hitung jumlah pesanan per menu
                DB::raw('GROUP_CONCAT(users.name) as pemesan'), // Gabungkan nama pemesan
                'reservasi.tanggal as tanggal_pesanan', // Tanggal pesanan dari tabel reservasi
                DB::raw('SUM(detail.jumlah) as jumlah_dipesan') // Jumlah total dipesan per item
            )
            ->where('menu.id_menu', $id_menu) // Filter berdasarkan id_menu yang spesifik
            ->groupBy('menu.kategori', 'menu.id_menu', 'menu.nama_menu', 'reservasi.tanggal') // Kelompokkan berdasarkan kolom yang relevan
            ->orderBy('jumlah', 'desc') // Urutkan berdasarkan jumlah pesanan
            ->get();

        return view('admin.detail', compact('mostPopularMenus'));
    }


    public function dashboard()
    {
        $data = array(
            'makananutama' => DB::table('menu')
                ->where('kategori', 'Makanan Utama')
                ->get(),
            'makananpembuka' => DB::table('menu')
                ->where('kategori', 'Makanan Pembuka')
                ->get(),
            'makananpenutup' => DB::table('menu')
                ->where('kategori', 'Makanan Penutup')
                ->get(),
            'minuman' => DB::table('menu')
                ->where('kategori', 'Minuman')
                ->get(),
            'cemilan' => DB::table('menu')
                ->where('kategori', 'Cemilan')
                ->get(),
        );
        return view('customer.index', $data);
    }
}
