<?php

namespace App\Services;

use App\Models\User;
use App\Models\Menu;
use App\Models\rating;

class CollaborativeFilteringService
{
    /**
     * Menghitung similarity antara dua pengguna berdasarkan kategori
     *
     * @param User $userA
     * @param User $userB
     * @param string $category
     * @return float
     */
    public function calculateSimilarity(User $userA, User $userB, string $category)
    {
        // Ambil rating dari kedua pengguna untuk kategori tertentu
        $ratingsA = rating::where('id_user', $userA->id)
            ->whereHas('menu', function ($query) use ($category) {
                $query->where('kategori', $category);
            })
            ->pluck('bintang', 'id_menu');

        $ratingsB = rating::where('id_user', $userB->id)
            ->whereHas('menu', function ($query) use ($category) {
                $query->where('kategori', $category);
            })
            ->pluck('bintang', 'id_menu');

        // Temukan menu yang sama yang telah dinilai oleh kedua pengguna
        $commonMenuIds = $ratingsA->keys()->intersect($ratingsB->keys());

        if ($commonMenuIds->isEmpty()) {
            return 0; // Tidak ada menu yang sama untuk dibandingkan
        }

        // Hitung rata-rata rating untuk kedua pengguna dalam kategori ini
        $avgA = $ratingsA->avg();
        $avgB = $ratingsB->avg();

        // Hitung numerator dan denominator untuk cosine similarity
        $numerator = 0;
        $denominatorA = 0;
        $denominatorB = 0;

        foreach ($commonMenuIds as $menuId) {
            $diffA = $ratingsA[$menuId] - $avgA;
            $diffB = $ratingsB[$menuId] - $avgB;

            $numerator += $diffA * $diffB;
            $denominatorA += pow($diffA, 2);
            $denominatorB += pow($diffB, 2);
        }

        if ($denominatorA == 0 || $denominatorB == 0) {
            return 0;
        }

        return $numerator / (sqrt($denominatorA) * sqrt($denominatorB));
    }

    /**
     * Menghasilkan rekomendasi menu untuk pengguna berdasarkan similarity per kategori
     *
     * @param User $user
     * @return array
     */
    public function recommendMenus(User $user)
    {
        // Dapatkan semua kategori
        $categories = Menu::distinct()->pluck('kategori');

        $recommendations = [];

        foreach ($categories as $category) {
            // Rekomendasi per kategori
            $recommendations[$category] = $this->recommendPerCategory($user, $category);
        }

        return $recommendations;
    }

    /**
     * Rekomendasi menu per kategori untuk pengguna
     *
     * @param User $user
     * @param string $category
     * @return array
     */
    private function recommendPerCategory(User $user, string $category)
    {
        // Ambil semua pengguna dengan role 'Customer' kecuali pengguna saat ini
        $otherCustomers = User::where('role', 'Customer')->where('id', '!=', $user->id)->get();

        $similarities = [];

        // Hitung similarity antara pengguna saat ini dengan setiap pengguna lain
        foreach ($otherCustomers as $otherCustomer) {
            $similarity = $this->calculateSimilarity($user, $otherCustomer, $category);
            if ($similarity > 0) { // Hanya mempertimbangkan similarity positif
                $similarities[$otherCustomer->id] = $similarity;
            }
        }

        if (empty($similarities)) {
            return []; // Tidak ada rekomendasi jika tidak ada similarity
        }

        // Urutkan pengguna lain berdasarkan similarity descending
        arsort($similarities);

        // Ambil top N pengguna yang paling mirip, misalnya 5
        $topSimilarUsers = array_slice($similarities, 0, 5, true);

        // Ambil semua menu di kategori ini yang belum dirating oleh pengguna
        $unratedMenuIds = Menu::where('kategori', $category)
            ->whereDoesntHave('ratings', function ($query) use ($user) {
                $query->where('id_user', $user->id);
            })
            ->pluck('id_menu');

        if ($unratedMenuIds->isEmpty()) {
            return []; // Semua menu di kategori ini telah dirating
        }

        // Ambil data menu dari database
        $recommendedMenus = Menu::whereIn('id', $unratedMenuIds)->get();

        return $recommendedMenus;
    }
}
