<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    books: Object,
    // Kata kunci terakhir yang dikirim dari controller (Langkah 7)
    search: String,
});

// Nilai awal kotak pencarian diisi dari props.search, bukan selalu kosong
const keyword = ref(props.search);

// Dijalankan saat pengguna menekan Enter pada kotak pencarian.
// router.get mengarahkan ke /books?search=..., memicu index() di Langkah 7
function cari() {
    router.get('/books', { search: keyword.value });
}

function hapus(id) {
    if (confirm('Yakin ingin menghapus buku ini?')) {
        router.delete(route('books.destroy', id));
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <h1>Data Buku</h1>

        <div v-if="$page.props.flash?.success">
            {{ $page.props.flash.success }}
        </div>

        <Link href="/books/create">+ Tambah Buku</Link>

        <!-- @keyup.enter memanggil function cari() hanya saat tombol Enter ditekan -->
        <input
            v-model="keyword"
            @keyup.enter="cari"
            type="text"
            placeholder="Cari judul atau pengarang..."
        >

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="book in books.data" :key="book.id">
                    <td>{{ book.kode_buku }}</td>
                    <td>{{ book.judul }}</td>
                    <td>{{ book.pengarang }}</td>
                    <td>{{ book.stok }}</td>
                    <td>
                        <Link :href="`/books/${book.id}/edit`">Edit</Link>
                        <button @click="hapus(book.id)">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </AuthenticatedLayout>
</template>