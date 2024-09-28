<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;
    protected $table = 'detail';
    protected $primaryKey = 'id_detail'; // Menentukan primary key
    protected $fillable = [
        'id_detail',
        'id_menu',
        'id_reservasi',
        'jumlah',
        'harga',
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu'); // Sesuaikan dengan kolom id_menu di tabel detail
    }
}
