<script setup lang="ts">

import TextPost from "@/components/TextPost.vue";
import CreatePost from "@/components/CreatePost.vue";
import HomeCommunity from "@/components/HomeCommunity.vue";
import axios from "axios";

async function getRequest() {

    console.log('get request greetings')

    const res = await axios.get('https://localhost/greetings?page=1', {
        headers: {
            "Content-Type": "application/ld+json"
        }
    })
    console.log('get request greetings')
    console.log(res)
    console.log(res.data)
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

</script>

<template>
    <main class="text-white mt-12">
        <div class="flex justify-center gap-4">
            <div class="flex flex-col gap-4 items-center">
                <CreatePost/>


                <button class="bg-blue-500 rounded-md p-2" @click="getRequest">greetings</button>
                <button class="bg-blue-500 rounded-md p-2" @click="postRequest">post</button>


                <div v-for="n in 5" :key="n">
                    <router-link :to="`/r/${n}/comments/${n}`">
                        <TextPost/>
                    </router-link>
                </div>

            </div>

            <div class="lg:flex-col gap-4 hidden lg:flex">
                <HomeCommunity/>
                <div class="w-[340px] flex flex-col rounded-md border border-gray-600 bg-[#1a1a1b]">

                </div>
            </div>
        </div>

    </main>
</template>
