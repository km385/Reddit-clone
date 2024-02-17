<script setup lang="ts">

import TextPost from "@/components/TextPost.vue";
</script>

<template>
    <div class="flex flex-col">

        <div v-for="n in 20" :key="n">
            <router-link :to="{name: 'comments', params: {community: n, id: n}}" >
                <TextPost />
            </router-link>
        </div>
    </div>
</template>

<style scoped>

</style>