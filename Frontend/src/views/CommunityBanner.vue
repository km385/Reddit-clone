<template>
    <div class="w-full">
        <div class="z-30">
            <img class="object-cover h-32 w-full" alt="banner"
                 src="https://styles.redditmedia.com/t5_38jf0/styles/bannerBackgroundImage_0z3fqd7mkhra1.png">
        </div>
        <div class="h-16 flex justify-between px-3 ">
            <div class="flex gap-3 relative bottom-8 z-20">
                <div class="flex">
                    <icon-user />
                </div>
                <div class="flex items-end text-3xl ">
                    r/LivestreamFail
                </div>
            </div>
            <div class="flex items-end text-xl gap-4">
                <div class="flex items-center gap-1 rounded-full text-white p-2 cursor-pointer border border-white ">
                    <icon-add/>
                    <div>create post</div>
                </div>
                <div class="flex items-center rounded-full text-white p-3 cursor-pointer border border-white">
                    <bell-icon/>
                </div>
                <div
                    class="flex items-center rounded-full bg-blue-500 text-white p-2 cursor-pointer border border-white ">
                    Join
                </div>
                <div class="flex items-center rounded-full text-white p-3 cursor-pointer border border-white ">
                    <icon-dots/>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import IconDots from "@/components/icons/IconDots.vue";
import BellIcon from "@/components/navbar/BellIcon.vue";
import IconAdd from "@/components/icons/IconAdd.vue";
import IconUser from "@/components/icons/IconUser.vue";


</script>