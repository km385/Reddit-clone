<template>
    <div class="w-52 cursor-pointer flex items-center gap-2 hover:outline hover:outline-1 hover:outline-gray-400 h-4/5 p-2 rounded-md ">
        <div class="w-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
            </svg>
        </div>
        <div class="grow">
            Home
        </div>
        <div class="w-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="white" class="bi bi-chevron-down" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
            </svg>
        </div>
    </div>
</template>
<script lang="ts">
export default {
    name: 'SubRedditsMenu'
}
</script>