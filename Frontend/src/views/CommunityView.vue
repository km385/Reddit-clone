<script setup lang="ts">

import CommunityBanner from "@/views/CommunityBanner.vue";
import HomeView from "@/views/HomeView.vue";

import SideFeed from "@/components/SideFeed.vue";
import RowComponent from "@/components/RowComponent.vue";
import IconChevronUp from "@/components/icons/IconChevronUp.vue";
</script>

<template>
    <CommunityBanner/>
    <div class="flex justify-between gap-32 w-full">
        <HomeView />
        <div class="
        w-1/3 flex flex-col gap-4
        sticky top-16 overflow-hidden hover:overflow-y-scroll h-[90vh]
        bg-black rounded-lg p-4">
            <div>
                <h1 class="text-gray-300">
                    r/LivestreamFail: Livestream wins, fails, and everything in between
                </h1>
                <h2 class="text-gray-500">
                    The place for all things livestreaming.
                </h2>
            </div>

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

            <hr>

            <div>
                <div>
                    Rules
                </div>
                <div class="flex flex-col" v-for="n in 14" :key="n">
                    <div class="flex justify-between h-14 hover:bg-hover-dark cursor-pointer">
                        <div class="pl-3">{{n}}</div>
                        <div>The rule in question</div>
                        <div class="pr-3"><icon-chevron-up class="rotate-180"/></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>
::-webkit-scrollbar {
    height: 12px;
    width: 8px;

}

::-webkit-scrollbar-thumb {
    background: #3c4345;
    border-radius: 9999px;
}
</style>