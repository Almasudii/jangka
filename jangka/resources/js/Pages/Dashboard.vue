<script setup>
import { computed, onMounted, ref } from 'vue'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const props = defineProps({
  desa: String
})

const jumlahBerita = 10
const jumlahLayanan = 5

const loading = ref(true)
const errorMessage = ref('')
const rows2024 = ref([])
const rows2023 = ref([])
const lastUpdate = ref('-')

const BPS_URL_2024 =
  'https://webapi.bps.go.id/v1/api/list/model/data/lang/ind/domain/3527/var/134/th/124/key/f22b9582d1bfbdb79302dbdf08189939'

const BPS_URL_2023 =
  'https://webapi.bps.go.id/v1/api/list/model/data/lang/ind/domain/3527/var/134/th/123/key/f22b9582d1bfbdb79302dbdf08189939'

const currentDesaName = computed(() => props.desa || 'Tidak Diketahui')

function normalizeName(value) {
  return String(value || '')
    .toLowerCase()
    .replace(/desa|kelurahan|kecamatan|kabupaten|kab\.|kec\.|sampang|jawa timur/g, '')
    .replace(/[^\w\s]/g, '')
    .replace(/\s+/g, ' ')
    .trim()
}

function formatNumber(value) {
  return new Intl.NumberFormat('id-ID').format(Number(value || 0))
}

function formatPercent(value) {
  if (!Number.isFinite(value)) return '0%'
  return `${value > 0 ? '+' : ''}${value.toFixed(2)}%`
}

function formatSignedNumber(value) {
  const number = Number(value || 0)
  return `${number > 0 ? '+' : ''}${formatNumber(number)}`
}

function extractPopulationRows(payload) {
  const vervar = payload?.vervar || []
  const datacontent = payload?.datacontent || {}

  const varCode = String(payload?.var?.[0]?.val ?? '134')
  const turvarCode = String(payload?.turvar?.[0]?.val ?? '0')
  const tahunCode = String(payload?.tahun?.[0]?.val ?? '')
  const turtahunCode = String(payload?.turtahun?.[0]?.val ?? '0')

  return vervar.map((item) => {
    const key = `${item.val}${varCode}${turvarCode}${tahunCode}${turtahunCode}`

    return {
      id: item.val,
      nama: item.label,
      key,
      penduduk: Number(datacontent[key] || 0)
    }
  })
}

async function fetchBpsData(url) {
  const response = await fetch(url)

  if (!response.ok) {
    throw new Error('Gagal mengambil data dari BPS')
  }

  const payload = await response.json()

  if (payload.status !== 'OK') {
    throw new Error('Data BPS tidak tersedia')
  }

  return payload
}

async function loadPopulationData() {
  loading.value = true
  errorMessage.value = ''

  try {
    const [data2024, data2023] = await Promise.all([
      fetchBpsData(BPS_URL_2024),
      fetchBpsData(BPS_URL_2023)
    ])

    rows2024.value = extractPopulationRows(data2024)
    rows2023.value = extractPopulationRows(data2023)
    lastUpdate.value = data2024.last_update || '-'
  } catch (error) {
    errorMessage.value =
      error?.message || 'Terjadi kesalahan saat memuat data penduduk.'
  } finally {
    loading.value = false
  }
}

const populationRows = computed(() => {
  const data2023Map = new Map(
    rows2023.value.map((item) => [item.id, item.penduduk])
  )

  return rows2024.value.map((item) => {
    const penduduk2023 = data2023Map.get(item.id) || 0
    const perubahan = item.penduduk - penduduk2023
    const persentase =
      penduduk2023 > 0 ? (perubahan / penduduk2023) * 100 : 0

    return {
      ...item,
      penduduk2024: item.penduduk,
      penduduk2023,
      perubahan,
      persentase,
      isCurrentDesa:
        normalizeName(item.nama) === normalizeName(currentDesaName.value)
    }
  })
})

const sortedRows = computed(() => {
  return [...populationRows.value].sort(
    (a, b) => b.penduduk2024 - a.penduduk2024
  )
})

const selectedDesa = computed(() => {
  return (
    populationRows.value.find((item) => item.isCurrentDesa) ||
    populationRows.value[0] ||
    null
  )
})

