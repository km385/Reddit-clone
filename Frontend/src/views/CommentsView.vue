<script setup lang="ts">

import {useRouter} from "vue-router";
import CommentsMainContent from "@/components/comments/CommentsMainContent.vue";
import CommentsTextArea from "@/components/comments/CommentsTextArea.vue";
import CommentPost from "@/components/comments/CommentPost.vue";
import IconChevronUp from "@/components/icons/IconChevronUp.vue";

const router = useRouter()
function goBack() {
    router.back()
}
</script>

<template>
    <div class="flex justify-between gap-32 w-full">
        <div class="max-w-[700px]" @click.self="goBack">
            <div class=" flex flex-col bg-main-bg rounded-md">
                <CommentsMainContent/>


                <div class="text-white mt-10 mx-12">
                    <CommentsTextArea/>

                    <div class="my-5" v-for="n in 10" :key="n">
                        <div class="flex">
                            <div v-for="m in n" :key="m">
                                <div class="w-10 h-full"></div>
                            </div>
                            <CommentPost/>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="
        w-1/3 hidden xl:flex flex-col gap-4
        sticky top-16 overflow-hidden hover:overflow-y-scroll h-[90vh]
        bg-black rounded-lg p-4 scrollbar-styled">
            <div>
                <h1 class="text-gray-300">
                    r/LivestreamFail: Livestream wins, fails, and everything in between
                </h1>
                <h2 class="text-gray-500">
                    The place for all things livestreaming.
                </h2>
            </div>

            <div class="flex gap-32">
                <div class="flex flex-col">
                    <div>
                        2.7M
                    </div>
                    <div>
                        Members
                    </div>
                </div>

                <div class="flex flex-col">
                    <div>
                        6.7K
                    </div>
                    <div>
                        Online
                    </div>
                </div>
            </div>

            <hr>

            <div>
                <div>
                    Rules
                </div>
                <div class="flex flex-col" v-for="n in 14" :key="n">
                    <div class="flex justify-between h-14 hover:bg-hover-dark cursor-pointer">
                        <div class="pl-3">{{n}}</div>
                        <div>The rule in question</div>
                        <div class="pr-3"><icon-chevron-up class="rotate-180"/></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>