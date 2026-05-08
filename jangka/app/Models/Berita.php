<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'ringkasan',
        'isi',
        'thumbnail',
        'status',
        'penulis_id',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}