<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    public function index()
    {
        $data = array(
            'rating' => DB::table('rating')
                ->join('users', 'rating.id_user', '=', 'users.id')
                ->join('menu', 'rating.id_menu', '=', 'menu.id_menu')
                ->orderBy('id_rating', 'DESC')
                ->get(),
        );
        return view('admin.rating.index', $data);
    }
    public function review($id_reservasi)
    {
        // Fetch the menu data based on the provided reservation ID
        $datareservasi = DB::table('detail')
            ->join('menu', 'detail.id_menu', '=', 'menu.id_menu')
            ->where('detail.id_reservasi', $id_reservasi)
            ->select('menu.*', 'detail.id_reservasi')
            ->firstOrFail();

        return view('customer.reservasi.rating', compact('datareservasi', 'id_reservasi'));
    }


    public function submitrating(Request $request, $id_reservasi)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_menu' => 'required',
            'bintang' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string',
        ]);

        rating::create([
            'id_user' => $request->id_user,
            'id_menu' => $request->id_menu,
            'bintang' => $request->bintang,
            'ulasan' => $request->ulasan,
        ]);

        return redirect()->route('pesanan')->with('success', 'Rating berhasil ditambahkan');
    }

    //     public function review($id_menu)
    //     {
    //         $datareservasi = Menu::findOrFail($id_menu);
    //         return view('customer.reservasi.rating', compact('datareservasi'));
    //     }    

    //     public function submitrating(Request $request, $id_menu)
    // {
    //     try {
    //         $request->validate([
    //             'id_menu' => 'required|exists:menu,id_menu',
    //             'id_reservasi' => 'required|exists:reservasi,id_reservasi',
    //             'id_user' => 'required|exists:users,id',
    //             'bintang' => 'required|integer|between:1,5',
    //             'ulasan' => 'nullable|string'
    //         ]);

    //         $rating = new Rating();
    //         $rating->id_menu = $request->id_menu;
    //         $rating->id_reservasi = $request->id_reservasi;
    //         $rating->id_user = $request->id_user;
    //         $rating->bintang = $request->bintang;
    //         $rating->ulasan = $request->ulasan;
    //         $rating->save();

    //         return redirect()->back()->with('success', 'Terima kasih atas ulasannya!');
    //     } catch (\Exception $e) {
    //         Log::error('Error saving rating: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan rating.');
    //     }
    // }

}
