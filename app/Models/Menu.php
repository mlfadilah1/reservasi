<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $primaryKey = 'id_menu'; // Menentukan primary key
    protected $fillable = [
        'id_menu',
        'nama_menu',
        'deskripsi',
        'harga',
        'kategori',
        'foto',
    ];
    public function detail()
    {
        return $this->hasMany(Reservasi::class, 'id_menu');
    }

    // public function rating()
    // {
    //     return $this->hasMany(rating::class, 'id_menu');
    // }
}
