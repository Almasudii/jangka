<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

defineProps({
  profil: Object
})
</script>

<template>
  <DashboardLayout>
    <div class="min-h-screen px-6 py-10 text-gray-800 bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
      <div class="max-w-4xl p-8 mx-auto bg-white shadow-md rounded-2xl dark:bg-gray-800">
        <h1 class="mb-6 text-3xl font-bold text-center">{{ profil.nama }}</h1>

        <section class="mb-6">
          <h2 class="mb-2 text-xl font-semibold">Alamat / Lokasi</h2>
          <p>{{ profil.alamat }}</p>
        </section>

        <section class="mb-6">
          <h2 class="mb-2 text-xl font-semibold">Sejarah Desa</h2>
          <p>{{ profil.sejarah }}</p>
        </section>

        <section class="mb-6">
          <h2 class="mb-2 text-xl font-semibold">Visi & Misi</h2>
          <p class="font-semibold">Visi:</p>
          <p class="mb-2">{{ profil.visi }}</p>
          <p class="font-semibold">Misi:</p>
          <ul class="list-disc list-inside">
            <li v-for="(item, i) in profil.misi" :key="i">{{ item }}</li>
          </ul>
        </section>

        <section class="mb-6">
          <h2 class="mb-2 text-xl font-semibold">Struktur Pemerintahan</h2>
          <ul class="list-disc list-inside">
            <li v-for="(nama, jabatan) in profil.struktur" :key="jabatan">
              <strong>{{ jabatan }}</strong>: {{ nama }}
            </li>
          </ul>
        </section>

        <section>
          <h2 class="mb-2 text-xl font-semibold">Potensi Desa</h2>
          <p>{{ profil.potensi }}</p>
        </section>
      </div>
    </div>
  </DashboardLayout>
</template>
