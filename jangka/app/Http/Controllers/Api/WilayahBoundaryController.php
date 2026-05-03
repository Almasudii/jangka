<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WilayahBoundary;
use Illuminate\Http\Request;

class WilayahBoundaryController extends Controller
{
    public function index(Request $request)
    {
        $query = WilayahBoundary::query();

        // filter berdasarkan nama
        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        $data = $query->get()->map(function ($item) {
            return [
                'kode' => $item->kode,
                'nama' => $item->nama,
                'lat' => $item->lat,
                'lng' => $item->lng,
                'path' => $item->path ? json_decode($item->path, true) : null,
                'status' => $item->status,
            ];
        });

        return response()->json([
            'success' => true,
            'total' => $data->count(),
            'data' => $data,
        ]);
    }

    public function show($kode)
    {
        $wilayah = WilayahBoundary::where('kode', $kode)->first();

        if (!$wilayah) {
            return response()->json([
                'success' => false,
                'message' => 'Data wilayah tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'kode' => $wilayah->kode,
                'nama' => $wilayah->nama,
                'lat' => $wilayah->lat,
                'lng' => $wilayah->lng,
                'path' => $wilayah->path ? json_decode($wilayah->path, true) : null,
                'status' => $wilayah->status,
            ],
        ]);
    }
}