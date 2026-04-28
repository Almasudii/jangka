<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
</script>

<template>
  <DashboardLayout>
    <div>
      <h1 class="text-2xl font-bold mb-4 text-gray-800">Peta Desa</h1>
      <p class="text-gray-600 mb-6">
        Visualisasi lokasi dan batas wilayah Desa di Kabupaten Sampang.
      </p>

      <!-- Contoh Peta (gunakan iframe Google Maps atau Leaflet.js jika ingin interaktif) -->
      <div class="w-full h-96 rounded-xl overflow-hidden shadow-lg">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.879651000364!2d113.2493!3d-7.1856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7c6c93ff1a9f1%3A0x4027a76e3531230!2sKabupaten%20Sampang%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1715776000000!5m2!1sid!2sid"
          width="100%"
          height="100%"
          style="border:0;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
      </div>
    </div>
  </DashboardLayout>
</template>
