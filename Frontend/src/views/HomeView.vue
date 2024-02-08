<script setup lang="ts">

import TextPost from "@/views/TextPost.vue";
</script>

<template>
    <main class="text-white">
        <div class="flex justify-center gap-4">
            <div class="flex flex-col gap-4">
                <div v-for="n in 5" :key="n">
                    <TextPost />

                </div>
            </div>

            <div class="">
                <div class="w-40 bg-gray-500 rounded-md">

                </div>
            </div>
        </div>
    </main>
</template>
