<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

// Data fasilitas (bisa kamu ambil dari backend kalau mau)
const fasilitas = [
  {
    icon: '🏫',
    nama: 'Kantor Desa',
    deskripsi: 'Tempat pelayanan administrasi dan kegiatan pemerintahan desa.',
  },
  {
    icon: '💧',
    nama: 'PDAM Desa',
    deskripsi: 'Sarana penyediaan air bersih bagi warga desa.',
  },
  {
    icon: '🏥',
    nama: 'Puskesmas Desa',
    deskripsi: 'Fasilitas kesehatan utama bagi masyarakat desa.',
  },
  {
    icon: '📚',
    nama: 'Perpustakaan Desa',
    deskripsi: 'Pusat literasi dan pengetahuan masyarakat.',
  },
  {
    icon: '🕌',
    nama: 'Masjid Besar',
    deskripsi: 'Tempat ibadah utama dan kegiatan keagamaan warga desa.',
  },
  {
    icon: '🎮',
    nama: 'Balai Pemuda',
    deskripsi: 'Tempat kegiatan pemuda dan olahraga di desa.',
  },
]
</script>

<template>
  <DashboardLayout>
    <div>
      <!-- Judul Halaman -->
      <h1 class="mb-4 text-2xl font-bold text-gray-800">Fasilitas Desa</h1>
      <p class="mb-6 text-gray-600">
        Berikut adalah berbagai fasilitas umum yang tersedia untuk mendukung kegiatan dan kebutuhan masyarakat desa.
      </p>

      <!-- Grid Fasilitas -->
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="(item, index) in fasilitas"
          :key="index"
          class="p-6 transition transform bg-white border border-blue-200 shadow rounded-2xl hover:shadow-lg hover:-translate-y-1"
        >
          <div class="mb-4 text-5xl text-center">{{ item.icon }}</div>
          <h2 class="mb-2 text-xl font-semibold text-center text-blue-800">{{ item.nama }}</h2>
          <p class="text-sm leading-relaxed text-center text-gray-600">
            {{ item.deskripsi }}
          </p>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>
