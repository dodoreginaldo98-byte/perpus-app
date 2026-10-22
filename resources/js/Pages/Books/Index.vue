<script setup>
// Layout dashboard dari Pertemuan 5 (lengkap dengan Sidebar)
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';

// 'books' menerima data dari BookController@index (Langkah 4)
defineProps({
    books: Object,
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-bold">Data Buku</h1>

                <!-- Menuju form tambah buku: Books/Create.vue (Langkah 7) -->
                <Link
                    href="/books/create"
                    class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                >
                    + Tambah Buku
                </Link>
            </div>

            <table class="w-full border border-collapse border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left border">Kode</th>
                        <th class="px-4 py-2 text-left border">Judul</th>
                        <th class="px-4 py-2 text-left border">Pengarang</th>
                        <th class="px-4 py-2 text-left border">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- v-for mengulang setiap data buku, seperti foreach -->
                    <tr v-for="book in books.data" :key="book.id">
                        <td class="px-4 py-2 border">{{ book.kode_buku }}</td>
                        <td class="px-4 py-2 border">{{ book.judul }}</td>
                        <td class="px-4 py-2 border">{{ book.pengarang }}</td>
                        <td class="px-4 py-2 border">{{ book.stok }}</td>
                    </tr>

                    <!-- Tampil jika belum ada data -->
                    <tr v-if="books.data.length === 0">
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                            Belum ada data buku.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>