<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  form.post(route('admin.login.submit'))
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white shadow rounded-xl p-8 w-full max-w-md">
      <h2 class="text-2xl font-bold text-center mb-6">Login Admin</h2>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block mb-1">Email</label>
          <input v-model="form.email" type="email" class="w-full border rounded px-3 py-2" required />
        </div>

        <div class="mb-4">
          <label class="block mb-1">Password</label>
          <input v-model="form.password" type="password" class="w-full border rounded px-3 py-2" required />
        </div>

        <div class="mb-4 flex items-center">
          <input v-model="form.remember" type="checkbox" id="remember" class="mr-2" />
          <label for="remember">Ingat saya</label>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700" :disabled="form.processing">
          {{ form.processing ? 'Memproses...' : 'Login Admin' }}
        </button>

        <div class="text-center mt-4">
          <a :href="route('admin.register')" class="text-blue-500 hover:underline">
            Belum punya akun admin? Daftar
          </a>
        </div>
      </form>
    </div>
  </div>
</template>
