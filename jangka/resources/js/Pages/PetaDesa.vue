<script setup>
import { ref, onMounted, watch, nextTick } from 'vue'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

const props = defineProps({
  desa: {
    type: String,
    default: 'Noreh',
  },
})

const mapContainer = ref(null)
const loading = ref(false)
const errorMessage = ref('')
const wilayah = ref(null)

let map = null
let boundaryLayer = null
let maskLayer = null
let centerLayer = null

const initMap = () => {
  if (map || !mapContainer.value) return

  map = L.map(mapContainer.value, {
    zoomControl: true,
    attributionControl: true,
  }).setView([-7.2090801708789956, 113.05843364568175], 13)

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors',
  }).addTo(map)
}

const normalizePath = (path) => {
  if (!path) return []

  let parsedPath = path

  if (typeof parsedPath === 'string') {
    try {
      parsedPath = JSON.parse(parsedPath)
    } catch (error) {
      console.error('Path bukan JSON valid:', error)
      return []
    }
  }

  // Format: [[lat, lng], [lat, lng]]
  if (
    Array.isArray(parsedPath) &&
    Array.isArray(parsedPath[0]) &&
    typeof parsedPath[0][0] === 'number'
  ) {
    return [parsedPath]
  }

  // Format: [[[lat, lng], [lat, lng]]]
  if (
    Array.isArray(parsedPath) &&
    Array.isArray(parsedPath[0]) &&
    Array.isArray(parsedPath[0][0]) &&
    typeof parsedPath[0][0][0] === 'number'
  ) {
    return parsedPath
  }

  // Format MultiPolygon: [[[[lat, lng], [lat, lng]]]]
  if (
    Array.isArray(parsedPath) &&
    Array.isArray(parsedPath[0]) &&
    Array.isArray(parsedPath[0][0]) &&
    Array.isArray(parsedPath[0][0][0]) &&
    typeof parsedPath[0][0][0][0] === 'number'
  ) {
    return parsedPath.flat()
  }

  return []
}

const clearMapLayers = () => {
  if (boundaryLayer) {
    map.removeLayer(boundaryLayer)
    boundaryLayer = null
  }

  if (maskLayer) {
    map.removeLayer(maskLayer)
    maskLayer = null
  }

  if (centerLayer) {
    map.removeLayer(centerLayer)
    centerLayer = null
  }
}

const drawWilayah = async (item) => {
  if (!map || !item) return

  clearMapLayers()

  const rings = normalizePath(item.path)

  if (!rings.length) {
    errorMessage.value = 'Data path wilayah tidak valid atau kosong.'
    return
  }

  // Overlay gelap untuk area di luar wilayah
  const outerWorld = [
    [-90, -180],
    [-90, 180],
    [90, 180],
    [90, -180],
  ]

  maskLayer = L.polygon([outerWorld, ...rings], {
    stroke: false,
    fillColor: '#000000',
    fillOpacity: 0.45,
    interactive: false,
  }).addTo(map)

  boundaryLayer = L.polygon(rings, {
    color: '#2563eb',
    weight: 3,
    opacity: 1,
    fillColor: '#3b82f6',
    fillOpacity: 0.25,
  }).addTo(map)

  if (item.lat && item.lng) {
    centerLayer = L.circleMarker([item.lat, item.lng], {
      radius: 1,
      color: '#dc2626',
      weight: 2,
      fillColor: '#ef4444',
      fillOpacity: 0.25,
    })
      .bindPopup(`
        <strong>${item.nama}</strong><br>
        Kode: ${item.kode}<br>
        Lat: ${item.lat}<br>
        Lng: ${item.lng}
      `)
      .addTo(map)
  }

  map.fitBounds(boundaryLayer.getBounds(), {
    padding: [30, 30],
  })

  await nextTick()
  map.invalidateSize()
}

const fetchWilayah = async () => {
  loading.value = true
  errorMessage.value = ''

  try {
    const namaDesa = props.desa || 'Noreh'

    const response = await fetch(
      `/api/wilayah-boundaries?nama=${encodeURIComponent(namaDesa)}`,
      {
        headers: {
          Accept: 'application/json',
        },
      },
    )

    const contentType = response.headers.get('content-type') || ''

    if (!contentType.includes('application/json')) {
      throw new Error(
        'Response dari server bukan JSON. Pastikan route API berada di routes/api.php dan URL diawali /api.',
      )
    }

    const result = await response.json()

    if (!response.ok || !result.success) {
      throw new Error(result.message || 'Gagal mengambil data wilayah.')
    }

    const firstData = result.data?.[0]

    if (!firstData) {
      throw new Error(`Data wilayah dengan nama "${namaDesa}" tidak ditemukan.`)
    }

    wilayah.value = firstData
    await drawWilayah(firstData)
  } catch (error) {
    console.error(error)
    errorMessage.value = error.message
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  initMap()
  await fetchWilayah()
})

watch(
  () => props.desa,
  async () => {
    await fetchWilayah()
  },
)
</script>

<template>
  <DashboardLayout>
    <div class="flex flex-col h-full w-full">
      <h1 class="text-2xl font-bold mb-4 text-gray-800">
        Peta Desa
      </h1>

      <p class="text-gray-600 mb-4">
        Visualisasi lokasi dan batas wilayah Desa
        <strong>{{ wilayah?.nama || desa || 'Tidak Diketahui' }}</strong>
        di Kabupaten Sampang, Jawa Timur.
      </p>

      <div
        v-if="wilayah"
        class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-3 text-sm"
      >
        <div class="bg-white border rounded-lg p-3">
          <p class="text-gray-500">Nama Desa</p>
          <p class="font-semibold">{{ wilayah.nama }}</p>
        </div>

        <div class="bg-white border rounded-lg p-3">
          <p class="text-gray-500">Kabupaten</p>
          <p class="font-semibold">Sampang</p>
        </div>

        <div class="bg-white border rounded-lg p-3">
          <p class="text-gray-500">Provinsi</p>
          <p class="font-semibold">Jawa Timur</p>
        </div>
      </div>

      <div
        class="flex-grow w-full rounded-xl overflow-hidden shadow-lg relative bg-gray-900 border border-gray-700 h-[calc(90vh-260px)] min-h-[420px]"
      >
        <div
          ref="mapContainer"
          class="w-full h-full"
        ></div>

        <div
          v-if="loading"
          class="absolute inset-0 bg-black/50 flex items-center justify-center text-white z-[999]"
        >
          Memuat peta wilayah...
        </div>

        <div
          v-if="errorMessage"
          class="absolute top-4 left-4 right-4 bg-red-600 text-white px-4 py-3 rounded-lg shadow-lg z-[999]"
        >
          {{ errorMessage }}
        </div>
      </div>
    </div>
  </DashboardLayout>
</template>

<style scoped>
:deep(.leaflet-container) {
  width: 100%;
  height: 100%;
}
</style>