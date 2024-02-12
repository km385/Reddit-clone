<template>
    <div class="flex items-center gap-1 w-64 cursor-pointer h-4/5 hover:outline hover:outline-1 hover:outline-gray-400 rounded-md p-2">
        <div class="w-6">
            <IconUser/>
        </div>
        <div class="flex flex-col grow">
            <div class="text-sm">username</div>
            <div class="text-xs">302 karma</div>
        </div>
        <div class="mr-2 w-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="white" class="bi bi-chevron-down" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
            </svg>
        </div>
    </div>
</template>
<script lang="ts">
import IconUser from "@/components/icons/IconUser.vue";

export default {
    name: 'UserMenu',
    components: {IconUser}
}
</script>