<script setup>
import { computed, ref } from 'vue'
import { Link, router, useForm, usePage } from '@inertiajs/vue3'
import {
  AlertTriangle,
  Crown,
  Edit3,
  Mail,
  Save,
  SearchX,
  ShieldCheck,
  Trash2,
  UserCog,
  UserRound,
  Users,
  X,
} from 'lucide-vue-next'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
  users: {
    type: Object,
    required: true,
  },
})

const page = usePage()
const authUser = computed(() => page.props.auth?.user || {})
const isAdmin = computed(() => authUser.value?.role === 'admin')

const selectedUser = ref(null)

const showRoleModal = ref(false)
const showDeleteModal = ref(false)

const form = useForm({
  name: '',
  email: '',
  desa_id: '',
  role: 'penduduk',
})

const userItems = computed(() => props.users?.data || [])

const totalUsers = computed(() => props.users?.total || userItems.value.length)

const totalAdminOnPage = computed(() => {
  return userItems.value.filter((item) => item.role === 'admin').length
})

const totalPendudukOnPage = computed(() => {
  return userItems.value.filter((item) => item.role === 'penduduk').length
})

function openRoleModal(user) {
  selectedUser.value = user

  form.clearErrors()
  form.transform((data) => data)

  form.name = user.name || ''
  form.email = user.email || ''
  form.desa_id = user.desa_id || ''
  form.role = user.role || 'penduduk'

  showRoleModal.value = true
}

function closeRoleModal() {
  showRoleModal.value = false
  selectedUser.value = null

  form.reset()
  form.clearErrors()
  form.transform((data) => data)
}

function submitRoleUpdate() {
  if (!selectedUser.value) return

  form
    .transform((data) => ({
      name: data.name,
      email: data.email,
      desa_id: data.desa_id || null,
      role: data.role,
      _method: 'put',
    }))
    .post(route('admin.users.update', selectedUser.value.id), {
      preserveScroll: true,
      onSuccess: () => {
        closeRoleModal()
      },
    })
}

function openDeleteModal(user) {
  selectedUser.value = user
  showDeleteModal.value = true
}

function closeDeleteModal() {
  selectedUser.value = null
  showDeleteModal.value = false
}

function deleteUser() {
  if (!selectedUser.value) return

  router.delete(route('admin.users.destroy', selectedUser.value.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeDeleteModal()
    },
  })
}

function profilePhotoUrl(user) {
  if (user.profile_photo_url) {
    return user.profile_photo_url
  }

  if (!user.profile_photo) {
    return null
  }

  if (String(user.profile_photo).startsWith('http')) {
    return user.profile_photo
  }

  if (
    String(user.profile_photo).startsWith('/storage') ||
    String(user.profile_photo).startsWith('/images')
  ) {
    return user.profile_photo
  }

  return `/storage/${user.profile_photo}`
}

function roleLabel(role) {
  if (role === 'admin') return 'Admin'
  if (role === 'penduduk') return 'Penduduk'

  return 'Tidak Diketahui'
}

function roleClass(role) {
  if (role === 'admin') {
    return 'border-blue-200 bg-blue-50 text-blue-700'
  }

  if (role === 'penduduk') {
    return 'border-emerald-200 bg-emerald-50 text-emerald-700'
  }

  return 'border-slate-200 bg-slate-50 text-slate-700'
}

function roleIcon(role) {
  return role === 'admin' ? Crown : UserRound
}

function isCurrentUser(user) {
  return Number(user.id) === Number(authUser.value?.id)
}
</script>

