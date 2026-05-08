<script setup>
import { computed, ref } from 'vue'
import { Link, router, useForm, usePage } from '@inertiajs/vue3'
import {
  AlertTriangle,
  Building2,
  CalendarDays,
  Edit3,
  Landmark,
  Plus,
  Save,
  SearchX,
  Trash2,
  X,
} from 'lucide-vue-next'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
  fasilitas: {
    type: Object,
    required: true,
  },
})

const page = usePage()
const user = computed(() => page.props.auth?.user || {})
const isAdmin = computed(() => user.value?.role === 'admin')

const selectedFasilitas = ref(null)

const showFormModal = ref(false)
const showDeleteModal = ref(false)

const isEditing = ref(false)

const form = useForm({
  thumbnail: null,
  deskripsi: '',
})

const fasilitasItems = computed(() => props.fasilitas?.data || [])

function openCreateModal() {
  isEditing.value = false
  selectedFasilitas.value = null

  form.reset()
  form.clearErrors()
  form.transform((data) => data)

  showFormModal.value = true
}

function openEditModal(item) {
  isEditing.value = true
  selectedFasilitas.value = item

  form.clearErrors()
  form.transform((data) => data)

  form.thumbnail = null
  form.deskripsi = item.deskripsi || ''

  showFormModal.value = true
}

function closeFormModal() {
  showFormModal.value = false
  selectedFasilitas.value = null

  form.reset()
  form.clearErrors()
  form.transform((data) => data)
}

function openDeleteModal(item) {
  selectedFasilitas.value = item
  showDeleteModal.value = true
}

function closeDeleteModal() {
  selectedFasilitas.value = null
  showDeleteModal.value = false
}

function handleThumbnailChange(event) {
  form.thumbnail = event.target.files[0] || null
}

function submitForm() {
  if (isEditing.value && selectedFasilitas.value) {
    form
      .transform((data) => ({
        ...data,
        _method: 'put',
      }))
      .post(route('fasilitas-desa.update', selectedFasilitas.value.id), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
          closeFormModal()
        },
      })

    return
  }

  form
    .transform((data) => data)
    .post(route('fasilitas-desa.store'), {
      forceFormData: true,
      preserveScroll: true,
      onSuccess: () => {
        closeFormModal()
      },
    })
}

function deleteFasilitas() {
  if (!selectedFasilitas.value) return

  router.delete(route('fasilitas-desa.destroy', selectedFasilitas.value.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeDeleteModal()
    },
  })
}

function thumbnailUrl(path) {
  if (!path) return null

  if (String(path).startsWith('http')) {
    return path
  }

  if (String(path).startsWith('/storage')) {
    return path
  }

  return `/storage/${path}`
}

