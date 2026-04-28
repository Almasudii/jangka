<script setup>
import { ref, watch, computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'

const dropdownOpen = ref(false)
const page = usePage()
const user = page.props.auth.user

// ✅ Foto profil dinamis
const profilePhotoUrl = ref(user.profile_photo_url || '/images/default-profile.png')

// 🔄 Pantau perubahan foto profil dari backend (setelah update profil)
watch(
  () => usePage().props.auth.user.profile_photo_url,
  (newVal) => {
    if (newVal) profilePhotoUrl.value = newVal
  }
)

// ✅ Toggle dropdown
function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
}

// ✅ Logout user
function logout() {
  Inertia.post('/logout')
}

// 🌙 Dark Mode otomatis sesuai pengaturan user
const isDarkMode = computed(() => page.props.auth.user?.settings?.dark_mode ?? false)
watch(
  isDarkMode,
  (val) => {
    document.documentElement.classList.toggle('dark', val)
  },
  { immediate: true }
)
</script>

<template>
  <div
    class="flex min-h-screen transition-colors duration-300 bg-gray-100 dark:bg-gray-900 dark:text-gray-100"
  >
    <!-- Sidebar -->
    <aside class="flex flex-col justify-between w-64 text-white bg-blue-800 shadow-lg">
      <div>
        <!-- Logo dan Judul -->
        <div class="flex flex-col items-center p-6 border-b border-blue-700">
          <img
            src="/images/logoKabupatenSampang.png"
            alt="Logo Smart Village"
            class="object-contain w-20 mb-2 h-50"
          />
          <h1 class="text-lg font-bold">Smart Village</h1>
          <p class="text-xs text-gray-400">Kabupaten Sampang</p>
        </div>

        <!-- Menu Navigasi -->
        <nav class="mt-4 space-y-1">
          <Link
            href="/dashboard"
            class="block px-5 py-3 transition rounded-md"
            :class="page.url === '/dashboard' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-700'"
          >
            Dashboard
          </Link>

          <Link
            href="/berita"
            class="block px-5 py-3 transition rounded-md"
            :class="page.url === '/berita' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-700'"
          >
            Berita
          </Link>

          <Link
            href="/layanan"
            class="block px-5 py-3 transition rounded-md"
            :class="page.url === '/layanan' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-700'"
          >
            Layanan
          </Link>

          <Link
            href="/peta-desa"
            class="block px-5 py-3 transition rounded-md"
            :class="page.url === '/peta-desa' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-700'"
          >
            Peta Desa
          </Link>

          <!-- 🔹 Tambahan Profil Desa -->
          <Link
            href="/profil-desa"
            class="block px-5 py-3 transition rounded-md"
            :class="page.url === '/profil-desa' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-700'"
          >
            Profil Desa
          </Link>
          <Link
              href="/fasilitas-desa"
                 class="block px-5 py-3 transition rounded-md"
                 :class="page.url === '/fasilitas-desa' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-700'"
>
         Fasilitas Desa
        </Link>

        </nav>
      </div>

      <!-- Footer Sidebar -->
      <div class="p-4 text-xs text-center text-gray-400 border-t border-gray-700">
        &copy; 2025 Smart Village
      </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex flex-col flex-1">
      <!-- Header -->
      <header
        class="sticky top-0 z-50 flex items-center justify-between p-4 transition-colors bg-white shadow-md dark:bg-gray-800"
      >
        <!-- Judul -->
        <div class="flex items-center space-x-3">
          <h2 class="text-xl font-bold text-gray-800 capitalize dark:text-gray-100">
            {{ page.component }}
          </h2>
        </div>

        <!-- Profil + Dropdown -->
        <div class="relative">
          <button
            @click="toggleDropdown"
            class="flex items-center px-3 py-2 space-x-2 text-gray-700 transition bg-gray-100 rounded-md shadow-sm dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-gray-100"
          >
            <!-- ✅ Foto profil dinamis -->
            <img
              :src="profilePhotoUrl"
              alt="Profile"
              class="object-cover w-8 h-8 border rounded-full"
            />
            <span class="capitalize">{{ user.name }}</span>
            <svg
              class="w-4 h-4"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- Dropdown -->
          <transition name="fade">
            <div
              v-if="dropdownOpen"
              class="absolute right-0 z-50 w-48 mt-2 bg-white border border-gray-200 rounded-md shadow-lg dark:bg-gray-800 dark:border-gray-700"
            >
              <Link
                href="/profile"
                class="block px-4 py-2 text-gray-700 transition dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700"
              >
                Edit Profil
              </Link>
              <Link
                href="/settings"
                class="block px-4 py-2 text-gray-700 transition dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700"
              >
                Pengaturan
              </Link>
              <button
                @click="logout"
                class="block w-full px-4 py-2 text-left text-gray-700 transition dark:text-gray-100 hover:bg-red-100 dark:hover:bg-red-700 hover:text-red-600"
              >
                Logout
              </button>
            </div>
          </transition>
        </div>
      </header>

      <!-- Isi Halaman -->
      <div class="flex-1 p-6 overflow-y-auto">
        <slot />
      </div>
    </main>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

