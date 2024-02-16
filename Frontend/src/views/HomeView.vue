<script setup lang="ts">

import TextPost from "@/components/TextPost.vue";
import axios from "axios";
import SideFeed from "@/components/SideFeed.vue";
import RowComponent from "@/components/RowComponent.vue";
import {onMounted, ref, watch} from "vue";
import {useRoute, useRouter} from "vue-router";

async function getRequest() {

    console.log('get request greetings')

    const res = await axios.get('https://localhost/api/comms', {
        params: {
            page: 1
        },
        headers: {
            'accept': 'application/ld+json'
        }
    })
        .then(response => {
            // Handle the response
            console.log(response.data);
        })
        .catch(error => {
            // Handle errors
            console.error('Error:', error);
        });
}

async function postRequest() {
    console.log('post request')

    const form = new FormData()
    form.append('name', "nowe imie")
    const res = await axios.post('https://localhost/greetings', form, {
        headers: {
            "Content-Type": "application/ld+json"
        }
    })
    console.log(res)
    console.log(res.data)
}

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

const isCommentSection = ref(false)

const router = useRouter()
const route = useRoute()

onMounted(() => {
    if(route.name === 'comments') {
        isCommentSection.value = true
    } else {
        isCommentSection.value = false
    }
})


router.beforeEach((to, from) => {
    if(from.path.startsWith('/r/')){
        isCommentSection.value = true
    }
    if(to.path.startsWith('/r/')) {
        isCommentSection.value = true
    } else if(to.path === '/') {
        isCommentSection.value = false
    }
})

</script>

<template>
    <main class="text-white mt-12">
        <div class="flex gap-4 justify-center">
            <div class="z-20 bg-main-bg hidden xl:block ">

                <div class="w-60 flex flex-col gap-4 select-none border-r border-[#242c2e]
                 sticky top-16 overflow-hidden hover:overflow-y-scroll h-[90vh]">

                    <div>
                        <div v-for="n in 3" :key="n">
                            <RowComponent :name="subreddits[n]" />
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

            </div>
            <div class="flex flex-col gap-4 items-center scroll-smooth" v-if="!isCommentSection">

                <button class="bg-blue-500 rounded-md p-2" @click="getRequest">Communities</button>
                <button class="bg-blue-500 rounded-md p-2" @click="postRequest">not fixed btw</button>


                <div v-for="n in 20" :key="n">
                    <router-link :to="`/r/${n}/comments/${n}`" >
                        <TextPost />
                    </router-link>
                </div>

            </div>
            <div v-else>
                <router-view></router-view>
            </div>

            <div class="w-60 hidden xl:block" >
                <div class="w-60 flex flex-col gap-4 select-none sticky top-16 h-screen">

                </div>
            </div>
        </div>


    </main>
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

