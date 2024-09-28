<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    use HasFactory;

    protected $table = 'rating';
    public $timestamps = false;
    protected $fillable = [
        'id_reservasi',
        'id_menu',
        'id_user',
        'bintang',
        'ulasan'
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user'); // Assuming 'id_user' is the foreign key in the ratings table
    }
}
