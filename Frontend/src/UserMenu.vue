<script setup lang="ts">
import IconUser from "@/components/icons/IconUser.vue";
import {ref} from "vue";

const showMenu = ref(false)

function closeMenu() {
    showMenu.value = false
}
</script>

<template>
    <div class="relative flex cursor-pointer" @click.stop="showMenu = !showMenu">
        <icon-user  class="w-6 cursor-pointer"/>
        <transition name="slide-fade">
            <div @click.stop v-if="showMenu" v-click-outside="closeMenu"
                 class="absolute bg-main-bg right-0 top-8 shadow-lg shadow-black select-none w-[260px] py-2">
                <div  class="flex flex-col divide-y divide-[#273133] gap-2">
                    <div class="flex flex-col">
                        <div class="hover:bg-hover-light px-7 py-4 cursor-pointer">
                            <div class="flex gap-2">
                                <div class="w-8 flex ">
                                    <icon-user/>
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-sm">View Profile</p>
                                    <p class="text-xs text-gray-400">u/username</p>
                                </div>
                            </div>
                        </div>
                        <div class="hover:bg-hover-light px-7 py-4 cursor-pointer">Edit Avatar</div>
                        <div class="hover:bg-hover-light px-7 py-4 cursor-pointer">Contributor Program</div>
                        <div class="hover:bg-hover-light px-7 py-4 cursor-pointer">Dark Mode</div>
                        <div class="hover:bg-hover-light px-7 py-4 cursor-pointer">Log Out</div>
                    </div>
                    <div class="hover:bg-hover-light px-7 py-4 cursor-pointer">Advertise on Reddit</div>
                    <div class="hover:bg-hover-light px-7 py-4 cursor-pointer">Settings</div>
                    <div class="hover:bg-hover-light px-7 py-4 cursor-pointer">Premium</div>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.1s;
}
.slide-fade-enter-from,
.slide-fade-leave-to
{
    opacity: 0;
}
</style>