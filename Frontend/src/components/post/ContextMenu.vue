<script setup lang="ts">
import {ref} from "vue";
import IconDots from "@/components/icons/IconDots.vue";
import IconBookmark from "@/components/icons/IconBookmark.vue";
import IconEyeSlash from "@/components/icons/IconEyeSlash.vue";
import IconFlag from "@/components/icons/IconFlag.vue";

const showMenu = ref(false)

function closeMenu() {
    showMenu.value = false
}
</script>

<template>
    <div class="hover:bg-hover-dark hover:rounded-full p-2 relative cursor-pointer" @click.stop="showMenu = !showMenu">
        <icon-dots/>
        <transition name="slide-fade">
            <div @click.stop v-if="showMenu" v-click-outside="closeMenu"
                 class="absolute bg-main-bg right-0 top-8 flex flex-col shadow-lg shadow-black select-text">
                <div class="p-3 hover:bg-hover-light flex items-center gap-2">
                    <icon-bookmark/>
                    Save
                </div>
                <div class="p-3 hover:bg-hover-light flex items-center gap-2">
                    <IconEyeSlash/>
                    Hide
                </div>
                <div class="p-3 hover:bg-hover-light flex items-center gap-2">
                    <IconFlag/>
                    Report
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