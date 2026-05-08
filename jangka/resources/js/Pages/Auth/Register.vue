<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import axios from 'axios'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  villages: {
    type: Array,
    default: () => [],
  },
})

const villages = ref(props.villages || [])

const notification = ref({
  show: false,
  type: 'success',
  message: '',
})

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  desa_id: '',
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

onMounted(async () => {
  if (!villages.value.length) {
    try {
      const response = await axios.get('/api/desa')
      villages.value = response.data
    } catch (error) {
      showNotification('error', 'Gagal mengambil data desa.')
      console.error('Gagal mengambil data desa:', error)
    }
  }
})

function submit() {
  form.post(route('register'), {
    preserveScroll: true,

    onStart: () => {
      notification.value.show = false
    },

    onSuccess: () => {
      showNotification('success', 'Registrasi berhasil. Mengalihkan ke dashboard...')
      form.reset('password', 'password_confirmation')
    },

    onError: () => {
      showNotification(
        'error',
        'Registrasi gagal. Periksa kembali data yang kamu masukkan.'
      )
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
          alt="Logo Smart Village"
          class="object-contain w-24 h-24 drop-shadow-lg"
        />
      </div>

      <h2 class="mb-2 text-3xl font-bold text-center text-white">
        Register
      </h2>

      <p class="mb-6 text-sm text-center text-gray-200">
        Isi data di bawah untuk membuat akun baru
      </p>

      <form @submit.prevent="submit" class="space-y-5">
        <div>
          <input
            v-model="form.name"
            type="text"
            placeholder="Nama Lengkap"
            class="w-full px-4 py-3 text-white placeholder-gray-200 rounded-lg bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div>
          <input
            v-model="form.email"
            type="email"
            placeholder="Alamat Email"
            class="w-full px-4 py-3 text-white placeholder-gray-200 rounded-lg bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div>
          <select
            v-model="form.desa_id"
            class="w-full px-4 py-3 text-white rounded-lg bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          >
            <option value="" disabled class="text-gray-300 bg-gray-700">
              Pilih Desa...
            </option>

            <option
              v-for="desa in villages"
              :key="desa.id"
              :value="desa.id"
              class="text-white bg-gray-700"
            >
              {{ desa.nama_desa }}
            </option>
          </select>

          <InputError class="mt-2" :message="form.errors.desa_id" />
        </div>

        <div>
          <input
            v-model="form.password"
            type="password"
            placeholder="Password"
            class="w-full px-4 py-3 text-white placeholder-gray-200 rounded-lg bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div>
          <input
            v-model="form.password_confirmation"
            type="password"
            placeholder="Konfirmasi Password"
            class="w-full px-4 py-3 text-white placeholder-gray-200 rounded-lg bg-white/20 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
          <InputError class="mt-2" :message="form.errors.password_confirmation" />
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
            {{ form.processing ? 'MEMPROSES...' : 'DAFTAR' }}
          </span>
        </button>
      </form>

      <p class="mt-6 text-sm text-center text-gray-200">
        Sudah punya akun?
        <a :href="route('login')" class="font-semibold text-blue-300 hover:underline">
          Login di sini
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