<script setup lang="ts">
import ArrowUpIcon from "@/components/icons/ArrowUpIcon.vue";
import ArrowDownIcon from "@/components/icons/ArrowDownIcon.vue";
import IconComments from "@/components/icons/IconComments.vue";
import IconShare from "@/components/icons/IconShare.vue";
import {ref} from "vue";
import ArrowUpFilledIcon from "@/components/icons/ArrowUpFilledIcon.vue";
import ArrowDownFilledIcon from "@/components/icons/ArrowDownFilledIcon.vue";

const isUpVoted = ref(false)
const isDownVoted = ref(false)

function upVote() {
    isUpVoted.value = !isUpVoted.value
    isDownVoted.value = false
}

function downVote() {
    isDownVoted.value = !isDownVoted.value
    isUpVoted.value = false
}
</script>
<template>
    <div class="flex justify-start gap-1 text-white py-1 text-sm">
        <div @click.stop
             :class="{'bg-orange-500':isUpVoted, 'bg-blue-500':isDownVoted}"
             class="bg-[#1a282d] rounded-full flex cursor-default">
            <div @click="upVote"
                 :class="{'hover:text-white':isUpVoted || isDownVoted,
                 'orange-hover':isUpVoted,
                 'blue-hover':isDownVoted}"
                 class="hover:text-red-600 hover:bg-hover-dark flex rounded-full p-2 cursor-pointer">
                <div v-if="!isUpVoted">
                    <arrow-up-icon class="w-4"/>
                </div>
                <div v-else>
                    <ArrowUpFilledIcon/>
                </div>
            </div>

            <div class="flex items-center">
                2332
            </div>

            <div @click="downVote"
                 :class="{'hover:text-white':isUpVoted || isDownVoted,
                 'orange-hover':isUpVoted,
                 'blue-hover':isDownVoted}"
                 class="hover:text-blue-600 hover:bg-hover-dark flex rounded-full p-2 cursor-pointer">
                <div v-if="!isDownVoted">
                    <arrow-down-icon class="w-4"/>
                </div>
                <div v-else>
                    <ArrowDownFilledIcon class=""/>
                </div>
            </div>
        </div>

        <div class="hover:bg-hover-dark bg-[#1a282d] rounded-full px-4 py-2 cursor-pointer flex items-center gap-1">
            <IconComments/>
            188
        </div>

        <div @click.stop class="hover:bg-hover-dark bg-[#1a282d] rounded-full px-4 py-2 cursor-pointer flex items-center gap-1">
            <IconShare/>
            Share
        </div>
    </div>
</template>

<style scoped>
    .orange-hover {
        @apply hover:bg-[#d93a00]
    }

    .blue-hover {
        @apply hover:bg-[#6a5cff]
    }
</style>