<script setup lang="ts">

import {useRouter} from "vue-router";
import CommentsNavBar from "@/components/comments/CommentsNavBar.vue";
import CommentsMainContent from "@/components/comments/CommentsMainContent.vue";
import CommentsTextArea from "@/views/CommentsTextArea.vue";
import ArrowUpIcon from "@/components/icons/ArrowUpIcon.vue";
import ArrowDownIcon from "@/components/icons/ArrowDownIcon.vue";
import IconComments from "@/components/icons/IconComments.vue";
import IconDots from "@/components/icons/IconDots.vue";
import IconUser from "@/components/icons/IconUser.vue";

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


                    <div class="flex my-5" v-for="n in 10" :key="n">
                        <div class="w-10 mr-2 cursor-pointer flex-col">
                            <div>
                                <icon-user/>
                            </div>
                            <div>

                            </div>
                        </div>
                        <div class="w-full flex flex-col ">
                            <div class="text-xs hover:underline cursor-pointer">user</div>
                            <div>tag</div>
                            <div>Comment example </div>
                            <div class="flex items-center gap-2 ">
                                <div class="w-7 cursor-pointer hover:bg-gray-600 p-1 rounded-md">
                                    <arrow-up-icon/>
                                </div>
                                <div class="">21</div>
                                <div class="w-7 cursor-pointer hover:bg-gray-600 p-1 rounded-md">
                                    <arrow-down-icon/>
                                </div>
                                <div class="flex items-center gap-1 cursor-pointer hover:bg-gray-600 p-1 rounded-md">
                                    <div class="">
                                        <icon-comments/>
                                    </div>
                                    <div>Reply</div>
                                </div>
                                <div class="cursor-pointer hover:bg-gray-600 p-1 rounded-md">Share</div>
                                <div class="cursor-pointer hover:bg-gray-600 p-1 rounded-md">
                                    <icon-dots/>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>