const selectedDesaRank = computed(() => {
  if (!selectedDesa.value) return '-'

  const index = sortedRows.value.findIndex(
    (item) => item.id === selectedDesa.value.id
  )

  return index >= 0 ? index + 1 : '-'
})

const totalPenduduk2024 = computed(() => {
  return populationRows.value.reduce(
    (total, item) => total + item.penduduk2024,
    0
  )
})

const totalPenduduk2023 = computed(() => {
  return populationRows.value.reduce(
    (total, item) => total + item.penduduk2023,
    0
  )
})

const perubahanTotal = computed(() => {
  return totalPenduduk2024.value - totalPenduduk2023.value
})

const persentaseTotal = computed(() => {
  if (totalPenduduk2023.value <= 0) return 0
  return (perubahanTotal.value / totalPenduduk2023.value) * 100
})

const rataRataPenduduk = computed(() => {
  if (populationRows.value.length === 0) return 0
  return Math.round(totalPenduduk2024.value / populationRows.value.length)
})

const desaTerpadat = computed(() => sortedRows.value[0] || null)

const maxPenduduk = computed(() => {
  return Math.max(...populationRows.value.map((item) => item.penduduk2024), 1)
})

const chartRows = computed(() => sortedRows.value.slice(0, 10))

const selectedShare = computed(() => {
  if (!selectedDesa.value || totalPenduduk2024.value <= 0) return 0
  return (selectedDesa.value.penduduk2024 / totalPenduduk2024.value) * 100
})

const trendTone = computed(() => {
  const value = selectedDesa.value?.perubahan || 0

  if (value > 0) {
    return {
      text: 'Naik',
      className: 'bg-emerald-50 text-emerald-700 ring-emerald-200'
    }
  }

  if (value < 0) {
    return {
      text: 'Turun',
      className: 'bg-rose-50 text-rose-700 ring-rose-200'
    }
  }

  return {
    text: 'Stabil',
    className: 'bg-slate-50 text-slate-700 ring-slate-200'
  }
})

onMounted(() => {
  loadPopulationData()
})
</script>

