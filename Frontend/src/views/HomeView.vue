<script setup lang="ts">

import TextPost from "@/components/TextPost.vue";
import axios from "axios";
import SideFeed from "@/components/SideFeed.vue";
import RowComponent from "@/components/RowComponent.vue";

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

</script>

<template>
    <main class="text-white mt-12">
        <div class="flex justify-center gap-4">
            <div class="flex flex-col border-r border-[#242c2e] h-full">

                <div class="w-60 flex flex-col gap-4">

                    <div>
                        <div v-for="n in 3" :key="n">
                            <RowComponent />
                        </div>
                    </div>

                    <hr class="border-[#242c2e]">
                    <SideFeed name="CUSTOM FEEDS"/>

                    <hr class="border-[#242c2e]">
                    <SideFeed name="RECENT"/>

                    <hr class="border-[#242c2e]">
                    <SideFeed name="COMMUNITIES"/>

                    <hr class="border-[#242c2e]">
                    <SideFeed name="RESOURCES"/>

                </div>

            </div>
            <div class="flex flex-col gap-4 items-center">

                <button class="bg-blue-500 rounded-md p-2" @click="getRequest">Communities</button>
                <button class="bg-blue-500 rounded-md p-2" @click="postRequest">not fixed btw</button>


                <div v-for="n in 5" :key="n">
                    <router-link :to="`/r/${n}/comments/${n}`">
                        <TextPost />
                    </router-link>
                </div>

            </div>



            </div>


    </main>
</template>