function formatDate(date) {
  if (!date) return '-'

  return new Intl.DateTimeFormat('id-ID', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
  }).format(new Date(date))
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
                <Landmark class="h-4 w-4" />
                Fasilitas Umum Desa
              </p>

              <h1 class="max-w-3xl text-3xl font-black tracking-tight sm:text-5xl">
                Fasilitas Desa
              </h1>

              <p class="mt-4 max-w-2xl text-sm leading-6 text-blue-100 sm:text-base">
                Informasi fasilitas umum yang tersedia untuk menunjang kebutuhan,
                pelayanan, dan kegiatan masyarakat desa.
              </p>
            </div>

            <button
              v-if="isAdmin"
              type="button"
              @click="openCreateModal"
              class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-bold text-blue-800 shadow-lg shadow-blue-950/20 transition hover:bg-blue-50"
            >
              <Plus class="h-4 w-4" />
              Tambah Fasilitas
            </button>
          </div>
        </section>

        <section class="mt-8">
          <div
            v-if="fasilitasItems.length === 0"
            class="rounded-[2rem] border border-slate-200 bg-white p-10 text-center shadow-sm"
          >
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-500">
              <SearchX class="h-8 w-8" />
            </div>

            <h2 class="mt-5 text-xl font-black text-slate-900">
              Belum ada fasilitas
            </h2>

            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
              Data fasilitas desa belum tersedia.
              <span v-if="isAdmin">
                Admin dapat menambahkan fasilitas baru melalui tombol tambah fasilitas.
              </span>
            </p>
          </div>

          <div
            v-else
            class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4"
          >
            <article
              v-for="item in fasilitasItems"
              :key="item.id"
              class="group overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-950/10"
            >
              <div class="relative h-52 w-full overflow-hidden bg-slate-100">
                <img
                  v-if="thumbnailUrl(item.thumbnail)"
                  :src="thumbnailUrl(item.thumbnail)"
                  alt="Thumbnail fasilitas desa"
                  class="h-full w-full object-cover transition duration-500 group-hover:scale-110"
                />

                <div
                  v-else
                  class="flex h-full w-full items-center justify-center bg-gradient-to-br from-amber-50 via-orange-50 to-slate-100 p-6"
                >
                  <div class="text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-100 text-amber-700 ring-1 ring-amber-200">
                      <AlertTriangle class="h-8 w-8" />
                    </div>

                    <p class="mt-4 text-sm font-black uppercase tracking-wide text-amber-700">
                      Thumbnail Tidak Ada
                    </p>

                    <p class="mt-1 text-xs text-amber-600">
                      Gambar fasilitas belum diunggah
                    </p>
                  </div>
                </div>
              </div>

              <div class="p-6">
                <div class="mb-4 flex items-center gap-2 text-sm text-slate-500">
                  <CalendarDays class="h-4 w-4" />
                  {{ formatDate(item.created_at) }}
                </div>

                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-700 ring-1 ring-blue-100">
                  <Building2 class="h-6 w-6" />
                </div>

                <h2 class="text-xl font-black leading-snug text-slate-950">
                  Fasilitas Desa
                </h2>

                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600">
                  {{ item.deskripsi }}
                </p>

                <div
                  v-if="isAdmin"
                  class="mt-5 grid grid-cols-2 gap-2 border-t border-slate-100 pt-5"
                >
                  <button
                    type="button"
                    @click="openEditModal(item)"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-50 px-4 py-2 text-sm font-bold text-amber-700 ring-1 ring-amber-100 transition hover:bg-amber-100"
                  >
                    <Edit3 class="h-4 w-4" />
                    Edit
                  </button>

                  <button
                    type="button"
                    @click="openDeleteModal(item)"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-rose-50 px-4 py-2 text-sm font-bold text-rose-700 ring-1 ring-rose-100 transition hover:bg-rose-100"
                  >
                    <Trash2 class="h-4 w-4" />
                    Hapus
                  </button>
                </div>
              </div>
            </article>
          </div>

          <div
            v-if="props.fasilitas?.links?.length > 3"
            class="mt-8 flex flex-wrap items-center justify-center gap-2"
          >
            <Link
              v-for="link in props.fasilitas.links"
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
          v-if="showFormModal"
          class="fixed inset-0 z-[999] flex items-center justify-center bg-slate-950/60 px-4 backdrop-blur-sm"
        >
          <div class="w-full max-w-3xl overflow-hidden rounded-[2rem] bg-white shadow-2xl">
            <div class="max-h-[90vh] overflow-y-auto">
              <div class="flex items-start justify-between border-b border-slate-100 bg-slate-50 p-7">
                <div>
                  <p class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-blue-700 ring-1 ring-blue-100">
                    <Building2 class="h-3.5 w-3.5" />
                    Form Fasilitas
                  </p>

                  <h2 class="mt-3 text-2xl font-black text-slate-950">
                    {{ isEditing ? 'Edit Fasilitas Desa' : 'Tambah Fasilitas Desa' }}
                  </h2>

                  <p class="mt-1 text-sm text-slate-500">
                    Isi deskripsi dan unggah gambar fasilitas jika tersedia.
                  </p>
                </div>

                <button
                  type="button"
                  @click="closeFormModal"
                  class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-slate-700 shadow-sm transition hover:bg-slate-100"
                >
                  <X class="h-5 w-5" />
                </button>
              </div>

              <form
                class="space-y-5 p-7"
                @submit.prevent="submitForm"
              >
                <div>
                  <label class="mb-2 block text-sm font-bold text-slate-700">
                    Deskripsi Fasilitas
                  </label>

                  <textarea
                    v-model="form.deskripsi"
                    rows="8"
                    class="w-full resize-none rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    placeholder="Tulis deskripsi fasilitas desa"
                  ></textarea>

                  <p
                    v-if="form.errors.deskripsi"
                    class="mt-2 text-sm font-semibold text-rose-600"
                  >
                    {{ form.errors.deskripsi }}
                  </p>
                </div>

                <div>
                  <label class="mb-2 block text-sm font-bold text-slate-700">
                    Thumbnail
                  </label>

                  <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-5">
                    <input
                      type="file"
                      accept="image/*"
                      class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700"
                      @change="handleThumbnailChange"
                    />

                    <p class="mt-2 text-xs font-medium text-slate-500">
                      Format: jpg, jpeg, png, webp. Maksimal 2MB.
                    </p>
                  </div>

                  <p
                    v-if="form.errors.thumbnail"
                    class="mt-2 text-sm font-semibold text-rose-600"
                  >
                    {{ form.errors.thumbnail }}
                  </p>
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                  <button
                    type="button"
                    @click="closeFormModal"
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
                    {{ form.processing ? 'Menyimpan...' : isEditing ? 'Update Fasilitas' : 'Simpan Fasilitas' }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div
          v-if="showDeleteModal && selectedFasilitas"
          class="fixed inset-0 z-[999] flex items-center justify-center bg-slate-950/60 px-4 backdrop-blur-sm"
        >
          <div class="w-full max-w-md rounded-[2rem] bg-white p-7 shadow-2xl">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 ring-1 ring-rose-100">
              <Trash2 class="h-7 w-7" />
            </div>

            <h2 class="mt-5 text-2xl font-black text-slate-950">
              Hapus Fasilitas?
            </h2>

            <p class="mt-3 leading-6 text-slate-600">
              Data fasilitas ini akan dihapus secara permanen.
            </p>

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
                @click="deleteFasilitas"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-rose-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-rose-600/20 transition hover:bg-rose-700"
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