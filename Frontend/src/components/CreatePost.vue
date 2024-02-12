<template>
    <div class="flex items-center gap-1 bg-[#1a1a1b] w-[600px] p-2 rounded-md outline outline-1 outline-[#343536]">
        <div class="w-10 cursor-pointer">
            <IconUser/>
        </div>
        <div class="grow h-full flex">
            <input type="text"
                   class="search rounded-md w-full pl-4 text-white border border-gray-700 text-sm bg-[#272729]
                               hover:border-gray-400
                               focus:border-gray-400 focus:outline-0"
                   placeholder="Create Post">
        </div>

        <div class="text-gray-400 cursor-pointer hover:bg-[#2d2d2e] p-2 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z"/>
            </svg>
        </div>
        <div class="text-gray-400 cursor-pointer hover:bg-[#2d2d2e] p-2 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16">
                <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1 1 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4 4 0 0 1-.128-1.287z"/>
                <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243z"/>
            </svg>
        </div>
    </div>
</template>
<script lang="ts">
import IconUser from "@/components/icons/IconUser.vue";

export default {
    name: 'CreatePost',
    components: {IconUser}
}
</script>