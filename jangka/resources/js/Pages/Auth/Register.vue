<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
  villages: {
    type: Array,
    default: () => []
  }
})

const villages = ref(props.villages || [])

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  desa_id: '',
})

// Ambil data desa dari API jika belum ada
onMounted(async () => {
  if (!villages.value.length) {
    try {
      const response = await axios.get('/api/desa')
      villages.value = response.data
    } catch (error) {
      console.error('Gagal mengambil data desa:', error)
    }
  }
})

// Submit form
function submit() {
  form.post('/register', {
    onSuccess: () => {
      alert('Akun berhasil dibuat! Silakan login terlebih dahulu.')
    },
  })
}
</script>

<template>
  <div class="relative flex items-center justify-center min-h-screen overflow-hidden">

    <!-- 🔹 Background Video -->
    <video autoplay muted loop playsinline class="absolute object-cover w-full h-full">
      <source src="/videos/Sampang.mp4" type="video/mp4" />
    </video>

    <!-- 🔹 Overlay Gelap -->
    <div class="absolute inset-0 bg-black/50"></div>

    <!-- 🔹 Card Register -->
    <div class="relative z-10 w-full max-w-md p-8 border shadow-2xl bg-white/10 backdrop-blur-lg border-white/20 rounded-2xl">

      <!-- 🖼️ Logo -->
      <div class="flex justify-center mb-4">
        <img
          src="/images/smartvillage.png"
          alt="Logo Smart Village"
          class="object-contain w-24 h-24 drop-shadow-lg"
        />
      </div>

      <!-- Judul -->
      <h2 class="mb-2 text-3xl font-bold text-center text-white">Register</h2>
      <p class="mb-6 text-sm text-center text-gray-200">
        Isi data di bawah untuk membuat akun baru
      </p>

      <!-- Form -->
      <form @submit.prevent="submit" class="space-y-5">

        <!-- Nama -->
        <div>
          <input
            v-model="form.name"
            type="text"
            placeholder="Nama Lengkap"
            class="w-full px-4 py-3 text-white placeholder-gray-200 rounded-lg bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
        </div>

        <!-- Email -->
        <div>
          <input
            v-model="form.email"
            type="email"
            placeholder="Alamat Email"
            class="w-full px-4 py-3 text-white placeholder-gray-200 rounded-lg bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
        </div>

        <!-- Desa -->
        <div>
          <select
            v-model="form.desa_id"
            class="w-full px-4 py-3 text-white rounded-lg bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          >
            <option value="" disabled class="text-gray-300 bg-gray-700">Pilih Desa...</option>
            <option
              v-for="desa in villages"
              :key="desa.id"
              :value="desa.id"
              class="text-white bg-gray-700"
            >
              {{ desa.nama_desa }}
            </option>
          </select>
        </div>

        <!-- Password -->
        <div>
          <input
            v-model="form.password"
            type="password"
            placeholder="Password"
            class="w-full px-4 py-3 text-white placeholder-gray-200 rounded-lg bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
        </div>

        <!-- Konfirmasi Password -->
        <div>
          <input
            v-model="form.password_confirmation"
            type="password"
            placeholder="Konfirmasi Password"
            class="w-full px-4 py-3 text-white placeholder-gray-200 rounded-lg bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
        </div>

        <!-- Tombol Daftar -->
        <button
          type="submit"
          class="w-full py-3 font-bold text-white transition rounded-lg bg-gradient-to-r from-blue-500 to-blue-700 hover:opacity-90"
        >
          DAFTAR
        </button>
      </form>

      <!-- Sudah Punya Akun -->
      <p class="mt-6 text-sm text-center text-gray-200">
        Sudah punya akun?
        <a href="/login" class="font-semibold text-blue-300 hover:underline">
          Login di sini
        </a>
      </p>

      <!-- Kembali ke Halaman Utama -->
      <div class="mt-6 text-center">
        <Link
          href="/"
          class="inline-block px-4 py-2 font-semibold text-gray-100 transition rounded-md bg-white/20 hover:bg-white/30"
        >
          ← Kembali ke Halaman Utama
        </Link>
      </div>
    </div>
  </div>
</template>

<style scoped>
video {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 0;
}
</style>
