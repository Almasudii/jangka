<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

function submit() {
  form.post(route('admin.register.submit'))
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white shadow rounded-xl p-8 w-full max-w-md">
      <h2 class="text-2xl font-bold text-center mb-6">Register Admin</h2>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block mb-1">Nama</label>
          <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" required />
        </div>

        <div class="mb-4">
          <label class="block mb-1">Email</label>
          <input v-model="form.email" type="email" class="w-full border rounded px-3 py-2" required />
        </div>

        <div class="mb-4">
          <label class="block mb-1">Password</label>
          <input v-model="form.password" type="password" class="w-full border rounded px-3 py-2" required />
        </div>

        <div class="mb-4">
          <label class="block mb-1">Konfirmasi Password</label>
          <input v-model="form.password_confirmation" type="password" class="w-full border rounded px-3 py-2" required />
        </div>

        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700" :disabled="form.processing">
          {{ form.processing ? 'Memproses...' : 'Daftar Admin' }}
        </button>

        <div class="text-center mt-4">
          <a :href="route('admin.login')" class="text-blue-500 hover:underline">
            Sudah punya akun admin? Login
          </a>
        </div>
      </form>
    </div>
  </div>
</template>
