<script setup lang="ts">

import TextPost from "@/components/TextPost.vue";
import {useRouter} from "vue-router";

const router = useRouter()

function goToComments(n: number) {
    router.push({
        name: 'comments',
        params: {
            community: n,
            id: n
        }
    })
}
</script>
<template>
    <div class="flex flex-col gap-5">
        <div v-for="n in 20" :key="n">
            <TextPost @click="goToComments(n)"/>
        </div>
    </div>
</template>
