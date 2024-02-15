<script setup lang="ts">

import {ref} from "vue";
import IconBookmark from "@/components/icons/IconBookmark.vue";
import IconUser from "@/components/icons/IconUser.vue";
import RowComponent from "@/components/RowComponent.vue";

const feedOpen = ref(true)

const props = defineProps({
    name: {
        required: true,
        type: String
    }
})

</script>

<template>
    <div>
        <div @click="feedOpen = !feedOpen"
             class="cursor-pointer flex items-center gap-2 h-10 w-full hover:bg-hover-dark rounded-lg select-none">
            <div class="grow text-xs">
                {{props.name}}
            </div>
            <icon-bookmark :class="{'rotate-180 duration-300':feedOpen}"/>
        </div>

        <transition name="slide-fade">
            <div v-if="feedOpen">
                <div v-for="n in 3" :key="n">
                    <RowComponent />
                </div>
            </div>
        </transition>
    </div>
</template>

<style scoped>
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.3s ease-out;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}
</style>
