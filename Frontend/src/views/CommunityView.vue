<script setup lang="ts">

import IconUser from "@/components/icons/IconUser.vue";
</script>

<template>
    <div class="w-full">
        <div class="z-30">
            <img class="object-cover h-32 w-full" alt="banner" src="https://styles.redditmedia.com/t5_38jf0/styles/bannerBackgroundImage_0z3fqd7mkhra1.png">
        </div>
        <div class="h-16 flex justify-between px-3 relative bottom-8 z-20">
            <div class="flex gap-3">
                <div class="flex">
                    <icon-user />
                </div>
                <div class="flex items-end text-3xl ">
                    r/LivestreamFail
                </div>
            </div>
            <div class="flex items-end text-xl gap-4">
                <div>create post</div>
                <div>notify</div>
                <div>join</div>
                <div>...</div>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>