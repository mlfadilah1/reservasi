<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LandingController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $users = User::query();
            return DataTables::of($users)

                ->make();
        }
        $data = array(
            'makananutama' => DB::table('menu')
                ->where('kategori', 'Makan Berat')
                ->get(),
            'makananpembuka' => DB::table('menu')
                ->where('kategori', 'Manual Brew')
                ->get(),
            'makananpenutup' => DB::table('menu')
                ->where('kategori', 'Desert')
                ->get(),
            'cemilan' => DB::table('menu')
                ->where('kategori', 'Cemilan')
                ->get(),
            'noncoffee' => DB::table('menu')
                ->where('kategori', 'Non Coffee')
                ->get(),
            'Coffee' => DB::table('menu')
                ->where('kategori', 'Coffee')
                ->get(),
            'ExtraToping' => DB::table('menu')
                ->where('kategori', 'Extra Toping')
                ->get(),
        );
        $rating = array(
            'rating' => DB::table('rating')
                ->join('users', 'rating.id_user', '=', 'users.id')
                ->join('menu', 'rating.id_menu', '=', 'menu.id_menu')
                ->get(),
        );
        // Ambil rating rata-rata per menu
        // $ratings = DB::table('menu')
        //     ->leftJoin('rating', 'menu.id_menu', '=', 'rating.id_menu')
        //     ->select('menu.id_menu', DB::raw('AVG(rating.bintang) as average_bintang'))
        //     ->groupBy('menu.id_menu')
        //     ->pluck('average_bintang', 'menu.id_menu')
        //     ->toArray();

        // $data['rating'] = $ratings;
        return view('welcome', $data, $rating);
    }
    
    public function dashboard()
    {
        // Ambil kategori menu
        $menuCategories = [
            'Makan Berat' => DB::table('menu')->where('kategori', 'Makan Berat')->get(),
            'Desert' => DB::table('menu')->where('kategori', 'Desert')->get(),
            'Cemilan' => DB::table('menu')->where('kategori', 'Cemilan')->get(),
            'Non Coffee' => DB::table('menu')->where('kategori', 'Non Coffee')->get(),
            'Coffee' => DB::table('menu')->where('kategori', 'Coffee')->get(),
        ];

        $userId = auth()->id();
        $userName = auth()->user()->name;

        // Ambil rating untuk pengguna dengan peran 'customer'
        $userRatings = DB::table('users')
            ->join('rating', 'rating.id_user', '=', 'users.id')
            ->join('menu', 'menu.id_menu', '=', 'rating.id_menu')
            ->where('users.role', 'customer')
            ->select('users.name as user_name', 'menu.nama_menu', 'rating.bintang', 'menu.kategori', 'rating.ulasan', 'menu.foto')
            ->get();

        // Organisasi rating per pengguna dan per kategori
        $ratingsByUser = [];
        $ratingsByCategory = [];
        foreach ($userRatings as $rating) {
            $user = $rating->user_name;
            $item = $rating->nama_menu;
            $category = $rating->kategori;

            $ratingsByUser[$user][$item] = $rating->bintang;
            $ratingsByCategory[$category][$user][$item] = $rating->bintang;
        }

        // Hitung rating rata-rata per pengguna
        $averageUserRatings = $this->calculateAverageRatings($ratingsByUser);

        // Hitung rating rata-rata per kategori
        $averageRatingsByCategory = $this->calculateAverageRatingsByCategory($ratingsByCategory);

        // Hitung kemiripan pengguna per kategori
        $userSimilaritiesByCategory = $this->calculateUserSimilarities($ratingsByCategory, $averageUserRatings);

        // Hasilkan rekomendasi per kategori
        $recommendationsByCategory = $this->generateRecommendations($ratingsByCategory, $userSimilaritiesByCategory, $averageUserRatings, $userName);

        // Gabungkan rekomendasi untuk pengguna baru
        if ($this->isNewUser($userName)) {
            foreach (array_keys($menuCategories) as $category) {
                $topItem = $this->getTopItemByCategory($category);
                if ($topItem) {
                    $recommendationsByCategory[$category][] = $topItem->nama_menu;
                }
            }
        }

        // Ambil menu terlaris secara keseluruhan
        $popularMenus = $this->getPopularMenus();

        // Pass data ke view
        return view('customer.index', compact('menuCategories', 'userRatings', 'ratingsByUser', 'averageUserRatings', 'userSimilaritiesByCategory', 'recommendationsByCategory', 'averageRatingsByCategory', 'popularMenus'));
    }

    // Fungsi untuk mendapatkan satu menu terlaris per kategori
    private function getTopItemByCategory($category)
    {
        return DB::table('detail')
            ->join('menu', 'detail.id_menu', '=', 'menu.id_menu')
            ->where('menu.kategori', $category)
            ->select('menu.nama_menu')
            ->groupBy('menu.nama_menu')
            ->orderByRaw('COUNT(detail.id_menu) DESC')
            ->take(1)
            ->first();
    }

    // Fungsi pembantu untuk mendapatkan menu terlaris
    private function getPopularMenus()
    {
        return DB::table('detail')
            ->join('menu', 'detail.id_menu', '=', 'menu.id_menu')
            ->select('menu.id_menu', 'menu.nama_menu', 'menu.harga', 'menu.foto', 'menu.deskripsi', 'menu.stok', DB::raw('COUNT(detail.id_menu) as order_count'))
            ->groupBy('menu.id_menu', 'menu.nama_menu', 'menu.harga', 'menu.foto', 'menu.deskripsi', 'menu.stok')
            ->orderBy('order_count', 'desc')
            ->take(5)
            ->get();
    }

    // Fungsi pembantu untuk menghitung rating rata-rata per pengguna
    private function calculateAverageRatings($ratingsByUser)
    {
        $averageUserRatings = [];
        foreach ($ratingsByUser as $user => $ratings) {
            $averageUserRatings[$user] = array_sum($ratings) / count($ratings);
        }
        return $averageUserRatings;
    }

    // Fungsi pembantu untuk menghitung rating rata-rata per kategori
    private function calculateAverageRatingsByCategory($ratingsByCategory)
    {
        $averageRatingsByCategory = [];
        foreach ($ratingsByCategory as $category => $categoryRatings) {
            $categoryTotal = [];
            foreach ($categoryRatings as $userRatings) {
                foreach ($userRatings as $rating) {
                    $categoryTotal[] = $rating;
                }
            }
            $averageRatingsByCategory[$category] = array_sum($categoryTotal) / count($categoryTotal);
        }
        return $averageRatingsByCategory;
    }

    // Fungsi pembantu untuk menghitung kemiripan pengguna per kategori
    private function calculateUserSimilarities($ratingsByCategory, $averageUserRatings)
    {
        $userSimilaritiesByCategory = [];
        foreach ($ratingsByCategory as $category => $categoryRatings) {
            $userSimilarities = [];
            $users = array_keys($categoryRatings);
            $userCount = count($users);

            for ($i = 0; $i < $userCount; $i++) {
                for ($j = $i + 1; $j < $userCount; $j++) {
                    $user1 = $users[$i];
                    $user2 = $users[$j];

                    $numerator = 0;
                    $denominator1 = 0;
                    $denominator2 = 0;

                    foreach ($categoryRatings[$user1] as $item => $rating1) {
                        if (isset($categoryRatings[$user2][$item])) {
                            $rating2 = $categoryRatings[$user2][$item];
                            $diff1 = $rating1 - $averageUserRatings[$user1];
                            $diff2 = $rating2 - $averageUserRatings[$user2];

                            $numerator += $diff1 * $diff2;
                            $denominator1 += $diff1 * $diff1;
                            $denominator2 += $diff2 * $diff2;
                        }
                    }

                    $similarity = ($denominator1 && $denominator2) ? $numerator / sqrt($denominator1 * $denominator2) : 0;
                    $userSimilarities["$user1-$user2"] = $similarity;
                }
            }

            $userSimilaritiesByCategory[$category] = $userSimilarities;
        }

        return $userSimilaritiesByCategory;
    }

    private function generateRecommendations($ratingsByCategory, $userSimilaritiesByCategory, $averageUserRatings, $userName)
    {
        $recommendationsByCategory = [];
        foreach ($ratingsByCategory as $category => $categoryRatings) {
            if ($this->isNewUser($userName)) {
                $orderCount = $this->getUserOrderCount($userName);

                // Jika pengguna baru dan belum memberikan rating atau belum memesan
                if ($orderCount === 0) {
                    $recommendationsByCategory[$category] = [$this->getTopItemByCategory($category)->nama_menu];
                } else {
                    // Jika pengguna baru sudah memberikan rating, gunakan kemiripan pengguna
                    $recommendationsByCategory[$category] = $this->getRecommendations($categoryRatings, $userSimilaritiesByCategory[$category], $averageUserRatings, $userName);
                }
            } else {
                // Untuk pengguna lama, gunakan kemiripan pengguna
                $recommendationsByCategory[$category] = $this->getRecommendations($categoryRatings, $userSimilaritiesByCategory[$category], $averageUserRatings, $userName);
            }
        }
        return $recommendationsByCategory;
    }

    // Fungsi pembantu untuk mendapatkan jumlah pesanan pengguna
    private function getUserOrderCount($userName)
    {
        return DB::table('rating')
            ->join('users', 'rating.id_user', '=', 'users.id')
            ->where('users.name', $userName)
            ->count();
    }

    // Fungsi pembantu untuk memeriksa apakah pengguna baru
    private function isNewUser($userName)
    {
        $orderCount = DB::table('rating')
            ->join('users', 'rating.id_user', '=', 'users.id')
            ->where('users.name', $userName)
            ->count();

        return $orderCount < 5;
    }

    // Fungsi pembantu untuk mendapatkan rekomendasi berdasarkan kemiripan pengguna
    private function getRecommendations($ratingsByUser, $userSimilarities, $averageUserRatings, $userName)
    {
        $recommendations = [];
        if (!isset($ratingsByUser[$userName])) {
            return $recommendations;
        }

        $userSimilarScores = [];
        foreach ($ratingsByUser as $otherUser => $ratings) {
            if ($userName !== $otherUser && isset($userSimilarities["$userName-$otherUser"])) {
                $userSimilarScores[$otherUser] = $userSimilarities["$userName-$otherUser"];
            }
        }

        arsort($userSimilarScores);
        $topUsers = array_keys(array_slice($userSimilarScores, 0, 5, true));

        foreach ($topUsers as $topUser) {
            foreach ($ratingsByUser[$topUser] as $item => $rating) {
                if (!isset($ratingsByUser[$userName][$item])) {
                    $recommendations[$item] = ($recommendations[$item] ?? 0) + $rating * $userSimilarScores[$topUser];
                }
            }
        }

        arsort($recommendations);
        return array_keys(array_slice($recommendations, 0, 3, true));
    }

    public function menu()
    {
        if (request()->ajax()) {
            $users = User::query();
            return DataTables::of($users)

                ->make();
        }
        $data = array(
            'makananutama' => DB::table('menu')
                ->where('kategori', 'Makan Berat')
                ->get(),
            'makananpembuka' => DB::table('menu')
                ->where('kategori', 'Manual Brew')
                ->get(),
            'makananpenutup' => DB::table('menu')
                ->where('kategori', 'Desert')
                ->get(),
            'cemilan' => DB::table('menu')
                ->where('kategori', 'Cemilan')
                ->get(),
            'noncoffee' => DB::table('menu')
                ->where('kategori', 'Non Coffee')
                ->get(),
            'Coffee' => DB::table('menu')
                ->where('kategori', 'Coffee')
                ->get(),
            'ExtraToping' => DB::table('menu')
                ->where('kategori', 'Extra Toping')
                ->get(),
        );
        // $rating = array(
        //     'rating' => DB::table('rating')
        //         ->join('users', 'rating.id_user', '=', 'users.id')
        //         ->join('menu', 'rating.id_menu', '=', 'menu.id_menu')
        //         ->get(),
        // );
        // Ambil rating rata-rata per menu
        // $ratings = DB::table('menu')
        //     ->leftJoin('rating', 'menu.id_menu', '=', 'rating.id_menu')
        //     ->select('menu.id_menu', DB::raw('AVG(rating.bintang) as average_bintang'))
        //     ->groupBy('menu.id_menu')
        //     ->pluck('average_bintang', 'menu.id_menu')
        //     ->toArray();

        // $data['rating'] = $ratings;
        return view('customer.index', $data);
    }

    //keranjang
    public function tambah(Request $req)
    {
        // Ambil data dari request
        $menuId = $req->id_menu;
        $jumlah = $req->jumlah;
        $totalHarga = $req->total_harga;

        // Cek apakah item dengan id_menu sudah ada di keranjang
        $existingItem = DB::table('keranjang')
            ->where('id_menu', $menuId)
            ->first();

        if ($existingItem) {
            // Jika item sudah ada, perbarui jumlah dan total harga
            $newJumlah = $existingItem->jumlah + $jumlah;
            $newTotalHarga = $existingItem->total_harga + $totalHarga;

            $updated = DB::table('keranjang')
                ->where('id_menu', $menuId)
                ->update([
                    'jumlah' => $newJumlah,
                    'total_harga' => $newTotalHarga,
                ]);

            if ($updated) {
                return redirect()->back()->with('success', 'Jumlah menu berhasil diperbarui di keranjang.');
            } else {
                return redirect()->back()->with('danger', 'Gagal memperbarui menu di keranjang.');
            }
        } else {
            // Jika item belum ada, sisipkan item baru ke dalam keranjang
            $inserted = DB::table('keranjang')
                ->insert([
                    'id_menu' => $menuId,
                    'jumlah' => $jumlah,
                    'total_harga' => $totalHarga,
                ]);

            if ($inserted) {
                return redirect()->back()->with('success', 'Menu berhasil dimasukkan ke keranjang.');
            } else {
                return redirect()->back()->with('danger', 'Gagal memasukkan menu ke keranjang.');
            }
        }
    }


    public function demo()
    {
        $userId = auth()->id(); // Mengambil ID pengguna yang sedang login
        $userName = auth()->user()->name; // Mengambil nama pengguna yang sedang login

        // Ambil data rating untuk semua pengguna dengan role 'customer'
        $userRating = DB::table('users')
            ->join('rating', 'rating.id_user', '=', 'users.id')
            ->join('menu', 'menu.id_menu', '=', 'rating.id_menu')
            ->where('users.role', 'customer')
            ->select('users.name as user_name', 'menu.nama_menu', 'rating.bintang', 'menu.kategori')
            ->get();

        // Kumpulkan rating per pengguna, per item, dan per kategori
        $ratingsByUser = [];
        $ratingsByCategory = [];
        foreach ($userRating as $rating) {
            $user = $rating->user_name;
            $item = $rating->nama_menu;
            $category = $rating->kategori;

            $ratingsByUser[$user][$item] = $rating->bintang;
            $ratingsByCategory[$category][$user][$item] = $rating->bintang;
        }

        // Hitung rata-rata rating per kategori dan per pengguna
        $averageUserRatings = [];
        $averageCategoryRatings = [];
        foreach ($ratingsByUser as $user => $ratings) {
            $averageUserRatings[$user] = count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;
        }

        foreach ($ratingsByCategory as $category => $categoryRatings) {
            foreach ($categoryRatings as $user => $ratings) {
                $averageCategoryRatings[$category][$user] = count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;
            }
        }

        // Perhitungan kemiripan antar pengguna untuk setiap kategori
        $userSimilaritiesByCategory = [];
        foreach ($ratingsByCategory as $category => $categoryRatings) {
            $userSimilarities = [];
            $users = array_keys($categoryRatings);
            $userCount = count($users);

            for ($i = 0; $i < $userCount; $i++) {
                for ($j = $i + 1; $j < $userCount; $j++) {
                    $user1 = $users[$i];
                    $user2 = $users[$j];

                    $numerator = 0;
                    $denominator1 = 0;
                    $denominator2 = 0;
                    $commonRatingsCount = 0;

                    if (isset($categoryRatings[$user1]) && isset($categoryRatings[$user2])) {
                        foreach ($categoryRatings[$user1] as $item => $rating1) {
                            if (isset($categoryRatings[$user2][$item])) {
                                $rating2 = $categoryRatings[$user2][$item];
                                $avg1 = $averageCategoryRatings[$category][$user1];
                                $avg2 = $averageCategoryRatings[$category][$user2];

                                $diff1 = $rating1 - $avg1;
                                $diff2 = $rating2 - $avg2;

                                $numerator += $diff1 * $diff2;
                                $denominator1 += $diff1 * $diff1;
                                $denominator2 += $diff2 * $diff2;

                                $commonRatingsCount++;
                            }
                        }
                    }

                    if ($commonRatingsCount > 0) {
                        $denominator = sqrt($denominator1) * sqrt($denominator2);
                        $similarity = ($denominator != 0) ? ($numerator / $denominator) : 0;
                    } else {
                        $similarity = 0;
                    }

                    $userSimilarities["$user1-$user2"] = $similarity;
                }
            }
            $userSimilaritiesByCategory[$category] = $userSimilarities;
        }

        // Dapatkan rekomendasi untuk setiap kategori
        $recommendationsByCategory = [];
        foreach ($ratingsByCategory as $category => $categoryRatings) {
            $recommendationsByCategory[$category] = $this->getRecommendation($categoryRatings, $userSimilaritiesByCategory[$category], $averageCategoryRatings[$category], $userName);
        }

        // Hitung frekuensi pembelian menu per kategori
        $menuFrequencyByCategory = [];
        foreach ($userRating as $rating) {
            $menu = $rating->nama_menu;
            $category = $rating->kategori;

            if (!isset($menuFrequencyByCategory[$category])) {
                $menuFrequencyByCategory[$category] = [];
            }

            if (!isset($menuFrequencyByCategory[$category][$menu])) {
                $menuFrequencyByCategory[$category][$menu] = 0;
            }
            $menuFrequencyByCategory[$category][$menu]++;
        }

        // Hitung frekuensi pembelian menu khusus untuk pengguna yang login per kategori
        $userMenuFrequencyByCategory = [];
        if (isset($ratingsByUser[$userName])) {
            foreach ($ratingsByUser[$userName] as $item => $rating) {
                // Determine the category for this item
                $itemCategory = DB::table('menu')
                    ->where('nama_menu', $item)
                    ->value('kategori');

                if (!isset($userMenuFrequencyByCategory[$itemCategory])) {
                    $userMenuFrequencyByCategory[$itemCategory] = [];
                }

                if (!isset($userMenuFrequencyByCategory[$itemCategory][$item])) {
                    $userMenuFrequencyByCategory[$itemCategory][$item] = 0;
                }
                $userMenuFrequencyByCategory[$itemCategory][$item]++;
            }
        }

        // Urutkan menu berdasarkan frekuensi pembelian
        foreach ($menuFrequencyByCategory as $category => $menuFrequency) {
            arsort($menuFrequencyByCategory[$category]);
        }
        foreach ($userMenuFrequencyByCategory as $category => $userMenuFrequency) {
            arsort($userMenuFrequencyByCategory[$category]);
        }

        // Kirim data ke view
        return view('demo')->with([
            'userRating' => $userRating,
            'ratingsByUser' => $ratingsByUser,
            'averageUserRatings' => $averageUserRatings,
            'userSimilaritiesByCategory' => $userSimilaritiesByCategory,
            'recommendationsByCategory' => $recommendationsByCategory,
            'menuFrequencyByCategory' => $menuFrequencyByCategory,
            'userMenuFrequencyByCategory' => $userMenuFrequencyByCategory,
        ]);
    }

    private function getRecommendation($ratingsByUser, $userSimilarities, $averageCategoryRatings, $userName)
    {
        $recommendations = [];

        if (!isset($ratingsByUser[$userName])) {
            return $recommendations;
        }

        $users = array_keys($ratingsByUser);

        $userSimilarScores = [];
        foreach ($users as $otherUser) {
            if ($userName !== $otherUser && isset($userSimilarities["$userName-$otherUser"])) {
                $userSimilarScores[$otherUser] = $userSimilarities["$userName-$otherUser"];
            }
        }

        arsort($userSimilarScores);

        $userRecommendations = [];
        foreach ($userSimilarScores as $similarUser => $similarity) {
            foreach ($ratingsByUser[$similarUser] as $item => $rating) {
                if (!isset($ratingsByUser[$userName][$item])) {
                    if (isset($userRecommendations[$item])) {
                        $userRecommendations[$item] += $rating * $similarity;
                    } else {
                        $userRecommendations[$item] = $rating * $similarity;
                    }
                }
            }
        }

        arsort($userRecommendations);
        return array_keys($userRecommendations);
    }
}
