<script setup lang="ts">
import CommunitySidebar from "@/components/CommunitySidebar.vue";
</script>

<template>
    <main class="text-white flex justify-center">
        <div class="flex min-h-screen w-4/5 gap-32">
            <div class="z-20 bg-main-bg hidden xl:block">
                <CommunitySidebar/>
            </div>

            <div class="grow flex flex-col gap-4 items-center scroll-smooth">
                <router-link :to="{name: 'community', params: { community: 'livestreamfail'}}">
                    <button class="bg-blue-500 rounded-md p-2">Community</button>
                </router-link>

                <router-view></router-view>

            </div>

        </div>


    </main>
</template>

<style scoped>


</style>

