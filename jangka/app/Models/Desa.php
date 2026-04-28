<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;

    protected $table = 'desa'; // ✅ pastikan nama tabel benar
    protected $fillable = ['nama_desa']; // tambah kolom lain nanti jika perlu

    // ✅ relasi ke User
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
