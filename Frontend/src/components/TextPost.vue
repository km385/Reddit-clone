<script setup lang="ts">

import PostNav from "@/components/post/PostNav.vue";
import PostContent from "@/components/PostContent.vue";
import PostControls from "@/components/PostControls.vue";
</script>

<template>
    <div class="w-[700px] hover:bg-hover-light rounded-xl cursor-pointer select-none">

        <div class="rounded-r-md grow flex flex-col *:mx-4">
            <PostNav/>
            <div class="text-white text-xl">Mam dosyć</div>
            <PostContent/>
            <PostControls/>
        </div>

    </div>
</template>