<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';

// 'book' diterima dari BookController@edit (Langkah 2), berisi data lama buku ini
const props = defineProps({
    book: {
        type: Object,
        required: true,
    },
});

// Berbeda dari Create.vue: nilai awal form diisi dari props.book, bukan kosong
const form = useForm({
    kode_buku: props.book.kode_buku,
    judul: props.book.judul,
    pengarang: props.book.pengarang,
    penerbit: props.book.penerbit,
    tahun: props.book.tahun,
    stok: props.book.stok,
});

// form.put() (bukan form.post() seperti pada Create.vue) karena ini operasi Update.
// route('books.update', props.book.id) merujuk ke method update() pada Langkah 2
const submit = () => {
    form.put(route('books.update', props.book.id));
};
</script>

<template>
    <AuthenticatedLayout>
        <h1>Edit Buku</h1>

        <form @submit.prevent="submit">
            <div>
                <label for="kode_buku">Kode Buku</label>
                <input id="kode_buku" v-model="form.kode_buku" type="text" />
                <span v-if="form.errors.kode_buku">{{ form.errors.kode_buku }}</span>
            </div>

            <div>
                <label for="judul">Judul</label>
                <input id="judul" v-model="form.judul" type="text" />
                <span v-if="form.errors.judul">{{ form.errors.judul }}</span>
            </div>

            <div>
                <label for="pengarang">Pengarang</label>
                <input id="pengarang" v-model="form.pengarang" type="text" />
                <span v-if="form.errors.pengarang">{{ form.errors.pengarang }}</span>
            </div>

            <div>
                <label for="penerbit">Penerbit</label>
                <input id="penerbit" v-model="form.penerbit" type="text" />
                <span v-if="form.errors.penerbit">{{ form.errors.penerbit }}</span>
            </div>

            <div>
                <label for="tahun">Tahun</label>
                <input id="tahun" v-model="form.tahun" type="text" />
                <span v-if="form.errors.tahun">{{ form.errors.tahun }}</span>
            </div>

            <div>
                <label for="stok">Stok</label>
                <input id="stok" v-model="form.stok" type="number" />
                <span v-if="form.errors.stok">{{ form.errors.stok }}</span>
            </div>

            <button type="submit" :disabled="form.processing">
                Simpan Perubahan
            </button>
        </form>
    </AuthenticatedLayout>
</template>