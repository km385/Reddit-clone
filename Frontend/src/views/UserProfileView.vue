<script setup lang="ts">

import PostFeed from "@/components/PostFeed.vue";
import {ref} from "vue";
import IconUser from "@/components/icons/IconUser.vue";
const pages = ['Overview', 'Posts', 'Comments', 'Saved', 'Hidden', 'Upvoted', 'Downvoted']

const userInfo = ref({
    'Post Karma': 54,
    'Comments Karma': 143,
    'Followers': 1,
    'Cake Day': 'Oct 29, 2017',
    'Gold Receiver': 0
})
</script>

<template>
    <div class="flex gap-32 w-full">
        <div class="mx-auto xl:mx-0">
            <div class="flex gap-1 mb-10">
                <button v-for="n in pages" :key="n" autofocus
                        class="focus:bg-[#33464c] px-4 py-2 rounded-full outline-0 hover:underline text-sm">{{n}}
                </button>
            </div>
            <PostFeed class=""/>
        </div>
        <div class="
        w-1/3 flex-col gap-4 hidden xl:flex
        sticky top-16 h-[90vh]
        scrollbar-styled overflow-hidden hover:overflow-y-scroll">
                <div class="min-h-20 bg-gradient-to-b from-indigo-500 rounded-t-3xl"></div>
                <div class="flex flex-col gap-2 p-4 bg-black rounded-b-3xl mb-10">
                    <div>
                        user123
                    </div>
                    <div>
                        <button class="bg-hover-dark px-4 py-1 rounded-full">Share</button>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div v-for="(value, name, index) in userInfo" :key="index">
                            <div class="flex flex-col gap-1">
                                <p>{{ value }}</p>
                                <p class="text-sm text-gray-500">{{ name }}</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        Settings
                    </div>
                    <div class="flex flex-col gap-1">
                        <div v-for="n in 20 " :key="n">
                            <div class="flex gap-2 text-sm">
                                <icon-user class="w-8"/>
                                <div class="flex flex-col grow">
                                    <div>Profile</div>
                                    <div class="text-gray-500 text-xs">Customize your profile</div>
                                </div>
                                <div>
                                    <button class="bg-hover-light px-2 py-1 rounded-full">Edit Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>

<style scoped>

</style>