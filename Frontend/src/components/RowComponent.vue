<script setup lang="ts">

import IconUser from "@/components/icons/IconUser.vue";
import IconStar from "@/components/icons/IconStar.vue";
import {ref} from "vue";
import IconStarFill from "@/components/icons/IconStarFill.vue";

const props = defineProps({
    hasFavoriteIcon: {
        default: false,
        type: Boolean
    },
    name: {
        required: true,
        type: String
    }
})

const isStarFilled = ref(false)

</script>

<template>
    <div class="flex items-center gap-2 h-10 w-full cursor-pointer hover:bg-hover-light rounded-lg px-3">
        <div class="w-6 text-white ">
            <icon-user/>
        </div>
        <div class="grow">
            {{ props.name }}
        </div>
        <div v-if="props.hasFavoriteIcon" @click="isStarFilled = !isStarFilled" class="hover:bg-hover-dark rounded-full p-2">
            <div v-if="isStarFilled">
                <icon-star-fill/>
            </div>
            <div v-else>
                <icon-star/>
            </div>
        </div>
    </div>
</template>