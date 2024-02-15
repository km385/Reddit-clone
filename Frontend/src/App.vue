<script setup lang="ts">
import {RouterView} from 'vue-router'
import RedditLogo from "@/components/navbar/RedditLogo.vue";
import CommunitiesMenu from "@/components/navbar/SubRedditsMenu.vue";
import SearchBar from "@/components/navbar/SearchBar.vue";
import NavBarIcons from "@/components/navbar/NavBarIcons.vue";
import AdvertiseButton from "@/components/navbar/AdvertiseButton.vue";
import UserMenu from "@/components/navbar/UserMenu.vue";
import IconUser from "@/components/icons/IconUser.vue";
</script>

<template>
    <header class="fixed top-0 w-full z-[999]">
        <div class="flex justify-between gap-4 items-center w-full bg-main-bg text-white h-12 outline outline-1 outline-gray-700">
            <RedditLogo/>

            <div class="h-full flex items-center grow justify-center">
                <SearchBar class="w-3/5"/>
            </div>

            <div class="flex">
                <NavBarIcons/>
                <icon-user class="w-6 "/>
            </div>
        </div>
    </header>
    <div class="bg-main-bg pt-5 ">
        <RouterView />
    </div>

</template>

