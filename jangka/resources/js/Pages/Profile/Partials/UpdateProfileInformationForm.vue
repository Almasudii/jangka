<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const user = usePage().props.auth.user

const form = useForm({
  name: user.name,
  email: user.email,
  profile_photo: null, // field upload foto
})

const photoPreview = ref(null)

// ✅ Saat user ganti foto, tampilkan preview
function handlePhotoChange(e) {
  const file = e.target.files[0]
  if (!file) return
  form.profile_photo = file
  photoPreview.value = URL.createObjectURL(file)
}

// ✅ Submit perubahan profil
function updateProfile() {
  form.post(route('profile.update'), {
    preserveScroll: true,
    forceFormData: true, // wajib agar file dikirim ke Laravel
    onSuccess: () => {
      if (photoPreview.value) {
        setTimeout(() => {
          photoPreview.value = null
        }, 1000)
      }
    },
  })
}

// ✅ Jika data user berubah dari backend (misal setelah reload)
watch(
  () => usePage().props.auth.user.profile_photo_url,
  (newVal) => {
    if (newVal) {
      photoPreview.value = newVal
    }
  }
)
</script>

<template>
  <section>
    <header>
      <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
        Informasi Profil
      </h2>
      <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
        Ubah informasi profil Anda, termasuk foto profil.
      </p>
    </header>

    <form @submit.prevent="updateProfile" class="mt-6 space-y-6">
      <!-- FOTO PROFIL -->
      <div class="flex flex-col items-center">
        <div class="relative">
          <img
            v-if="photoPreview"
            :src="photoPreview"
            class="w-32 h-32 rounded-full object-cover shadow-md border-4 border-white"
            alt="Preview Foto Profil"
          />
          <img
            v-else
            :src="user.profile_photo_url || '/images/default-profile.png'"
            class="w-32 h-32 rounded-full object-cover shadow-md border-4 border-white"
            alt="Foto Profil"
          />

          <!-- Tombol Upload -->
          <label
            for="photo"
            class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full shadow cursor-pointer hover:bg-blue-700 transition"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-4 h-4"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 11c0-1.104.896-2 2-2s2 .896 2 2v3h-4v-3zM5 11V9a7 7 0 0114 0v2M5 11v6h14v-6"
              />
            </svg>
          </label>
          <input id="photo" type="file" class="hidden" @change="handlePhotoChange" />
        </div>
      </div>

      <!-- NAMA -->
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
          Nama Lengkap
        </label>
        <input
          id="name"
          v-model="form.name"
          type="text"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:text-white"
          autocomplete="name"
        />
      </div>

      <!-- EMAIL -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
          Alamat Email
        </label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:text-white"
          autocomplete="email"
        />
      </div>

      <!-- TOMBOL SIMPAN -->
      <div class="flex items-center gap-4">
        <button
          type="submit"
          class="bg-gradient-to-r from-blue-500 to-blue-700 text-white px-4 py-2 rounded-md font-semibold shadow hover:opacity-90 transition"
        >
          Simpan Perubahan
        </button>

        <span v-if="form.recentlySuccessful" class="text-green-600 text-sm">
          Profil berhasil diperbarui!
        </span>
      </div>
    </form>
  </section>
</template>
