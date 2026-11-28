<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, watch, onBeforeUnmount } from 'vue'; // BARU
import axios from 'axios';

const form = useForm({
    kode_buku: '',
    judul: '',
    pengarang: '',
    penerbit: '',
    tahun: '',
    stok: 0,
});

// ---------- Validasi realtime kode buku (BARU) ----------
// statusKode berisi: '' (belum diperiksa), 'memeriksa', 'tersedia', 'terpakai', 'gagal'
const statusKode = ref('');

let timerKode = null;
let permintaanKode = null;

async function periksaKode() {
    if (permintaanKode) {
        permintaanKode.abort();
    }
    permintaanKode = new AbortController();

    statusKode.value = 'memeriksa';

    try {
        const respons = await axios.get(route('books.cek-kode'), {
            params: {
                kode_buku: form.kode_buku.trim(),
            },
            signal: permintaanKode.signal,
        });

        // Server membalas {"tersedia": true} atau {"tersedia": false}
        statusKode.value = respons.data.tersedia ? 'tersedia' : 'terpakai';
    } catch (error) {
        if (axios.isCancel(error)) {
            return;
        }
        statusKode.value = 'gagal';
    }
}

watch(() => form.kode_buku, (nilai) => {
    clearTimeout(timerKode);

    if (!nilai || nilai.trim() === '') {
        if (permintaanKode) {
            permintaanKode.abort();
        }
        statusKode.value = '';
        return;
    }

    timerKode = setTimeout(periksaKode, 500);
});

onBeforeUnmount(() => {
    clearTimeout(timerKode);
    if (permintaanKode) {
        permintaanKode.abort();
    }
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

                    <!-- BARU: pesan hasil pemeriksaan realtime; hanya satu yang
                         tampil sesuai statusKode -->
                    <div v-if="statusKode === 'memeriksa'" class="text-sm text-gray-500">
                        Memeriksa kode buku...
                    </div>
                    <div v-else-if="statusKode === 'tersedia'" class="text-sm text-green-700">
                        Kode buku ini tersedia.
                    </div>
                    <div v-else-if="statusKode === 'terpakai'" class="text-sm text-red-600">
                        Kode buku ini sudah terdaftar. Gunakan kode lain.
                    </div>
                    <div v-else-if="statusKode === 'gagal'" class="text-sm text-yellow-700">
                        Pemeriksaan otomatis gagal. Anda tetap dapat menyimpan;
                        server akan memeriksa ulang.
                    </div>

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

                <!-- BARU: tombol dinonaktifkan jika kode buku sudah terpakai -->
                <button
                    type="submit"
                    :disabled="form.processing || statusKode === 'terpakai'"
                    class="px-4 py-2 text-white bg-blue-600 rounded"
                >
                    Simpan
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>