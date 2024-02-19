<script setup lang="ts">
import IconDots from "@/components/icons/IconDots.vue";
import BellIcon from "@/components/navbar/BellIcon.vue";
import IconAdd from "@/components/icons/IconAdd.vue";


</script>

<template>
    <div class="w-full">
        <div class="z-30">
            <img class="object-cover h-32 w-full" alt="banner"
                 src="https://styles.redditmedia.com/t5_38jf0/styles/bannerBackgroundImage_0z3fqd7mkhra1.png">
        </div>
        <div class="h-16 flex justify-between px-3">
            <div class="flex gap-3  z-20">
                <div class="relative bottom-10">
                    <img class="rounded-full object-contain border-4 border-main-bg w-20" src="https://styles.redditmedia.com/t5_2qmox/styles/communityIcon_r6keaskpkp8c1.png" alt="community logo">
                </div>
                <div class="flex items-end text-3xl font-bold relative bottom-8">
                    r/LivestreamFail
                </div>
            </div>
            <div class="flex items-center gap-4 ">
                <div class="flex items-center gap-1 rounded-full text-white p-2 cursor-pointer border hover:border-white border-slate-400 ">
                    <icon-add/>
                    <div>create post</div>
                </div>
                <div class="flex items-center rounded-full text-white p-3 cursor-pointer border hover:border-white border-slate-400">
                    <bell-icon/>
                </div>
                <div
                    class="flex items-center rounded-full bg-blue-500 text-white p-2 cursor-pointer border hover:border-white border-slate-400 ">
                    Join
                </div>
                <div class="flex items-center rounded-full text-white p-3 cursor-pointer border hover:border-white border-slate-400 ">
                    <icon-dots/>
                </div>
            </div>
        </div>
    </div>
</template>
