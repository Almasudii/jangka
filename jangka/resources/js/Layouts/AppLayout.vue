<script setup>
import { Link, useForm } from '@inertiajs/vue3';

const logout = () => {
    useForm({}).post(route('logout'));
};
</script>

<template>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="flex flex-col w-64 p-4 text-white bg-gray-800">
            <h1 class="mb-6 text-2xl font-bold">Smart Village</h1>

            <!-- Menu Navigasi -->
            <nav class="flex-1 space-y-2">
                <Link href="/dashboard" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</Link>
                <Link href="/berita" class="block px-4 py-2 rounded hover:bg-gray-700">Berita</Link>
                <Link href="/layanan" class="block px-4 py-2 rounded hover:bg-gray-700">Layanan</Link>
            </nav>

            <!-- Tombol Logout -->
            <button
                @click="logout"
                class="px-4 py-2 mt-auto text-white bg-red-600 rounded hover:bg-red-700">
                Logout
            </button>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-100">
            <slot />
        </main>
    </div>
</template>
