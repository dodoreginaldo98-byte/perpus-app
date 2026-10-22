<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <aside class="flex flex-col w-64 min-h-screen text-white bg-indigo-900">

        <!-- Header Sidebar -->
        <div class="flex items-center justify-center h-16 border-b border-indigo-800">
            <span class="text-xl font-bold">Perpus App</span>
        </div>

        <!-- Menu Navigasi -->
        <nav class="flex-1 px-4 py-6 space-y-2">
            <Link
                href="/dashboard"
                class="block px-4 py-2 transition-colors rounded hover:bg-indigo-800"
            >
                Dashboard
            </Link>

            <Link
                href="/"
                class="block px-4 py-2 transition-colors rounded hover:bg-indigo-800"
            >
                Beranda
            </Link>

            <!-- Menu baru dari modul: href harus sama dengan Route::resource (Langkah 3) -->
            <Link
                href="/books"
                class="block px-4 py-2 transition-colors rounded hover:bg-indigo-800"
            >
                Data Buku
            </Link>

            <Link
                href="/members"
                class="block px-4 py-2 transition-colors rounded hover:bg-indigo-800"
            >
                Data Anggota
            </Link>
        </nav>

    </aside>
</template>