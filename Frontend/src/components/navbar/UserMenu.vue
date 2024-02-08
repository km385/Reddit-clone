<template>
    <div class="flex items-center gap-1 w-64 cursor-pointer">
        <div class="w-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd"
                      d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>
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
<script>
export default {
    name: 'UserMenu'
}
</script>