<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

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

    protected static function booted(): void
    {
        static::created(function ($user) {
            if (!$user->profile_photo) {
                $svg = self::generateDefaultAvatarSvg($user->email);

                $path = 'profile-photos/user-' . $user->id . '.svg';

                Storage::disk('public')->put($path, $svg);

                $user->forceFill([
                    'profile_photo' => $path,
                ])->saveQuietly();
            }
        });
    }

    private static function generateDefaultAvatarSvg(string $seed): string
    {
        $hash = md5($seed);
        $color = '#' . substr($hash, 0, 6);

        $cells = '';
        $size = 5;
        $cell = 20;

        for ($y = 0; $y < $size; $y++) {
            for ($x = 0; $x < 3; $x++) {
                $index = $y * 3 + $x;
                $value = hexdec($hash[$index]);

                if ($value % 2 === 0) {
                    $leftX = $x * $cell;
                    $rightX = ($size - 1 - $x) * $cell;

                    $cells .= "<rect x='{$leftX}' y='" . ($y * $cell) . "' width='{$cell}' height='{$cell}' fill='{$color}'/>";

                    if ($leftX !== $rightX) {
                        $cells .= "<rect x='{$rightX}' y='" . ($y * $cell) . "' width='{$cell}' height='{$cell}' fill='{$color}'/>";
                    }
                }
            }
        }

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
    <rect width="100" height="100" fill="#f3f4f6"/>
    {$cells}
</svg>
SVG;
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
