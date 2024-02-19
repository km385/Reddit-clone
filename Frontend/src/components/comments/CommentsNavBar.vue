<script setup lang="ts">
import ArrowUpIcon from "@/components/icons/ArrowUpIcon.vue";
import ArrowDownIcon from "@/components/icons/ArrowDownIcon.vue";
import XIcon from "@/components/icons/IconX.vue";

function goBack() {

}
</script>
<template>
    <div class="sticky top-12 py-2 left-0 right-0 mx-20 z-10 bg-black ">
        <div class="flex gap-2 text-white">
            <p>|</p>
            <div class="min-w-6 cursor-pointer">
                <arrow-up-icon/>
            </div>
            <p class="">3.3k</p>
            <div class="min-w-6 cursor-pointer">
                <arrow-down-icon/>
            </div>
            <p>|</p>
            <p class="truncate">TVP odmawia ujawnienia infwnienia infwnienia infwnienia infwnienia infwnienia
                infwnienia infwnienia informwnienia informwnienia informwnienia informwnienia informacji o
                zarobkach nowych prezenterów</p>
            <div @click="goBack" class="cursor-pointer flex items-center gap-1 hover:bg-gray-500 rounded-full px-2">
                <XIcon/>
                Close
            </div>
        </div>
    </div>
</template>
