<script setup lang="ts">

import IconUser from "@/components/icons/IconUser.vue";
import IconAdd from "@/components/icons/IconAdd.vue";
import {ref} from "vue";

const title = ref("")
</script>

<template>
    <div class="mt-12 text-white min-h-screen">
        <div class="flex flex-col bg-[#1a1a1b] w-[740px] mx-auto rounded-lg">
            <div class="flex border-b border-[#343536] cursor-pointer">
                <div tabindex="0" class="border-r border-[#343536] rounded-tl-lg focus:bg-hover-dark focus:border-b-2 focus:border-b-white flex-1 flex justify-center items-center gap-2 py-2 hover:bg-hover-dark"><div class="w-8"><icon-user/></div>post</div>
                <div tabindex="0" class="border-r border-[#343536] focus:bg-hover-dark focus:border-b-2 focus:border-b-white flex-1 flex justify-center items-center gap-2 py-2 hover:bg-hover-dark"><div class="w-8"><icon-user/></div>image & video</div>
                <div tabindex="0" class="border-r border-[#343536] focus:bg-hover-dark focus:border-b-2 focus:border-b-white flex-1 flex justify-center items-center gap-2 py-2 hover:bg-hover-dark"><div class="w-8"><icon-user/></div>link</div>
                <div tabindex="0" class="border-r border-[#343536] rounded-tr-lg focus:bg-hover-dark focus:border-b-2 focus:border-b-white flex-1 flex justify-center items-center gap-2 py-2 hover:bg-hover-dark"><div class="w-8"><icon-user/></div>poll</div>
            </div>
            <div class="p-4 flex flex-col gap-4">
                <div tabindex="0" class="flex items-center rounded-xl border-2 border-[#343536] focus-within:border-white">
                    <textarea maxlength="300" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'
                              class="min-h-3 rounded-xl pl-2 w-full grow bg-[#1a1a1b] resize-none outline-0 " type="text"
                              placeholder="Title" v-model="title"></textarea>
                    <div>{{title.length}}/300</div>
                </div>
                <div id="content" class="rounded-xl border border-dashed border-[#343536] flex justify-center items-center h-[278px]">
                    <div>
                        Drag and drop image or
                        <button class="border border-white rounded-full py-1 px-2 hover:bg-hover-dark">Upload</button>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex gap-1 rounded-full border border-[#343536] py-1 px-4 hover:bg-hover-light cursor-not-allowed"><icon-add/>OC</div>
                    <div class="flex gap-1 rounded-full border border-[#343536] py-1 px-4 hover:bg-hover-light cursor-not-allowed"><icon-add/>OC</div>
                    <div class="flex gap-1 rounded-full border border-white py-1 px-4 hover:bg-hover-light cursor-pointer"><icon-add/>OC</div>
                    <div class="flex gap-1 rounded-full border border-[#343536] py-1 px-4 hover:bg-hover-light cursor-not-allowed"><icon-add/>OC</div>
                </div>
                <hr class="border border-[#343536]">
                <div class="flex justify-end gap-2">
                    <button class="border border-white rounded-full px-4 py-1 hover:bg-hover-light">Cancel</button>
                    <button class="border border-white rounded-full px-4 py-1 bg-white text-black">Post</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>