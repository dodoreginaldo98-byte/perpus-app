<script setup>
import { ref } from 'vue';
// 1. Tambahkan baris import Sidebar di sini. Sesuaikan path-nya jika file Sidebar ada di folder lain.
import Sidebar from '@/Components/Sidebar.vue'; 
// ...import lain bawaan Breeze...
</script>

<template>
    <!-- 2. Membungkus konten menggunakan elemen flexbox -->
    <div class="flex min-h-screen bg-gray-100">
        
        <!-- Menyisipkan Sidebar sebelum konten utama -->
        <Sidebar />
        
        <div class="flex-1">
            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
            
            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
        
    </div>
</template>