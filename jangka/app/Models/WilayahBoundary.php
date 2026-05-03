<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WilayahBoundary extends Model
{
    protected $table = 'wilayah_boundaries';

    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'kode',
        'nama',
        'lat',
        'lng',
        'path',
        'status',
    ];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'status' => 'integer',
    ];
}