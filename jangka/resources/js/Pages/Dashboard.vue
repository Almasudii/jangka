<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const jumlahPenduduk = 1500
const jumlahBerita = 10
const jumlahLayanan = 5

defineProps({
  desa: String
})
</script>

<template>
  <DashboardLayout>
    <div class="min-h-screen text-gray-800 bg-gray-50">

      <!-- Info Desa -->
      <div class="p-8 text-center">
        <h1 class="mb-2 text-3xl font-bold text-blue-700">
          Selamat Datang
        </h1>
        <p class="font-semibold text-blue-600">
          Di Desa <span class="font-semibold text-blue-600">{{ desa }}</span>
        </p>
      </div>

      <!-- Isi Dashboard -->
      <div class="grid grid-cols-1 gap-8 p-10 sm:grid-cols-2 lg:grid-cols-3">
        <div class="p-8 text-center text-white shadow-lg rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700">
          <h3 class="text-lg font-medium">Jumlah Penduduk</h3>
          <p class="mt-2 text-5xl font-extrabold">{{ jumlahPenduduk }}</p>
        </div>

        <div class="p-8 text-center text-white shadow-lg rounded-2xl bg-gradient-to-br from-green-400 to-green-600">
          <h3 class="text-lg font-medium">Jumlah Berita</h3>
          <p class="mt-2 text-5xl font-extrabold">{{ jumlahBerita }}</p>
        </div>

        <div class="p-8 text-center text-white shadow-lg rounded-2xl bg-gradient-to-br from-yellow-400 to-yellow-600">
          <h3 class="text-lg font-medium">Jumlah Layanan</h3>
          <p class="mt-2 text-5xl font-extrabold">{{ jumlahLayanan }}</p>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>
