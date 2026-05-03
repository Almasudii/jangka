<script setup>
import { ref, computed, watch } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'

const dropdownOpen = ref(false)
const page = usePage()

// Ambil user secara reaktif dari Inertia props
const user = computed(() => page.props.auth?.user || {})

// Ambil role user, dibuat lowercase supaya aman dari Admin/admin/Penduduk/penduduk
const userRole = computed(() => {
  return String(user.value?.role || '').toLowerCase()
})

// Foto profil dinamis
const profilePhotoUrl = computed(() => {
  return user.value?.profile_photo_url || '/images/default-profile.png'
})

// Semua menu sidebar
const allMenus = [
  {
    label: 'Dashboard',
    href: '/dashboard',
  },
  {
    label: 'Berita',
    href: '/berita',
  },
  {
    label: 'Layanan',
    href: '/layanan',
  },
  {
    label: 'Peta Desa',
    href: '/peta-desa',
  },
  {
    label: 'Profil Desa',
    href: '/profil-desa',
  },
  {
    label: 'Fasilitas Desa',
    href: '/fasilitas-desa',
  },
]

// Menu berdasarkan role
const sidebarMenus = computed(() => {
  // Jika penduduk, hanya tampilkan Dashboard dan Berita
  if (userRole.value === 'penduduk') {
    return allMenus.filter((menu) =>
      ['/dashboard', '/berita'].includes(menu.href)
    )
  }

  // Jika admin, tampilkan semua menu
  if (userRole.value === 'admin') {
    return allMenus
  }

  // Fallback jika role belum terbaca
  return allMenus.filter((menu) =>
    ['/dashboard', '/berita'].includes(menu.href)
  )
})

// Cek menu aktif
function isActiveMenu(href) {
  return page.url === href || page.url.startsWith(`${href}/`)
}

// Toggle dropdown
function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
}

// Logout user
function logout() {
  router.post(route('logout'), {
    onFinish: () => {
      window.location.href = '/login'
    },
  })
}

// Dark Mode otomatis sesuai pengaturan user
const isDarkMode = computed(() => {
  return user.value?.settings?.dark_mode ?? false
})

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
            v-for="menu in sidebarMenus"
            :key="menu.href"
            :href="menu.href"
            class="block px-5 py-3 transition rounded-md"
            :class="isActiveMenu(menu.href) ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-700'"
          >
            {{ menu.label }}
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
            <img
              :src="profilePhotoUrl"
              alt="Profile"
              class="object-cover w-8 h-8 border rounded-full"
            />

            <span class="capitalize">
              {{ user.name }}
            </span>

            <svg
              class="w-4 h-4"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M19 9l-7 7-7-7"
              />
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