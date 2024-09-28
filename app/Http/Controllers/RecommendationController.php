<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CollaborativeFilteringService;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    protected $collaborativeFiltering;

    public function __construct(CollaborativeFilteringService $collaborativeFiltering)
    {
        $this->collaborativeFiltering = $collaborativeFiltering;
    }

    /**
     * Menampilkan rekomendasi menu untuk pengguna saat ini
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Pastikan pengguna sudah login
        $user = Auth::user();

        // Periksa apakah pengguna memiliki role 'Customer'
        if ($user->role !== 'Customer') {
            return redirect()->back()->with('error', 'Hanya pelanggan yang dapat melihat rekomendasi.');
        }

        // Dapatkan rekomendasi menu
        $recommendations = $this->collaborativeFiltering->recommendMenus($user);

        return view('recommendations.index', compact('recommendations'));
    }
}
