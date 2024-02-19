<script setup lang="ts">

import {ref} from "vue";
import RowComponent from "@/components/RowComponent.vue";
import IconChevronUp from "@/components/icons/IconChevronUp.vue";

const feedOpen = ref(true)

const props = defineProps({
    name: {
        required: true,
        type: String
    },
    hasFavoriteIcon: {
        default: false,
        type: Boolean
    }
})

const subreddits = [
    "AskReddit",
    "funny",
    "todayilearned",
    "worldnews",
    "pics",
    "gaming",
    "aww",
    "videos",
    "movies",
    "science",
    "technology",
    "music",
    "news",
    "books",
    "history",
    "food",
    "sports",
    "art",
    "DIY",
    "fitness"
];

</script>

<template>
    <div>
        <div @click="feedOpen = !feedOpen"
             class="cursor-pointer flex items-center rotate1 gap-2 h-10 w-full hover:bg-hover-light rounded-lg select-none px-3">
            <div class="grow text-xs">
                {{props.name}}
            </div>
            <IconChevronUp :class="{'-rotate-180':feedOpen}" class="duration-300"/>
        </div>

        <transition name="slide-fade">
            <div v-if="feedOpen">
                <div v-for="n in 10" :key="n">
                    <RowComponent :has-favorite-icon="hasFavoriteIcon" :name="subreddits[n]"/>
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.2s;
    max-height: 2000px;
}
.slide-fade-enter-from,
.slide-fade-leave-to
{
    opacity: 0;
    max-height: 0;
}
</style>
