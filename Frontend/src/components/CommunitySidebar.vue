<template>
    <div class="w-60 flex flex-col gap-4 select-none border-r border-[#242c2e]
                 sticky top-16 overflow-hidden hover:overflow-y-scroll h-[90vh]
                 scrollbar-styled">
        <div>
            <div v-for="n in 3" :key="n">
                <RowComponent :name="subreddits[n]"/>
            </div>
        </div>

        <hr class="border-[#242c2e]">
        <SideFeed name="CUSTOM FEEDS" :has-favorite-icon="true"/>

        <hr class="border-[#242c2e]">
        <SideFeed name="RECENT"/>

        <hr class="border-[#242c2e]">
        <SideFeed name="COMMUNITIES" :has-favorite-icon="true"/>

        <hr class="border-[#242c2e]">
        <SideFeed name="RESOURCES"/>

    </div>
</template>
<script setup lang="ts">
import RowComponent from "@/components/RowComponent.vue";
import SideFeed from "@/components/SideFeed.vue";

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
<style scoped>

</style>