<script setup lang="ts">

import IconDots from "@/components/icons/IconDots.vue";
import IconBookmark from "@/components/icons/IconBookmark.vue";
import {ref} from "vue";

const showMenu = ref(false)

const showCommunityInfo = ref(false)


</script>
<template>
    <div class="text-sm mt-2 flex items-center gap-1">
        <div class="relative" @mouseover="showCommunityInfo = true"
             @mouseleave="showCommunityInfo = false">
            <p class="text-white hover:text-text-blue">r/shitposting</p>
            <transition name="slide-fade">
                <div v-if="showCommunityInfo"
                     class="absolute bg-main-bg top-8 flex flex-col shadow-lg shadow-black select-text z-10    ">
                    <div class="p-3 hover:bg-hover-light flex items-center gap-2">
                        <icon-user/>
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
                <div @click.stop v-if="showMenu"
                     class="absolute bg-main-bg right-0 top-8 flex flex-col shadow-lg shadow-black select-text">
                    <div class="p-3 hover:bg-hover-light flex items-center gap-2">
                        <icon-bookmark/>
                        Save
                    </div>
                    <div class="p-3 hover:bg-hover-light flex items-center gap-2">
                        <icon-bookmark/>
                        Hide
                    </div>
                    <div class="p-3 hover:bg-hover-light flex items-center gap-2">
                        <icon-bookmark/>
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