<template>
  <DashboardLayout>
    <div class="min-h-screen bg-slate-50 text-slate-900">
      <div class="mx-auto max-w-7xl px-5 py-8 sm:px-8 lg:px-10">
        <!-- Header -->
        <section
          class="relative overflow-hidden rounded-[2rem] border border-white/70 bg-gradient-to-br from-slate-950 via-blue-950 to-blue-700 p-8 text-white shadow-2xl shadow-blue-950/20"
        >
          <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
          <div class="absolute -bottom-24 left-12 h-72 w-72 rounded-full bg-cyan-300/20 blur-3xl"></div>

          <div class="relative flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
            <div>
              <p class="mb-3 inline-flex rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-blue-50 ring-1 ring-white/20">
                Dashboard Statistik Desa
              </p>

              <h1 class="max-w-3xl text-3xl font-black tracking-tight sm:text-5xl">
                Selamat Datang di Desa
                <span class="text-cyan-200">{{ currentDesaName }}</span>
              </h1>

              <p class="mt-4 max-w-2xl text-sm leading-6 text-blue-100 sm:text-base">
                Ringkasan data kependudukan, layanan, dan informasi publik
                berbasis data BPS Kecamatan Sampang.
              </p>
            </div>

            <div class="rounded-2xl bg-white/10 p-5 ring-1 ring-white/15 backdrop-blur">
              <p class="text-sm text-blue-100">Pembaruan data BPS</p>
              <p class="mt-1 text-xl font-bold">{{ lastUpdate }}</p>
            </div>
          </div>
        </section>

        <!-- Loading -->
        <div
          v-if="loading"
          class="mt-8 rounded-3xl border border-slate-200 bg-white p-8 text-center shadow-sm"
        >
          <p class="text-sm font-semibold text-slate-500">
            Memuat data penduduk dari BPS...
          </p>
        </div>

        <!-- Error -->
        <div
          v-else-if="errorMessage"
          class="mt-8 rounded-3xl border border-rose-200 bg-rose-50 p-8 text-center text-rose-700"
        >
          <p class="font-semibold">{{ errorMessage }}</p>
          <p class="mt-2 text-sm">
            Jika fetch terkena CORS, ambil data BPS melalui backend Laravel lalu
            kirimkan ke Vue sebagai API internal.
          </p>
        </div>

        <template v-else>
          <!-- Main Stats -->
          <section class="mt-8 grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
              <p class="text-sm font-semibold text-slate-500">Penduduk Desa 2024</p>
              <p class="mt-3 text-4xl font-black text-slate-950">
                {{ formatNumber(selectedDesa?.penduduk2024) }}
              </p>
              <p class="mt-2 text-sm text-slate-500">
                {{ selectedDesa?.nama || currentDesaName }}
              </p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
              <p class="text-sm font-semibold text-slate-500">Perubahan 2023-2024</p>
              <div class="mt-3 flex items-end gap-3">
                <p class="text-4xl font-black text-slate-950">
                  {{ formatSignedNumber(selectedDesa?.perubahan) }}
                </p>
                <span
                  class="mb-1 rounded-full px-3 py-1 text-xs font-bold ring-1"
                  :class="trendTone.className"
                >
                  {{ trendTone.text }}
                </span>
              </div>
              <p class="mt-2 text-sm text-slate-500">
                {{ formatPercent(selectedDesa?.persentase) }} dibanding 2023
              </p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
              <p class="text-sm font-semibold text-slate-500">Total Kecamatan</p>
              <p class="mt-3 text-4xl font-black text-slate-950">
                {{ formatNumber(totalPenduduk2024) }}
              </p>
              <p class="mt-2 text-sm text-slate-500">
                {{ formatPercent(persentaseTotal) }} dari tahun 2023
              </p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
              <p class="text-sm font-semibold text-slate-500">Jumlah Berita</p>
              <p class="mt-3 text-4xl font-black text-slate-950">
                {{ formatNumber(jumlahBerita) }}
              </p>
              <p class="mt-2 text-sm text-slate-500">
                Informasi publik tersedia
              </p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
              <p class="text-sm font-semibold text-slate-500">Jumlah Layanan</p>
              <p class="mt-3 text-4xl font-black text-slate-950">
                {{ formatNumber(jumlahLayanan) }}
              </p>
              <p class="mt-2 text-sm text-slate-500">
                Layanan administrasi desa
              </p>
            </div>
          </section>

          <!-- Insight + Chart -->
          <section class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-3">
            <!-- Selected Village Insight -->
            <div class="rounded-3xl border border-slate-200 bg-white p-7 shadow-sm xl:col-span-1">
              <div class="flex items-start justify-between gap-4">
                <div>
                  <p class="text-sm font-semibold uppercase tracking-wide text-blue-600">
                    Fokus Desa
                  </p>
                  <h2 class="mt-2 text-2xl font-black text-slate-950">
                    {{ selectedDesa?.nama || currentDesaName }}
                  </h2>
                </div>

                <div class="rounded-2xl bg-blue-50 px-4 py-3 text-center ring-1 ring-blue-100">
                  <p class="text-xs font-semibold text-blue-600">Ranking</p>
                  <p class="text-2xl font-black text-blue-700">
                    {{ selectedDesaRank }}
                  </p>
                </div>
              </div>

              <div class="mt-8 space-y-5">
                <div>
                  <div class="flex justify-between text-sm">
                    <span class="font-semibold text-slate-600">
                      Kontribusi terhadap total kecamatan
                    </span>
                    <span class="font-bold text-slate-900">
                      {{ selectedShare.toFixed(2) }}%
                    </span>
                  </div>

                  <div class="mt-3 h-3 overflow-hidden rounded-full bg-slate-100">
                    <div
                      class="h-full rounded-full bg-blue-600"
                      :style="{ width: `${Math.min(selectedShare, 100)}%` }"
                    ></div>
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-100">
                    <p class="text-xs font-semibold text-slate-500">Penduduk 2023</p>
                    <p class="mt-2 text-2xl font-black">
                      {{ formatNumber(selectedDesa?.penduduk2023) }}
                    </p>
                  </div>

                  <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-100">
                    <p class="text-xs font-semibold text-slate-500">Penduduk 2024</p>
                    <p class="mt-2 text-2xl font-black">
                      {{ formatNumber(selectedDesa?.penduduk2024) }}
                    </p>
                  </div>
                </div>

                <div class="rounded-2xl bg-gradient-to-br from-slate-950 to-slate-800 p-5 text-white">
                  <p class="text-sm text-slate-300">Rata-rata penduduk desa/kelurahan</p>
                  <p class="mt-2 text-3xl font-black">
                    {{ formatNumber(rataRataPenduduk) }}
                  </p>
                  <p class="mt-2 text-sm text-slate-300">
                    Desa terpadat: {{ desaTerpadat?.nama }} dengan
                    {{ formatNumber(desaTerpadat?.penduduk2024) }} jiwa.
                  </p>
                </div>
              </div>
            </div>

            <!-- Chart -->
            <div class="rounded-3xl border border-slate-200 bg-white p-7 shadow-sm xl:col-span-2">
              <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                  <p class="text-sm font-semibold uppercase tracking-wide text-blue-600">
                    Distribusi Penduduk
                  </p>
                  <h2 class="mt-2 text-2xl font-black text-slate-950">
                    Top 10 Desa/Kelurahan Tahun 2024
                  </h2>
                </div>
                <p class="text-sm text-slate-500">
                  Satuan: jiwa
                </p>
              </div>

              <div class="mt-7 space-y-4">
                <div
                  v-for="item in chartRows"
                  :key="item.id"
                  class="grid grid-cols-12 items-center gap-3"
                >
                  <div class="col-span-4 truncate text-sm font-semibold text-slate-700 sm:col-span-3">
                    {{ item.nama }}
                  </div>

                  <div class="col-span-6 h-4 overflow-hidden rounded-full bg-slate-100 sm:col-span-7">
                    <div
                      class="h-full rounded-full"
                      :class="item.isCurrentDesa ? 'bg-blue-600' : 'bg-slate-400'"
                      :style="{ width: `${(item.penduduk2024 / maxPenduduk) * 100}%` }"
                    ></div>
                  </div>

                  <div class="col-span-2 text-right text-sm font-black text-slate-950">
                    {{ formatNumber(item.penduduk2024) }}
                  </div>
                </div>
              </div>
            </div>
          </section>

          <!-- Table -->
          <section class="mt-8 rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 p-7">
              <p class="text-sm font-semibold uppercase tracking-wide text-blue-600">
                Tabel Perbandingan
              </p>
              <h2 class="mt-2 text-2xl font-black text-slate-950">
                Penduduk Desa/Kelurahan Kecamatan Sampang
              </h2>
            </div>

            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                  <tr>
                    <th class="px-7 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                      Desa/Kelurahan
                    </th>
                    <th class="px-7 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                      2023
                    </th>
                    <th class="px-7 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                      2024
                    </th>
                    <th class="px-7 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                      Perubahan
                    </th>
                    <th class="px-7 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                      Persentase
                    </th>
                  </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
                  <tr
                    v-for="item in sortedRows"
                    :key="item.id"
                    :class="item.isCurrentDesa ? 'bg-blue-50/70' : 'hover:bg-slate-50'"
                  >
                    <td class="px-7 py-4">
                      <div class="flex items-center gap-3">
                        <span
                          class="h-2.5 w-2.5 rounded-full"
                          :class="item.isCurrentDesa ? 'bg-blue-600' : 'bg-slate-300'"
                        ></span>
                        <span class="font-bold text-slate-900">
                          {{ item.nama }}
                        </span>
                      </div>
                    </td>

                    <td class="px-7 py-4 text-right font-semibold text-slate-600">
                      {{ formatNumber(item.penduduk2023) }}
                    </td>

                    <td class="px-7 py-4 text-right font-black text-slate-950">
                      {{ formatNumber(item.penduduk2024) }}
                    </td>

                    <td
                      class="px-7 py-4 text-right font-bold"
                      :class="item.perubahan >= 0 ? 'text-emerald-600' : 'text-rose-600'"
                    >
                      {{ formatSignedNumber(item.perubahan) }}
                    </td>

                    <td
                      class="px-7 py-4 text-right font-bold"
                      :class="item.persentase >= 0 ? 'text-emerald-600' : 'text-rose-600'"
                    >
                      {{ formatPercent(item.persentase) }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
        </template>
      </div>
    </div>
  </DashboardLayout>
</template>