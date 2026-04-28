<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
</script>

<template>
  <DashboardLayout>
    <div>
      <h1 class="text-2xl font-bold mb-4 text-gray-800">Berita Desa</h1>
      <p class="text-gray-600 mb-6">
        Update informasi terkini seputar kegiatan dan pengumuman dari Pemerintah Desa.
      </p>

      <div class="space-y-4">
        <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">
          <h2 class="text-lg font-semibold text-blue-800">Gotong Royong Bersihkan Lingkungan</h2>
          <p class="text-gray-500 text-sm mt-1">Diposting pada 10 Oktober 2025</p>
          <p class="mt-2 text-gray-600">Warga bersama perangkat desa melaksanakan kegiatan kebersihan di sekitar balai desa.</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition">
          <h2 class="text-lg font-semibold text-blue-800">Pelatihan Digitalisasi Desa</h2>
          <p class="text-gray-500 text-sm mt-1">Diposting pada 5 Oktober 2025</p>
          <p class="mt-2 text-gray-600">Pelatihan ini bertujuan meningkatkan kemampuan perangkat desa dalam pengelolaan website dan data digital.</p>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>
