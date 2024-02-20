<script setup lang="ts">
import {RouterView} from 'vue-router'
import RedditLogo from "@/components/icons/RedditIcon.vue";
import SearchBar from "@/components/navbar/SearchBar.vue";
import NavBarIcons from "@/components/navbar/NavBarIcons.vue";

import UserMenu from "@/UserMenu.vue";

</script>

<template>
    <header class="fixed top-0 w-full z-[999]">
        <div class="flex justify-between gap-4 items-center w-full bg-main-bg text-white h-12 outline outline-1 outline-gray-700">
            <router-link :to="{name: 'home'}">
                <div class="ml-5 py-2 cursor-pointer">
                    <RedditLogo/>
                </div>
            </router-link>


            <div class="h-full flex items-center grow justify-center">
                <SearchBar class="w-3/5"/>
            </div>

            <div class="flex gap-2 mr-5">
                <NavBarIcons/>
                <UserMenu/>
            </div>
        </div>
    </header>
    <div class="bg-main-bg pt-5 ">
        <RouterView />
    </div>

</template>



