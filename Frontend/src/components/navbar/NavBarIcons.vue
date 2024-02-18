<template>
    <div class="flex gap-1">
        <div class="cursor-pointer hover:bg-[#2d2d2e] p-2 rounded-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white"
                 class="bi bi-arrow-up-right-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.854 10.803a.5.5 0 1 1-.708-.707L9.243 6H6.475a.5.5 0 1 1 0-1h3.975a.5.5 0 0 1 .5.5v3.975a.5.5 0 1 1-1 0V6.707z"/>
            </svg>
        </div>
        <div class="cursor-pointer hover:bg-[#2d2d2e] p-2 rounded-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" class="bi bi-chat-dots"
                 viewBox="0 0 16 16">
                <path
                    d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                <path
                    d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
            </svg>
        </div>
        <div class="cursor-pointer hover:bg-[#2d2d2e] p-2 rounded-sm flex gap-1">
            <AddIcon/>
            Create
        </div>
        <div class="cursor-pointer hover:bg-[#2d2d2e] p-2 rounded-sm">
            <BellIcon/>
        </div>
    </div>

</template>
<script lang="ts">
import AddIcon from "@/components/icons/IconAdd.vue";
import BellIcon from "@/components/navbar/BellIcon.vue";

export default {
    name: 'NavBarIcons',
    components: {BellIcon, AddIcon}
}
</script>