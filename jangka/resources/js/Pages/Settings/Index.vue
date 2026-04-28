<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import { watch } from 'vue'

// Gunakan layout utama seperti Edit Profile
defineOptions({ layout: DashboardLayout })

const page = usePage()
const user = page.props.auth.user

// Form pengaturan (ambil default dari user settings)
const form = useForm({
  dark_mode: user?.settings?.dark_mode ?? false,
  language: user?.settings?.language ?? 'id',
  timezone: user?.settings?.timezone ?? 'Asia/Jakarta',
  theme_color: user?.settings?.theme_color ?? 'blue',
})

// 🌙 Dark Mode Handler
const setDarkMode = (enabled) => {
  document.documentElement.classList.toggle('dark', enabled)
}

// Aktifkan awal
setDarkMode(form.dark_mode)

// Pantau perubahan realtime
watch(() => form.dark_mode, (val) => setDarkMode(val))

// Simpan ke server
const saveSettings = () => {
  form.post(route('settings.update'), {
    preserveScroll: true,
    onSuccess: () => alert('✅ Pengaturan berhasil disimpan!'),
  })
}
</script>

<template>
  <Head title="Pengaturan Akun" />

  <div class="space-y-10">
    <!-- 🔷 Header -->
    <div
      class="flex items-center gap-4 p-6 text-white shadow-md bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl"
    >
      <img
        :src="user?.profile_photo_url || '/images/default-profile.png'"
        alt="Foto Profil"
        class="w-16 h-16 border-4 border-white rounded-full shadow-md"
      />
      <div>
        <h2 class="text-2xl font-bold tracking-wide">Pengaturan Akun</h2>
        <p class="text-sm text-blue-100">Atur tema, bahasa, dan preferensi lainnya.</p>
      </div>
    </div>

    <!-- 🔶 Isi Pengaturan -->
    <form @submit.prevent="saveSettings" class="space-y-8">
      <!-- Tema -->
      <div
        class="p-6 transition duration-300 bg-white border border-gray-100 shadow-lg rounded-2xl hover:shadow-xl dark:bg-gray-800 dark:border-gray-700"
      >
        <h3 class="pb-2 mb-4 text-lg font-semibold text-gray-800 border-b dark:text-gray-100">
          Tampilan & Tema
        </h3>

        <div class="flex items-center justify-between mb-4">
          <span class="text-gray-800 dark:text-gray-200">Mode Gelap</span>
          <input type="checkbox" v-model="form.dark_mode" class="w-5 h-5 text-blue-600 rounded" />
        </div>

        <div class="flex items-center justify-between">
          <span class="text-gray-800 dark:text-gray-200">Warna Tema</span>
          <select
            v-model="form.theme_color"
            class="px-3 py-1 border border-gray-300 rounded-lg bg-white/70 dark:bg-gray-800 dark:text-gray-100"
          >
            <option value="blue">Biru</option>
            <option value="emerald">Hijau</option>
            <option value="violet">Ungu</option>
            <option value="rose">Merah Muda</option>
          </select>
        </div>
      </div>

      <!-- Bahasa & Zona Waktu -->
      <div
        class="p-6 transition duration-300 bg-white border border-gray-100 shadow-lg rounded-2xl hover:shadow-xl dark:bg-gray-800 dark:border-gray-700"
      >
        <h3 class="pb-2 mb-4 text-lg font-semibold text-gray-800 border-b dark:text-gray-100">
          Bahasa & Zona Waktu
        </h3>

        <div class="flex items-center justify-between mb-4">
          <span class="text-gray-800 dark:text-gray-200">Bahasa</span>
          <select
            v-model="form.language"
            class="px-3 py-1 border border-gray-300 rounded-lg bg-white/70 dark:bg-gray-800 dark:text-gray-100"
          >
            <option value="id">Bahasa Indonesia</option>
            <option value="en">English</option>
          </select>
        </div>

        <div class="flex items-center justify-between">
          <span class="text-gray-800 dark:text-gray-200">Zona Waktu</span>
          <select
            v-model="form.timezone"
            class="px-3 py-1 border border-gray-300 rounded-lg bg-white/70 dark:bg-gray-800 dark:text-gray-100"
          >
            <option value="Asia/Jakarta">Asia/Jakarta (WIB)</option>
            <option value="Asia/Makassar">Asia/Makassar (WITA)</option>
            <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
          </select>
        </div>
      </div>

      <!-- Tombol Simpan -->
      <div class="flex justify-end">
        <button
          type="submit"
          class="px-5 py-2 font-semibold text-white transition bg-blue-600 rounded-lg shadow hover:bg-blue-700"
          :disabled="form.processing"
        >
          {{ form.processing ? 'Menyimpan...' : 'Simpan Pengaturan' }}
        </button>
      </div>
    </form>
  </div>
</template>
