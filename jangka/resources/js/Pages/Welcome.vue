<script setup>
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Smart Village Kabupaten Sampang" />

  <div class="font-sans text-gray-800 scroll-smooth">
    <!-- 🌐 NAVBAR -->
    <nav
      class="fixed top-0 left-0 z-50 w-full transition-all duration-300 shadow-md bg-white/70 backdrop-blur-md"
    >
      <div class="flex items-center justify-between px-6 py-4 mx-auto max-w-7xl">
        <!-- LOGO + TITLE -->
        <div class="flex items-center space-x-3">
          <img
            src="/images/smartvillage.png"
            alt="Logo Smart Village"
            class="object-contain w-5 h-5"
          />
          <h1
            class="text-2xl font-extrabold text-transparent bg-gradient-to-r from-blue-700 to-blue-500 bg-clip-text"
          >
            Smart Village Kabupaten Sampang
          </h1>
        </div>

        <!-- MENU -->
        <ul class="hidden space-x-8 font-medium text-gray-700 md:flex">
          <li>
            <a href="#beranda" class="transition-colors hover:text-blue-600">Beranda</a>
          </li>
          <li>
            <a href="#tentang" class="transition-colors hover:text-blue-600">Smart Village</a>
          </li>
          <li>
            <a href="#sampang" class="transition-colors hover:text-blue-600">Tentang Sampang</a>
          </li>
        </ul>

        <!-- LOGIN / REGISTER -->
        <div class="space-x-3">
          <Link
            href="/login"
            class="px-4 py-2 text-white transition-all bg-blue-600 shadow-sm rounded-xl hover:bg-blue-700 hover:shadow-md"
            >Login</Link
          >
          <Link
            href="/register"
            class="px-4 py-2 text-blue-600 transition-all border border-blue-600 rounded-xl hover:bg-blue-50"
            >Register</Link
          >
        </div>
      </div>
    </nav>

    <!-- 🏞️ BERANDA DENGAN VIDEO -->
    <section
      id="beranda"
      class="relative flex flex-col items-center justify-center min-h-screen overflow-hidden text-center"
    >
      <!-- 🎬 Background Video -->
      <video
        autoplay
        muted
        loop
        playsinline
        class="absolute inset-0 object-cover w-full h-full"
      >
        <source src="/videos/Sampang2.mp4" type="video/mp4" />
      </video>

      <!-- 🔹 Overlay Gelap -->
      <div class="absolute inset-0 bg-black/50"></div>

      <!-- 🔹 Konten Utama -->
      <div class="relative z-10 px-6 mt-20">
        <!-- 🖼️ Logo Tengah -->
        <div class="flex justify-center mb-6 animate-fadeInUp">
          <img
            src="/images/smartvillage.png"
            alt="Logo Smart Village"
            class="object-contain w-28 h-28 drop-shadow-lg"
          />
        </div>

        <h1
          class="mb-6 text-5xl font-extrabold leading-tight text-white md:text-6xl drop-shadow-lg"
        >
          Smart Village <br class="hidden md:block" />
          Kabupaten Sampang
        </h1>

        <p
          class="max-w-2xl mx-auto mb-10 text-lg leading-relaxed text-gray-200 md:text-xl"
        >
          Membangun desa digital yang <strong>terhubung</strong>,
          <strong>transparan</strong>, dan
          <strong>berdaya saing</strong> untuk masa depan Kabupaten
          Sampang yang lebih maju.
        </p>

        <a
          href="#tentang"
          class="inline-block px-6 py-3 font-semibold text-white transition-all bg-blue-700 shadow-md rounded-xl hover:bg-blue-800 hover:shadow-lg"
        >
          Pelajari Lebih Lanjut
        </a>
      </div>
    </section>

    <!-- 💡 TENTANG SMART VILLAGE -->
    <section id="tentang" class="px-6 py-24 text-center bg-white">
      <h2 class="mb-8 text-4xl font-bold text-blue-800">Apa Itu Smart Village?</h2>
      <p
        class="max-w-3xl mx-auto mb-16 text-lg leading-relaxed text-gray-600"
      >
        <strong>Smart Village</strong> adalah konsep pembangunan desa berbasis teknologi informasi
        dan komunikasi untuk meningkatkan pelayanan publik, transparansi pemerintahan,
        serta kesejahteraan masyarakat desa. Dengan pendekatan digital, Smart Village membantu
        pemerintah desa mengelola data, memberikan layanan online, dan memperkuat partisipasi warga.
      </p>

      <div class="grid max-w-6xl gap-8 mx-auto md:grid-cols-3">
        <div
          class="p-8 transition-all transform shadow-md bg-blue-50 hover:bg-blue-100 rounded-2xl hover:shadow-xl hover:-translate-y-1"
        >
          <h3 class="mb-2 text-xl font-semibold text-blue-700">💡 Inovatif</h3>
          <p class="text-gray-600">
            Solusi kreatif untuk meningkatkan efisiensi pelayanan publik melalui sistem digital.
          </p>
        </div>
        <div
          class="p-8 transition-all transform shadow-md bg-blue-50 hover:bg-blue-100 rounded-2xl hover:shadow-xl hover:-translate-y-1"
        >
          <h3 class="mb-2 text-xl font-semibold text-blue-700">🔍 Transparan</h3>
          <p class="text-gray-600">
            Informasi desa dapat diakses secara terbuka dan real-time untuk meningkatkan kepercayaan publik.
          </p>
        </div>
        <div
          class="p-8 transition-all transform shadow-md bg-blue-50 hover:bg-blue-100 rounded-2xl hover:shadow-xl hover:-translate-y-1"
        >
          <h3 class="mb-2 text-xl font-semibold text-blue-700">🤝 Partisipatif</h3>
          <p class="text-gray-600">
            Warga dilibatkan aktif dalam pembangunan dan pengawasan desa melalui platform digital.
          </p>
        </div>
      </div>
    </section>

    <!-- 🏛️ TENTANG KABUPATEN SAMPANG -->
    <section id="sampang" class="px-6 py-24 text-center bg-gradient-to-b from-gray-50 to-blue-50">
      <h2 class="mb-8 text-4xl font-bold text-blue-800">Tentang Kabupaten Sampang</h2>

      <div class="max-w-5xl mx-auto text-lg leading-relaxed text-gray-600">
        <p class="mb-6">
          Kabupaten Sampang merupakan salah satu kabupaten di Pulau Madura, Provinsi Jawa Timur,
          dengan potensi sumber daya alam dan manusia yang besar. Wilayah ini dikenal akan budaya
          masyarakatnya yang kuat, semangat gotong royong, serta kekayaan alam di bidang pertanian,
          perikanan, dan peternakan.
        </p>
        <p>
          Melalui program <strong>Smart Village Kabupaten Sampang</strong>, pemerintah berkomitmen untuk
          mempercepat transformasi digital di seluruh desa. Tujuannya adalah menghadirkan pelayanan publik
          yang lebih efisien, mendorong inovasi masyarakat desa, dan menciptakan tata kelola pemerintahan
          yang transparan serta berbasis data.
        </p>
      </div>

      <div class="mt-12">
        <img
          src="/images/logoKabupatenSampang.png"
          alt="Kabupaten Sampang"
          class="object-contain mx-auto transition-transform duration-500 shadow-lg rounded-3xl w-72 h-72 hover:scale-105"
        />
      </div>
    </section>

    <!-- ⚡ FOOTER -->
    <footer class="py-8 mt-16 text-center text-white bg-blue-700">
      <div class="flex flex-col items-center justify-between max-w-6xl px-6 mx-auto space-y-6 md:flex-row md:space-y-0">
        <p class="text-sm">&copy; 2025 Smart Village Kabupaten Sampang. Semua hak dilindungi.</p>
        <div class="flex space-x-4 text-sm">
          <a href="#" class="hover:underline">Kebijakan Privasi</a>
          <a href="#" class="hover:underline">Kontak</a>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>
html {
  scroll-behavior: smooth;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fadeInUp {
  animation: fadeInUp 1.5s ease forwards;
}
</style>
