<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    kode_buku: '',
    judul: '',
    pengarang: '',
    penerbit: '',
    tahun: '',
    stok: 0,
});

function submit() {
    form.post('/books');
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="p-6">
            <h1 class="mb-4 text-2xl font-bold">Tambah Buku</h1>

            <form @submit.prevent="submit" class="max-w-lg space-y-4">
                <div>
                    <label class="block mb-1">Kode Buku</label>
                    <input v-model="form.kode_buku" type="text" class="w-full rounded border-gray-300" />
                    <span v-if="form.errors.kode_buku" class="text-sm text-red-600">{{ form.errors.kode_buku }}</span>
                </div>

                <div>
                    <label class="block mb-1">Judul</label>
                    <input v-model="form.judul" type="text" class="w-full rounded border-gray-300" />
                    <span v-if="form.errors.judul" class="text-sm text-red-600">{{ form.errors.judul }}</span>
                </div>

                <div>
                    <label class="block mb-1">Pengarang</label>
                    <input v-model="form.pengarang" type="text" class="w-full rounded border-gray-300" />
                    <span v-if="form.errors.pengarang" class="text-sm text-red-600">{{ form.errors.pengarang }}</span>
                </div>

                <div>
                    <label class="block mb-1">Penerbit</label>
                    <input v-model="form.penerbit" type="text" class="w-full rounded border-gray-300" />
                </div>

                <div>
                    <label class="block mb-1">Tahun</label>
                    <input v-model="form.tahun" type="text" class="w-full rounded border-gray-300" />
                </div>

                <div>
                    <label class="block mb-1">Stok</label>
                    <input v-model="form.stok" type="number" class="w-full rounded border-gray-300" />
                    <span v-if="form.errors.stok" class="text-sm text-red-600">{{ form.errors.stok }}</span>
                </div>

                <button type="submit" :disabled="form.processing" class="px-4 py-2 text-white bg-blue-600 rounded">
                    Simpan
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>