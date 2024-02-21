<script setup lang="ts">

import IconDots from "@/components/icons/IconDots.vue";
import IconBookmark from "@/components/icons/IconBookmark.vue";
import {onBeforeUnmount, ref} from "vue";
import IconUser from "@/components/icons/IconUser.vue";

const showMenu = ref(false)

const showCommunityInfo = ref(false)

function closeMenu() {
    showMenu.value = false
}

let hideTimeout:number|undefined
function hideCommunityInfo() {
    hideTimeout = setTimeout(() => {
        showCommunityInfo.value = false
    }, 800)
}

function cancelHide() {
    clearTimeout(hideTimeout)
}

onBeforeUnmount(() => {
    cancelHide()
})

</script>
<template>
    <div class="text-sm mt-2 flex items-center gap-1">
        <div class="relative" @mouseover="cancelHide();showCommunityInfo = true"
             @mouseleave="hideCommunityInfo">
            <p class="text-white hover:text-text-blue">r/shitposting</p>
            <transition name="slide-fade">
                <div v-if="showCommunityInfo" @mouseenter="cancelHide"
                     class="absolute bg-main-bg top-8 flex flex-col shadow-lg shadow-black select-text z-10    ">
                    <div class="p-3 hover:bg-hover-light flex items-center gap-2">
                        <icon-user class="w-8"/>
                        r/shitposting
                    </div>
                    <div class="p-3 hover:bg-hover-light flex items-center gap-2">The realm of the most anti-climactic
                        short stories from 4chan.
                    </div>
                    <div class="p-3 hover:bg-hover-light flex items-center gap-2">
                        <div class="flex gap-32">
                            <div class="flex flex-col">
                                <div>
                                    2.7M
                                </div>
                                <div>
                                    Members
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <div>
                                    6.7K
                                </div>
                                <div>
                                    Online
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <p class="text-gray-400 grow">&#x2022; 5 hours ago</p>
        <div class="hover:bg-hover-dark hover:rounded-full p-2 relative" @click.stop="showMenu = !showMenu">
            <icon-dots/>
            <transition name="slide-fade">
                <div @click.stop v-if="showMenu" v-click-outside="closeMenu"
                     class="absolute bg-main-bg right-0 top-8 flex flex-col shadow-lg shadow-black select-text">
                    <div class="p-3 hover:bg-hover-light flex items-center gap-2">
                        <icon-bookmark/>
                        Save
                    </div>
                    <div class="p-3 hover:bg-hover-light flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                            <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                            <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                            <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
                        </svg>
                        Hide
                    </div>
                    <div class="p-3 hover:bg-hover-light flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
                            <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21 21 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21 21 0 0 0 14 7.655V1.222z"/>
                        </svg>
                        Report
                    </div>
                </div>
            </transition>
        </div>
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