<template>
  <DashboardLayout>
    <div class="min-h-screen bg-slate-50 text-slate-900">
      <div class="mx-auto max-w-7xl px-5 py-8 sm:px-8 lg:px-10">
        <section
          class="relative overflow-hidden rounded-[2rem] border border-white/70 bg-gradient-to-br from-slate-950 via-blue-950 to-blue-700 p-8 text-white shadow-2xl shadow-blue-950/20"
        >
          <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
          <div class="absolute -bottom-24 left-12 h-72 w-72 rounded-full bg-cyan-300/20 blur-3xl"></div>

          <div class="relative flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
            <div>
              <p
                class="mb-3 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-blue-50 ring-1 ring-white/20"
              >
                <ShieldCheck class="h-4 w-4" />
                Manajemen Role Pengguna
              </p>

              <h1 class="max-w-3xl text-3xl font-black tracking-tight sm:text-5xl">
                Pengaturan Admin
              </h1>

              <p class="mt-4 max-w-2xl text-sm leading-6 text-blue-100 sm:text-base">
                Kelola pembagian akses pengguna sebagai admin atau penduduk.
              </p>
            </div>
          </div>
        </section>

        <section class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-3">
          <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-semibold text-slate-500">
                  Total Akun
                </p>
                <p class="mt-3 text-4xl font-black text-slate-950">
                  {{ totalUsers }}
                </p>
              </div>

              <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 ring-1 ring-blue-100">
                <Users class="h-7 w-7" />
              </div>
            </div>

            <p class="mt-3 text-sm text-slate-500">
              Seluruh akun yang terdaftar pada sistem.
            </p>
          </div>

          <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-semibold text-slate-500">
                  Admin di Halaman Ini
                </p>
                <p class="mt-3 text-4xl font-black text-slate-950">
                  {{ totalAdminOnPage }}
                </p>
              </div>

              <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-700 ring-1 ring-indigo-100">
                <Crown class="h-7 w-7" />
              </div>
            </div>

            <p class="mt-3 text-sm text-slate-500">
              Akun dengan akses penuh ke seluruh menu.
            </p>
          </div>

          <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm font-semibold text-slate-500">
                  Penduduk di Halaman Ini
                </p>
                <p class="mt-3 text-4xl font-black text-slate-950">
                  {{ totalPendudukOnPage }}
                </p>
              </div>

              <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100">
                <UserRound class="h-7 w-7" />
              </div>
            </div>

            <p class="mt-3 text-sm text-slate-500">
              Akun penduduk hanya membaca dashboard dan berita.
            </p>
          </div>
        </section>

        <section class="mt-8 rounded-[2rem] border border-slate-200 bg-white shadow-sm">
          <div class="flex flex-col gap-4 border-b border-slate-100 p-7 md:flex-row md:items-center md:justify-between">
            <div>
              <p class="text-sm font-semibold uppercase tracking-wide text-blue-600">
                Daftar Pengguna
              </p>

              <h2 class="mt-2 text-2xl font-black text-slate-950">
                Distribusi Role Akun
              </h2>

              <p class="mt-1 text-sm text-slate-500">
                Ubah hak akses pengguna tanpa mengubah data pribadi akun.
              </p>
            </div>
          </div>

          <div
            v-if="userItems.length === 0"
            class="p-10 text-center"
          >
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-500">
              <SearchX class="h-8 w-8" />
            </div>

            <h3 class="mt-5 text-xl font-black text-slate-900">
              Belum ada pengguna
            </h3>

            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
              Data pengguna belum tersedia.
            </p>
          </div>

          <div
            v-else
            class="overflow-x-auto"
          >
            <table class="min-w-full divide-y divide-slate-100">
              <thead class="bg-slate-50">
                <tr>
                  <th class="px-7 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                    Pengguna
                  </th>

                  <th class="px-7 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                    Email
                  </th>

                  <th class="px-7 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                    Role
                  </th>

                  <th class="px-7 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                    Aksi
                  </th>
                </tr>
              </thead>

              <tbody class="divide-y divide-slate-100 bg-white">
                <tr
                  v-for="item in userItems"
                  :key="item.id"
                  class="transition hover:bg-slate-50"
                  :class="isCurrentUser(item) ? 'bg-blue-50/50' : ''"
                >
                  <td class="px-7 py-5">
                    <div class="flex items-center gap-4">
                      <div class="h-12 w-12 overflow-hidden rounded-2xl bg-slate-100 ring-1 ring-slate-200">
                        <img
                          v-if="profilePhotoUrl(item)"
                          :src="profilePhotoUrl(item)"
                          :alt="item.name"
                          class="h-full w-full object-cover"
                        />

                        <div
                          v-else
                          class="flex h-full w-full items-center justify-center text-slate-500"
                        >
                          <UserRound class="h-6 w-6" />
                        </div>
                      </div>

                      <div>
                        <div class="flex flex-wrap items-center gap-2">
                          <p class="font-black text-slate-950">
                            {{ item.name }}
                          </p>

                          <span
                            v-if="isCurrentUser(item)"
                            class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-bold text-blue-700"
                          >
                            Akun Kamu
                          </span>
                        </div>

                        <p class="mt-1 text-xs font-medium text-slate-400">
                          ID: {{ item.id }}
                        </p>
                      </div>
                    </div>
                  </td>

                  <td class="px-7 py-5">
                    <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                      <Mail class="h-4 w-4 text-slate-400" />
                      {{ item.email }}
                    </div>
                  </td>

                  <td class="px-7 py-5">
                    <span
                      class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-black"
                      :class="roleClass(item.role)"
                    >
                      <component
                        :is="roleIcon(item.role)"
                        class="h-3.5 w-3.5"
                      />
                      {{ roleLabel(item.role) }}
                    </span>
                  </td>

                  <td class="px-7 py-5">
                    <div class="flex justify-end gap-2">
                      <button
                        v-if="isAdmin"
                        type="button"
                        @click="openRoleModal(item)"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-50 px-4 py-2 text-sm font-bold text-amber-700 ring-1 ring-amber-100 transition hover:bg-amber-100"
                      >
                        <Edit3 class="h-4 w-4" />
                        Ubah Role
                      </button>

                      <button
                        v-if="isAdmin"
                        type="button"
                        @click="openDeleteModal(item)"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-rose-50 px-4 py-2 text-sm font-bold text-rose-700 ring-1 ring-rose-100 transition hover:bg-rose-100 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="isCurrentUser(item)"
                      >
                        <Trash2 class="h-4 w-4" />
                        Hapus
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div
            v-if="props.users?.links?.length > 3"
            class="flex flex-wrap items-center justify-center gap-2 border-t border-slate-100 p-6"
          >
            <Link
              v-for="link in props.users.links"
              :key="link.label"
              :href="link.url || '#'"
              v-html="link.label"
              class="rounded-xl border px-4 py-2 text-sm font-semibold transition"
              :class="[
                link.active
                  ? 'border-blue-700 bg-blue-700 text-white shadow-lg shadow-blue-700/20'
                  : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50',
                !link.url ? 'pointer-events-none opacity-50' : ''
              ]"
            />
          </div>
        </section>

        <div
          v-if="showRoleModal && selectedUser"
          class="fixed inset-0 z-[999] flex items-center justify-center bg-slate-950/60 px-4 backdrop-blur-sm"
        >
          <div class="w-full max-w-md rounded-[2rem] bg-white shadow-2xl">
            <div class="flex items-start justify-between border-b border-slate-100 bg-slate-50 p-7 rounded-t-[2rem]">
              <div>
                <p class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-blue-700 ring-1 ring-blue-100">
                  <UserCog class="h-3.5 w-3.5" />
                  Ubah Role
                </p>

                <h2 class="mt-3 text-2xl font-black text-slate-950">
                  {{ selectedUser.name }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                  Pilih role baru untuk akun ini.
                </p>
              </div>

              <button
                type="button"
                @click="closeRoleModal"
                class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-slate-700 shadow-sm transition hover:bg-slate-100"
              >
                <X class="h-5 w-5" />
              </button>
            </div>

            <form
              class="space-y-5 p-7"
              @submit.prevent="submitRoleUpdate"
            >
              <div>
                <label class="mb-2 block text-sm font-bold text-slate-700">
                  Role Pengguna
                </label>

                <select
                  v-model="form.role"
                  class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                >
                  <option value="admin">
                    Admin
                  </option>

                  <option value="penduduk">
                    Penduduk
                  </option>
                </select>

                <p
                  v-if="form.errors.role"
                  class="mt-2 text-sm font-semibold text-rose-600"
                >
                  {{ form.errors.role }}
                </p>
              </div>

              <div
                v-if="isCurrentUser(selectedUser)"
                class="flex gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-amber-800"
              >
                <AlertTriangle class="mt-0.5 h-5 w-5 flex-shrink-0" />

                <p class="text-sm font-semibold leading-6">
                  Kamu sedang mengubah akun sendiri. Sistem mencegah role akun sendiri
                  diubah menjadi penduduk.
                </p>
              </div>

              <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <button
                  type="button"
                  @click="closeRoleModal"
                  class="rounded-xl bg-slate-100 px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-200"
                >
                  Batal
                </button>

                <button
                  type="submit"
                  :disabled="form.processing"
                  class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-blue-700/20 transition hover:bg-blue-800 disabled:opacity-50"
                >
                  <Save class="h-4 w-4" />
                  {{ form.processing ? 'Menyimpan...' : 'Simpan Role' }}
                </button>
              </div>
            </form>
          </div>
        </div>

        <div
          v-if="showDeleteModal && selectedUser"
          class="fixed inset-0 z-[999] flex items-center justify-center bg-slate-950/60 px-4 backdrop-blur-sm"
        >
          <div class="w-full max-w-md rounded-[2rem] bg-white p-7 shadow-2xl">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 ring-1 ring-rose-100">
              <Trash2 class="h-7 w-7" />
            </div>

            <h2 class="mt-5 text-2xl font-black text-slate-950">
              Hapus Akun?
            </h2>

            <p class="mt-3 leading-6 text-slate-600">
              Akun
              <span class="font-bold text-slate-950">
                "{{ selectedUser.name }}"
              </span>
              akan dihapus secara permanen.
            </p>

            <div
              v-if="isCurrentUser(selectedUser)"
              class="mt-5 flex gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-amber-800"
            >
              <AlertTriangle class="mt-0.5 h-5 w-5 flex-shrink-0" />

              <p class="text-sm font-semibold leading-6">
                Kamu tidak bisa menghapus akun yang sedang digunakan.
              </p>
            </div>

            <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:justify-end">
              <button
                type="button"
                @click="closeDeleteModal"
                class="rounded-xl bg-slate-100 px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-200"
              >
                Batal
              </button>

              <button
                type="button"
                @click="deleteUser"
                :disabled="isCurrentUser(selectedUser)"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-rose-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-rose-600/20 transition hover:bg-rose-700 disabled:cursor-not-allowed disabled:opacity-50"
              >
                <Trash2 class="h-4 w-4" />
                Hapus
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>