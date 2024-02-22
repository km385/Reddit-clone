<script setup lang="ts">

import {onBeforeUnmount, onMounted, ref} from "vue";
import IconX from "@/components/icons/IconX.vue";
import LoginComponent from "@/components/login/LoginComponent.vue";
import RegisterComponent from "@/components/login/RegisterComponent.vue";

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

const isLoginScreen = ref(true)
const isRegisterScreen = ref(false)

function close() {
    emit('close')
}

function handleNav(nextComponentName:string) {
    isLoginScreen.value = nextComponentName === 'login';
    isRegisterScreen.value = nextComponentName === 'signup';

}
</script>

<template>
    <div
        class="fixed top-0 left-0 bg-gray-800/30 w-full h-full flex items-center justify-center rounded-xl "
    >
        <div class="bg-[#0f1a1c] rounded-xl w-[530px] h-[630px] relative shadow-black shadow-xl !pointer-events-auto"
             v-click-outside="close">
            <div @click="close" class="absolute top-0 right-0 m-2 hover:bg-hover-dark cursor-pointer p-3 rounded-full">
                <IconX/>
            </div>
            <LoginComponent v-if="isLoginScreen" @navigate="handleNav"/>
            <RegisterComponent v-else-if="isRegisterScreen" @navigate="handleNav"/>
        </div>

    </div>
</template>