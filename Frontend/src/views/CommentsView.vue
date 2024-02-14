<script setup lang="ts">

import {useRouter} from "vue-router";
import CommentsNavBar from "@/components/comments/CommentsNavBar.vue";
import CommentsMainContent from "@/components/comments/CommentsMainContent.vue";
import CommentsTextArea from "@/views/CommentsTextArea.vue";

const router = useRouter()
function goBack() {
    router.back()
}
</script>

<template>
    <div class="bg-gray-600/30" @click.self="goBack">

        <div class=" w-4/5 mx-auto py-2 bg-black ">
            <CommentsNavBar/>
            <div class="mx-20 flex flex-col mt-10 mr-[400px] bg-[#1a1a1b] rounded-md">
                <CommentsMainContent/>


                <div class="text-white mx-12">
                    <CommentsTextArea/>


                    <div class="" v-for="n in 10" :key="n">
                        <div class="h-20 my-5 w-full bg-gray-500">
                            Comment example
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>