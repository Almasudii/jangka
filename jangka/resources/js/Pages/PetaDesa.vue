<script setup>
import { computed } from 'vue'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
  desa: String
})

const mapUrl = computed(() => {
  const query = encodeURIComponent(`Desa ${props.desa || 'Tidak Diketahui'}, Sampang, Jawa Timur`)
  return `https://maps.google.com/maps?q=${query}&t=&z=13&ie=UTF8&iwloc=&output=embed`
})
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col h-full w-full">
      <h1 class="text-2xl font-bold mb-4 text-gray-800">Peta Desa</h1>
      <p class="text-gray-600 mb-6">
        Visualisasi lokasi dan batas wilayah Desa {{ desa || 'Tidak Diketahui' }} di Kabupaten Sampang, Jawa Timur.
      </p>

      <!-- Contoh Peta -->
      <div class="flex-grow w-full rounded-xl overflow-hidden shadow-lg relative bg-gray-900 border border-gray-700 h-[calc(100vh-200px)]">
        <iframe
          :src="mapUrl"
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
