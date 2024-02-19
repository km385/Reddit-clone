<script setup lang="ts">

import PostFeed from "@/components/PostFeed.vue";

</script>

<template>
    <div class="flex justify-between gap-32 w-full">
        <PostFeed/>
        <div class="
        w-1/3 flex flex-col gap-4
        sticky top-16 overflow-hidden hover:overflow-y-auto h-fit max-h-[90vh]
        bg-black rounded-lg p-4 scrollbar-styled">
            <div class="flex justify-between">
                <p>Recent posts</p>
                <p class="hover:text-blue-600 cursor-pointer">Clear</p>
            </div>

        </div>
    </div>
</template>