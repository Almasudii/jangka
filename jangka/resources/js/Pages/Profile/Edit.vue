<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import DeleteUserForm from './Partials/DeleteUserForm.vue'
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue'
import { Head } from '@inertiajs/vue3'

// Props dari controller
defineProps({
  mustVerifyEmail: Boolean,
  status: String,
  user: Object,
})

// Gunakan layout dashboard utama
defineOptions({ layout: DashboardLayout })
</script>

<template>
  <Head title="Profil Saya" />

  <div class="space-y-10">
    <!-- 🔷 Header Profil -->
    <div
      class="flex items-center gap-4 p-6 text-white shadow-md bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl"
    >
      <img
        :src="user?.profile_photo_url || '/images/default-profile.png'"
        alt="Foto Profil"
        class="w-16 h-16 border-4 border-white rounded-full shadow-md"
      />
      <div>
        <h2 class="text-2xl font-bold tracking-wide">Profil Pengguna</h2>
        <p class="text-sm text-blue-100">
          Kelola data akun, keamanan, dan pengaturan Anda.
        </p>
      </div>
    </div>

    <!-- 🔶 Konten Profil -->
    <div class="grid gap-8 md:grid-cols-2">
      <!-- ✅ Informasi Profil -->
      <div
        class="p-6 transition duration-300 bg-white border border-gray-100 shadow-lg rounded-2xl hover:shadow-xl dark:bg-gray-800 dark:border-gray-700"
      >
        <h3
          class="flex items-center gap-2 pb-2 mb-4 text-lg font-semibold text-gray-800 border-b dark:text-gray-100"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 text-blue-500"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5.121 17.804A7 7 0 0112 15a7 7 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"
            />
          </svg>
          Informasi Profil
        </h3>

        <UpdateProfileInformationForm
          :must-verify-email="mustVerifyEmail"
          :status="status"
          class="max-w-xl"
        />
      </div>

      <!-- ✅ Ubah Password -->
      <div
        class="p-6 transition duration-300 bg-white border border-gray-100 shadow-lg rounded-2xl hover:shadow-xl dark:bg-gray-800 dark:border-gray-700"
      >
        <h3
          class="flex items-center gap-2 pb-2 mb-4 text-lg font-semibold text-gray-800 border-b dark:text-gray-100"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 text-indigo-500"
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
          Ubah Password
        </h3>

        <UpdatePasswordForm class="max-w-xl" />
      </div>

      <!-- ✅ Hapus Akun -->
      <div
        class="col-span-2 p-6 transition duration-300 bg-white border border-gray-100 shadow-lg rounded-2xl hover:shadow-xl dark:bg-gray-800 dark:border-gray-700"
      >
        <h3
          class="flex items-center gap-2 pb-2 mb-4 text-lg font-semibold text-gray-800 border-b dark:text-gray-100"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 text-red-500"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"
            />
          </svg>
          Hapus Akun
        </h3>

        <DeleteUserForm class="max-w-xl" />
      </div>
    </div>
  </div>
</template>
