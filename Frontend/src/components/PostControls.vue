<script setup lang="ts">
import ArrowUpIcon from "@/components/icons/ArrowUpIcon.vue";
import ArrowDownIcon from "@/components/icons/ArrowDownIcon.vue";
import IconComments from "@/components/icons/IconComments.vue";
import IconShare from "@/components/icons/IconShare.vue";


</script>
<template>
    <div class="flex justify-start gap-1 text-white py-1 text-sm">
        <div class="bg-[#1a282d] rounded-full cursor-pointer flex ">
            <div class="hover:text-red-600 hover:bg-hover-dark flex rounded-full p-2">
                <arrow-up-icon class="w-4 "/>
            </div>

            <div class="flex items-center">
                2332
            </div>

            <div class="hover:text-blue-600 hover:bg-hover-dark flex rounded-full p-2">
                <arrow-down-icon class="w-4"/>
            </div>
        </div>

        <div class="hover:bg-hover-dark bg-[#1a282d] rounded-full px-4 py-2 cursor-pointer flex items-center gap-1">
            <IconComments/>
            188
        </div>

        <div class="hover:bg-hover-dark bg-[#1a282d] rounded-full px-4 py-2 cursor-pointer flex items-center gap-1">
            <IconShare/>
            Share
        </div>
    </div>
</template>
