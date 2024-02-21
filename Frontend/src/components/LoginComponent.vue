<script setup lang="ts">

import {onBeforeUnmount, onMounted} from "vue";
import IconX from "@/components/icons/IconX.vue";

let overflowValue:string = ''
let pointerEventsValue:string = ''
onMounted(() => {
    overflowValue = document.body.style.overflow
    pointerEventsValue = document.body.style.pointerEvents
    document.body.style.overflow = 'hidden'
    document.body.style.pointerEvents = 'none'
})

onBeforeUnmount(() => {
    document.body.style.overflow = overflowValue
    document.body.style.pointerEvents = pointerEventsValue
})

const emit = defineEmits(['close'])

function close() {
    emit('close')
}
</script>

<template>
    <div
        class="fixed top-0 left-0 bg-gray-800/30 w-full h-full flex items-center justify-center rounded-xl "
    >
        <div class="bg-[#0f1a1c] rounded-xl w-[530px] relative shadow-black shadow-xl !pointer-events-auto"
             v-click-outside="close">
            <div @click="close" class="absolute top-0 right-0 m-2 hover:bg-hover-dark cursor-pointer p-3 rounded-full">
                <IconX/>
            </div>
            <div class="flex flex-col gap-3 p-16">
                <div><p class="text-3xl font-bold">Log in</p></div>
                <div>
                    <p class="text-sm">
                        By continuing, you agree to our User Agreement and acknowledge that you understand the Privacy
                        Policy.
                    </p>
                </div>
                <div><p class="bg-white rounded-full p-3 text-black text-center cursor-pointer">login with google</p></div>
                <div><p class="bg-white rounded-full p-3 text-black text-center cursor-pointer">login with google</p></div>
                <div class="flex justify-center">
                    <div>
                        <hr class="border-white">
                    </div>
                    <div>or</div>
                    <div>
                        <hr>
                    </div>
                </div>
                <div>
                    <input type="text" placeholder="Username *"
                           class="rounded-full w-full py-3 px-6 bg-[#1a282d] hover:bg-[#223237] cursor-text">
                </div>
                <div>
                    <input type="text" placeholder="Password *"
                           class="rounded-full w-full py-3 px-6 bg-[#1a282d] hover:bg-[#223237] cursor-text">
                </div>
                <div>
                    <p>Forgot your <span class="text-blue-600 hover:underline cursor-pointer">username</span> or <span
                        class="text-blue-600 hover:underline cursor-pointer">password</span>?
                    </p>
                </div>
                <div><p>New to Reddit? <span class="text-blue-600 hover:underline cursor-pointer">Sign Up</span></p></div>
                <div>
                    <button class="w-full bg-red-700 rounded-full py-3">Log in</button>
                </div>
            </div>
        </div>

    </div>
</template>