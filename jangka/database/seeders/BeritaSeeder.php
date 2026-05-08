<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        Berita::create([
            'judul' => 'Pemerintah Desa Mengadakan Kegiatan Kerja Bakti',
            'ringkasan' => 'Kegiatan kerja bakti dilakukan untuk menjaga kebersihan lingkungan desa.',
            'isi' => 'Pemerintah desa bersama masyarakat mengadakan kegiatan kerja bakti di lingkungan sekitar. Kegiatan ini bertujuan untuk meningkatkan kepedulian warga terhadap kebersihan, mempererat hubungan sosial, dan menciptakan lingkungan yang lebih sehat.',
            'thumbnail' => null,
            'status' => 'published',
            'penulis_id' => 1,
            'published_at' => now(),
        ]);

        Berita::create([
            'judul' => 'Pengumuman Pelayanan Administrasi Desa',
            'ringkasan' => 'Pelayanan administrasi desa dibuka pada hari kerja sesuai jam operasional.',
            'isi' => 'Pelayanan administrasi desa tetap berjalan seperti biasa pada hari Senin sampai Jumat. Masyarakat dapat mengurus surat keterangan, surat pengantar, dan kebutuhan administrasi lainnya di kantor desa selama jam kerja.',
            'thumbnail' => null,
            'status' => 'published',
            'penulis_id' => 1,
            'published_at' => now(),
        ]);

        Berita::create([
            'judul' => 'Rencana Pembangunan Fasilitas Umum Desa',
            'ringkasan' => 'Pemerintah desa merencanakan pembangunan fasilitas umum untuk menunjang aktivitas masyarakat.',
            'isi' => 'Pemerintah desa menyusun rencana pembangunan fasilitas umum sebagai bagian dari upaya meningkatkan kualitas pelayanan dan kenyamanan masyarakat. Program ini akan disesuaikan dengan kebutuhan warga dan prioritas pembangunan desa.',
            'thumbnail' => null,
            'status' => 'draft',
            'penulis_id' => 1,
            'published_at' => null,
        ]);
    }
}