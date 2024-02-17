<script setup lang="ts">

import {useRouter} from "vue-router";
import CommentsMainContent from "@/components/comments/CommentsMainContent.vue";
import CommentsTextArea from "@/components/comments/CommentsTextArea.vue";
import CommentPost from "@/components/comments/CommentPost.vue";

const router = useRouter()
function goBack() {
    router.back()
}
</script>

<template>
    <div class="max-w-[700px]" @click.self="goBack">

        <div class="py-2">
<!--            <CommentsNavBar/>-->
            <div class=" flex flex-col mt-10 bg-main-bg rounded-md">
                <CommentsMainContent/>


                <div class="text-white mt-10 mx-12">
                    <CommentsTextArea/>

                    <div class="my-5" v-for="n in 10" :key="n">
                        <div class="flex">
                            <div v-for="m in n" :key="m">
                                <div class="w-5 h-full"></div>
                            </div>
                            <CommentPost/>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>