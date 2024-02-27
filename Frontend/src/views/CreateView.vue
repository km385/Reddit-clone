<script setup lang="ts">

import IconUser from "@/components/icons/IconUser.vue";
import IconAdd from "@/components/icons/IconAdd.vue";
import {onBeforeUnmount, onMounted, ref} from "vue";
import IconChevronUp from "@/components/icons/IconChevronUp.vue";

const title = ref("")
const postType = ref("")
const text = ref("")

const communities = ref(false)

function closeMenu(){
    communities.value = false
}


onMounted(() => {
    calculateMinHeight()
    window.addEventListener('resize', calculateMinHeight)
})

onBeforeUnmount(() => {
    window.removeEventListener('resize', calculateMinHeight)
})

const minHeight = ref("")

function calculateMinHeight() {
    const headerHeight = document.querySelector('header')?.offsetHeight;
    if(!headerHeight) {
        minHeight.value = '100vh'
        return
    }
    const windowHeight = window.innerHeight;
    minHeight.value = `calc(${windowHeight}px - ${headerHeight}px)`;
}
</script>

<template>
<!--    28px is a precise navbar height-->
    <div :style="{minHeight: minHeight}" class="mt-[28px] text-white bg-black flex justify-center">
        <div class="flex flex-col items-center w-[740px] mt-12">
            <!--        dropdown-->
            <div class="self-start w-fit bg-[#1a1a1b] border border-[#343536] rounded-sm mb-2 relative"
                 v-click-outside="closeMenu">
                <div class="flex items-center gap-2 p-2 ">
                    <div>
                        <icon-user class="w-8"/>
                    </div>
                    <div><input @focus="communities = true" type="text" class="bg-[#1a1a1b] grow outline-0"
                                placeholder="Choose a community"></div>
                    <div @click="communities = !communities" class="cursor-pointer">
                        <icon-chevron-up class="rotate-180"/>
                    </div>
                </div>
                <div
                    class="absolute bg-[#1a1a1b] z-20 w-full p-2 max-h-80 overflow-y-scroll scrollbar-styled border border-[#343536]"
                    v-if="communities">
                    <div v-for="n in 10" :key="n">
                        <div class="p-2">r/livestreamfail</div>
                    </div>
                </div>
            </div>

            <!--        post create-->
            <div class="flex flex-col bg-[#1a1a1b] w-full rounded-lg">
                <div class="flex border-b border-[#343536] cursor-pointer select-none">
                    <div @focus="postType = 'post'" tabindex="0"
                         class="border-r border-[#343536] rounded-tl-lg focus:bg-hover-dark focus:border-b-2 focus:border-b-white flex-1 flex justify-center items-center gap-2 py-2 hover:bg-hover-dark outline-0"
                         autofocus>
                        <div class="w-8">
                            <icon-user/>
                        </div>
                        post
                    </div>
                    <div @focus="postType = 'image'" tabindex="0"
                         class="border-r border-[#343536] focus:bg-hover-dark focus:border-b-2 focus:border-b-white flex-1 flex justify-center items-center gap-2 py-2 hover:bg-hover-dark">
                        <div class="w-8">
                            <icon-user/>
                        </div>
                        image & video
                    </div>
                    <div @focus="postType = 'link'" tabindex="0"
                         class="border-r border-[#343536] focus:bg-hover-dark focus:border-b-2 focus:border-b-white flex-1 flex justify-center items-center gap-2 py-2 hover:bg-hover-dark">
                        <div class="w-8">
                            <icon-user/>
                        </div>
                        link
                    </div>
                    <div @focus="postType = 'poll'" tabindex="0"
                         class="rounded-tr-lg focus:bg-hover-dark focus:border-b-2 focus:border-b-white flex-1 flex justify-center items-center gap-2 py-2 hover:bg-hover-dark">
                        <div class="w-8">
                            <icon-user/>
                        </div>
                        poll
                    </div>
                </div>
                <div class="p-4 flex flex-col gap-4">
                    <div tabindex="0"
                         class="flex items-center rounded-xl border-2 border-[#343536] focus-within:border-white">
                    <textarea maxlength="300"
                              oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'
                              class="min-h-3 rounded-xl pl-2 w-full grow bg-[#1a1a1b] resize-none outline-0 "
                              type="text"
                              placeholder="Title" v-model="title"></textarea>
                        <div>{{ title.length }}/300</div>
                    </div>
                    <div v-if="postType === 'image'">
                        <div id="content"
                             class="rounded-xl border border-dashed border-[#343536] flex justify-center items-center h-[278px]">
                            <div>
                                Drag and drop image or
                                <button class="border border-white rounded-full py-1 px-2 hover:bg-hover-dark">Upload
                                </button>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="postType === 'link'">link</div>
                    <div v-else-if="postType === 'post'">
                        <div
                            class="flex flex-col border border-[#343536] rounded-lg focus-within:border focus-within:border-white">
                            <div class="bg-[#272729] flex px-2 rounded-tl-lg">
                                <div class="flex gap-2 grow">
                                    <icon-add v-for="n in 10" :key="n"/>
                                </div>
                                <div>markdown mode</div>
                            </div>
                            <div class="rounded-b-lg">
                            <textarea
                                oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'
                                class="min-h-36 rounded-xl pl-4 w-full grow bg-[#1a1a1b] outline-0 "
                                type="text"
                                placeholder="text(optional)" v-model="text"></textarea>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="postType === 'poll'">poll</div>

                    <div class="flex gap-3">
                        <div
                            class="flex gap-1 rounded-full border border-[#343536] py-1 px-4 hover:bg-hover-light cursor-not-allowed">
                            <icon-add/>
                            OC
                        </div>
                        <div
                            class="flex gap-1 rounded-full border border-[#343536] py-1 px-4 hover:bg-hover-light cursor-not-allowed">
                            <icon-add/>
                            OC
                        </div>
                        <div
                            class="flex gap-1 rounded-full border border-white py-1 px-4 hover:bg-hover-light cursor-pointer">
                            <icon-add/>
                            OC
                        </div>
                        <div
                            class="flex gap-1 rounded-full border border-[#343536] py-1 px-4 hover:bg-hover-light cursor-not-allowed">
                            <icon-add/>
                            OC
                        </div>
                    </div>
                    <hr class="border border-[#343536]">
                    <div class="flex justify-end gap-2">
                        <button class="border border-white rounded-full px-4 py-1 hover:bg-hover-light">Cancel</button>
                        <button class="border border-white rounded-full px-4 py-1 bg-white text-black">Post</button>
                    </div>
                </div>
            </div>
        </div></div>
</template>

<style scoped>

</style>