<template>
    <div class="w-[340px] flex flex-col rounded-md border border-gray-600">
        <div
            class="h-8 bg-gray-500 rounded-t-md bg-cover bg-center bg-no-repeat"
            style="background-image: url('https://www.redditstatic.com/desktop2x/img/id-cards/home-banner@2x.png')">
        </div>
        <div class="flex px-2 items-center gap-4 pt-1 bg-[#1a1a1b]">
            <div class="w-12">
                <IconUser/>
            </div>
            <div>
                <p class="text-xl">Home</p>
            </div>
        </div>
        <div class="bg-[#1a1a1b] px-2 pt-2">
            <p class="text-sm">
                Your personal Reddit frontpage. Come here to check in with your favorite communities.
            </p>
        </div>
        <div class="bg-[#1a1a1b] px-2 py-4">
            <hr class="border-gray-600">
        </div>
        <div class="bg-[#1a1a1b] px-2 pb-4 flex flex-col gap-2 rounded-b-md">
            <div class="rounded-full bg-white py-1 cursor-pointer">
                <p class="text-black font-medium text-center">Create Post</p>
            </div>

            <div class="rounded-full border border-white py-1 cursor-pointer">
                <p class="text-white font-medium text-center">Create Community</p>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
import IconUser from "@/components/icons/IconUser.vue";

export default {
    name: 'HomeCommunity',
    components: {IconUser}
}
</script>