<template>
    <div class="flex">
        <div class="w-10 mr-2 cursor-pointer flex flex-col">
            <div class="grow ">
                <icon-user/>
            </div>
            <div class=" flex justify-center items-center p-1">
                +
            </div>
        </div>
        <div class="w-full flex flex-col ">
            <div class="text-xs hover:underline cursor-pointer">user</div>
            <div>tag</div>
            <div>Comment example</div>
            <div class="flex items-center gap-2">
                <div class="w-7 cursor-pointer hover:bg-gray-600 p-1 rounded-md">
                    <arrow-up-icon/>
                </div>
                <div class="">21</div>
                <div class="w-7 cursor-pointer hover:bg-gray-600 p-1 rounded-md">
                    <arrow-down-icon/>
                </div>
                <div class="flex items-center gap-1 cursor-pointer hover:bg-gray-600 p-1 rounded-md">
                    <div class="">
                        <icon-comments/>
                    </div>
                    <div>Reply</div>
                </div>
                <div class="cursor-pointer hover:bg-gray-600 p-1 rounded-md">Share</div>
                <div class="cursor-pointer hover:bg-gray-600 p-1 rounded-md">
                    <icon-dots/>
                </div>
            </div>

        </div>
    </div>
</template>
<script setup lang="ts">
import ArrowUpIcon from "@/components/icons/ArrowUpIcon.vue";
import ArrowDownIcon from "@/components/icons/ArrowDownIcon.vue";
import IconComments from "@/components/icons/IconComments.vue";
import IconDots from "@/components/icons/IconDots.vue";
import IconUser from "@/components/icons/IconUser.vue";



</script>