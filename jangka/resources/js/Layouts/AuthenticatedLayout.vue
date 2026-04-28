<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'

const showingNavigationDropdown = ref(false)
</script>

<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
      <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <!-- Logo -->
            <div class="flex items-center shrink-0">
              <Link :href="route('dashboard')">
                <ApplicationLogo class="block w-auto text-gray-800 fill-current h-9 dark:text-gray-200" />
              </Link>
            </div>

            <!-- Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
              <NavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</NavLink>
              <NavLink :href="route('profile.edit')" :active="route().current('profile.edit')">Profil</NavLink>
              <NavLink :href="route('settings')" :active="route().current('settings')">Pengaturan</NavLink>
            </div>
          </div>

          <!-- User Menu -->
          <div class="hidden sm:flex sm:items-center sm:ms-6">
            <Dropdown align="right" width="48">
              <template #trigger>
                <button
                  class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition bg-white rounded-md dark:bg-gray-800 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                >
                  {{ $page.props.auth.user.name }}
                  <svg class="w-4 h-4 ms-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5.25 7.75l4.5 4.5 4.5-4.5" />
                  </svg>
                </button>
              </template>

              <template #content>
                <DropdownLink :href="route('profile.edit')">Profil</DropdownLink>
                <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
              </template>
            </Dropdown>
          </div>

          <!-- Mobile -->
          <div class="flex items-center -me-2 sm:hidden">
            <button
              @click="showingNavigationDropdown = !showingNavigationDropdown"
              class="inline-flex items-center justify-center p-2 text-gray-400 transition rounded-md hover:bg-gray-100 hover:text-gray-500 dark:hover:bg-gray-900 dark:text-gray-500"
            >
              <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path v-if="!showingNavigationDropdown" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
                <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div v-show="showingNavigationDropdown" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
          <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</ResponsiveNavLink>
          <ResponsiveNavLink :href="route('profile.edit')" :active="route().current('profile.edit')">Profil</ResponsiveNavLink>
          <ResponsiveNavLink :href="route('settings')" :active="route().current('settings')">Pengaturan</ResponsiveNavLink>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
          <div class="px-4">
            <div class="text-base font-medium text-gray-800 dark:text-gray-100">
              {{ $page.props.auth.user.name }}
            </div>
            <div class="text-sm font-medium text-gray-500">{{ $page.props.auth.user.email }}</div>
          </div>

          <div class="mt-3 space-y-1">
            <ResponsiveNavLink :href="route('profile.edit')">Profil</ResponsiveNavLink>
            <ResponsiveNavLink :href="route('logout')" method="post" as="button">Log Out</ResponsiveNavLink>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main -->
    <main>
      <slot />
    </main>
  </div>
</template>
