<script setup>
import { useForm, Link } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
})

function submit() {
  form.post('/login')
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

    <!-- 🔹 Form Login -->
    <div class="relative z-10 w-full max-w-md p-8 border shadow-2xl bg-white/10 backdrop-blur-lg border-white/20 rounded-2xl">

      <!-- 🖼️ Logo -->
      <div class="flex justify-center mb-4">
        <img
          src="/images/smartvillage.png"
          alt="Logo"
          class="object-contain w-24 h-24 drop-shadow-lg"
        />
      </div>

      <!-- Judul -->
      <h2 class="mb-2 text-3xl font-bold text-center text-white">Login</h2>
      <p class="mb-6 text-sm text-center text-gray-200">
        Silakan login untuk mengakses layanan
      </p>

      <!-- Form -->
      <form @submit.prevent="submit" class="space-y-5">
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

        <!-- Remember me dan lupa password -->
        <div class="flex items-center justify-between text-sm text-gray-200">
          <label class="flex items-center space-x-2">
            <input type="checkbox" class="accent-blue-500" />
            <span>Ingat saya</span>
          </label>
          <a href="#" class="hover:underline">Lupa Password?</a>
        </div>

        <!-- Tombol Login -->
        <button
          type="submit"
          class="w-full py-3 font-bold text-white transition rounded-lg bg-gradient-to-r from-blue-500 to-blue-700 hover:opacity-90"
        >
          LOGIN
        </button>
      </form>

      <!-- Register -->
      <p class="mt-6 text-sm text-center text-gray-200">
        Belum punya akun?
        <a href="/register" class="font-semibold text-blue-300 hover:underline">
          Daftar di sini
        </a>
      </p>

      <!-- Tombol kembali -->
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
