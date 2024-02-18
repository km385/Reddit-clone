<script setup lang="ts">

import axios from "axios";
import {onMounted, ref} from "vue";
import {useRoute, useRouter} from "vue-router";
import CommunitySidebar from "@/views/CommunitySidebar.vue";

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
    <main class="text-white mt-12 flex justify-center">
        <div class="flex min-h-screen w-4/5 gap-32">
            <div class="z-20 bg-main-bg hidden xl:block ">
                <CommunitySidebar/>
            </div>

            <div class="grow flex flex-col gap-4 items-center scroll-smooth">
                <button class="bg-blue-500 rounded-md p-2" @click="getRequest">Communities</button>
                <button class="bg-blue-500 rounded-md p-2" @click="postRequest">not fixed btw</button>
                <router-link :to="{name: 'community', params: { community: 'livestreamfail'}}">
                    <button class="bg-blue-500 rounded-md p-2">Community</button>
                </router-link>

                <router-view></router-view>

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

