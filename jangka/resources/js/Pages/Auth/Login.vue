<script setup>
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'

const notification = ref({
  show: false,
  type: 'success',
  message: '',
})

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function showNotification(type, message) {
  notification.value = {
    show: true,
    type,
    message,
  }

  setTimeout(() => {
    notification.value.show = false
  }, 3500)
}

function submit() {
  form.post('/login', {
    preserveScroll: true,

    onStart: () => {
      notification.value.show = false
    },

    onSuccess: () => {
      showNotification('success', 'Login berhasil. Mengalihkan ke dashboard...')
    },

    onError: () => {
      showNotification(
        'error',
        'Login gagal. Email atau password yang kamu masukkan salah.'
      )
    },

    onFinish: () => {
      form.reset('password')
    },
  })
}
</script>

<template>
  <div class="relative flex items-center justify-center min-h-screen overflow-hidden">
    <video autoplay muted loop playsinline class="absolute object-cover w-full h-full">
      <source src="/videos/Sampang.mp4" type="video/mp4" />
    </video>

    <div class="absolute inset-0 bg-black/50"></div>

    <transition name="fade">
      <div
        v-if="notification.show"
        class="fixed z-50 px-5 py-4 border shadow-xl top-6 right-6 rounded-xl backdrop-blur-md"
        :class="notification.type === 'success'
          ? 'bg-green-500/90 border-green-300 text-white'
          : 'bg-red-500/90 border-red-300 text-white'"
      >
        <p class="text-sm font-semibold">
          {{ notification.message }}
        </p>
      </div>
    </transition>

    <div class="relative z-10 w-full max-w-md p-8 border shadow-2xl bg-white/10 backdrop-blur-lg border-white/20 rounded-2xl">
      <div class="flex justify-center mb-4">
        <img
          src="/images/smartvillage.png"
          alt="Logo"
          class="object-contain w-24 h-24 drop-shadow-lg"
        />
      </div>

      <h2 class="mb-2 text-3xl font-bold text-center text-white">
        Login
      </h2>

      <p class="mb-6 text-sm text-center text-gray-200">
        Silakan login untuk mengakses layanan
      </p>

      <form @submit.prevent="submit" class="space-y-5">
        <div>
          <input
            v-model="form.email"
            type="email"
            placeholder="Alamat Email"
            class="w-full px-4 py-3 text-white placeholder-gray-200 rounded-lg bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />

          <p
            v-if="form.errors.email"
            class="mt-2 text-sm font-semibold text-red-300"
          >
            {{ form.errors.email }}
          </p>
        </div>

        <div>
          <input
            v-model="form.password"
            type="password"
            placeholder="Password"
            class="w-full px-4 py-3 text-white placeholder-gray-200 rounded-lg bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />

          <p
            v-if="form.errors.password"
            class="mt-2 text-sm font-semibold text-red-300"
          >
            {{ form.errors.password }}
          </p>
        </div>

        <div class="flex items-center justify-between text-sm text-gray-200">
          <label class="flex items-center space-x-2">
            <input
              v-model="form.remember"
              type="checkbox"
              class="accent-blue-500"
            />
            <span>Ingat saya</span>
          </label>

          <a href="#" class="hover:underline">
            Lupa Password?
          </a>
        </div>

        <button
          type="submit"
          :disabled="form.processing"
          class="flex items-center justify-center w-full gap-3 py-3 font-bold text-white transition rounded-lg bg-gradient-to-r from-blue-500 to-blue-700 hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-70"
        >
          <span
            v-if="form.processing"
            class="w-5 h-5 border-2 border-white rounded-full border-t-transparent animate-spin"
          ></span>

          <span>
            {{ form.processing ? 'LOGIN...' : 'LOGIN' }}
          </span>
        </button>
      </form>

      <p class="mt-6 text-sm text-center text-gray-200">
        Belum punya akun?
        <a href="/register" class="font-semibold text-blue-300 hover:underline">
          Daftar di sini
        </a>
      </p>

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

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s, transform 0.25s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>