<script setup lang="ts">

import {onBeforeUnmount, ref} from "vue";
import IconUser from "@/components/icons/IconUser.vue";
import DotsMenu from "@/components/post/DotsMenu.vue";

const showCommunityInfo = ref(false)

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
        <DotsMenu/>
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
