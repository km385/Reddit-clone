<template>
    <div>
        <div class="border border-gray-600 focus-within:border-white rounded-3xl ">
            <textarea @click="show = true"
                class="text-white pl-3 pt-3 p-1 rounded-3xl bg-main-bg outline-0 w-full min-h-10 resize-y"
                placeholder="Add a comment"
                oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea>
            <div v-if="show" class="bg-main-bg rounded-b-3xl flex">
                <div class="grow" id="edits"></div>
                <div class="p-2">
                    <button class="rounded-full bg-white px-2 text-black ">Comment</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import {ref} from "vue";

const show = ref(false)
</script>