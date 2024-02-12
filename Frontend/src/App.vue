<script setup lang="ts">
import {RouterView} from 'vue-router'
import RedditLogo from "@/components/navbar/RedditLogo.vue";
import CommunitiesMenu from "@/components/navbar/SubRedditsMenu.vue";
import SearchBar from "@/components/navbar/SearchBar.vue";
import NavBarIcons from "@/components/navbar/NavBarIcons.vue";
import AdvertiseButton from "@/components/navbar/AdvertiseButton.vue";
import UserMenu from "@/components/navbar/UserMenu.vue";
</script>

<template>
    <header class="fixed top-0 w-full z-[999]">
        <div class="flex gap-4 items-center w-full bg-[#1a1a1b] text-white h-12 outline outline-1 outline-gray-700">
            <RedditLogo/>
            <CommunitiesMenu />
            <SearchBar/>
            <NavBarIcons/>
            <AdvertiseButton/>
            <UserMenu/>
        </div>
    </header>
    <div class="bg-[#030303] pt-5 ">
        <RouterView />
    </div>

</template>

