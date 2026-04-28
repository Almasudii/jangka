<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Atribut yang bisa diisi (mass assignable).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'desa_id',
        'role',
        'profile_photo',
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi atribut ke tipe tertentu.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke model Desa.
     */
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }

    /**
     * Atribut tambahan yang otomatis dikirim ke frontend.
     */
    protected $appends = ['profile_photo_url'];

    /**
     * ✅ Accessor otomatis mengembalikan URL lengkap foto.
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo
            ? asset('storage/' . $this->profile_photo)
            : asset('/images/default-profile.png');
    }
        // ✅ Ambil pengaturan user (dalam bentuk array)
        public function getSettingsAttribute($value)
        {
            return $value ? json_decode($value, true) : [
                'dark_mode' => false,
                'notifications' => true,
            ];
        }
    
}
