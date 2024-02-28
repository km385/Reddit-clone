<script setup lang="ts">
import IconX from "@/components/icons/IconX.vue";
import {onBeforeUnmount, onMounted} from "vue";

const emit = defineEmits(['close'])
const props = defineProps({
    url: {
        type: String,
        required: true
    }
})

onMounted(() => {
    document.body.style.overflow = 'hidden'

})

onBeforeUnmount(() => {
    document.body.style.overflow = 'visible'
})

</script>
<template>
        <div
            :style="{ 'background-image': `url(${props.url})`}"
            @click.stop class="fixed inset-0 bg-gray-400 z-[9999] cursor-default">
            <icon-x @click="emit('close')"
                    class="z-10 fixed top-2 right-2 p-2 bg-black text-white rounded-full w-10 h-10 cursor-pointer"/>
            <img class="object-contain h-full w-full backdrop-blur-3xl"
                 :src="props.url"
                 alt="image">
        </div>
</template>
