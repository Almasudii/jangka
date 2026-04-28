<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
</script>

<template>
  <DashboardLayout>
    <div>
      <h1 class="text-2xl font-bold mb-4 text-gray-800">Layanan Desa</h1>
      <p class="text-gray-600 mb-6">
        Berikut adalah daftar layanan yang tersedia di Smart Village Kabupaten Sampang.
      </p>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition">
          <h2 class="text-lg font-semibold text-blue-800">Layanan Administrasi</h2>
          <p class="text-gray-500 text-sm mt-2">Pembuatan surat keterangan, pengantar, dan dokumen desa.</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition">
          <h2 class="text-lg font-semibold text-blue-800">Layanan Kependudukan</h2>
          <p class="text-gray-500 text-sm mt-2">Data penduduk, mutasi, dan pencatatan keluarga.</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition">
          <h2 class="text-lg font-semibold text-blue-800">Layanan Pengaduan</h2>
          <p class="text-gray-500 text-sm mt-2">Saluran aspirasi dan laporan masyarakat desa.</p>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>
