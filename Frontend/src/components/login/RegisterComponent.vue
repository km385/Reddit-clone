<script setup lang="ts">

const emit = defineEmits(['navigate'])
</script>

<template>
    <div class="flex flex-col gap-3 p-16">
        <div><p class="text-3xl font-bold">Sign Up</p></div>
        <div>
            <p class="text-sm">By continuing, you agree to our User Agreement and acknowledge that you understand the
                Privacy Policy.</p>
        </div>
        <div class="flex gap-1">
            <input type="checkbox" id="agreement">
            <label for="agreement">I agree to get emails about cool stuff on Reddit</label>
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
            <input type="email" placeholder="Email*"
                   class="rounded-full w-full py-3 px-6 bg-[#1a282d] hover:bg-[#223237] cursor-text">
        </div>

        <div>
            <p>Already a redditor?
                <span @click.stop="emit('navigate', 'login')" class="text-blue-600 hover:underline cursor-pointer">Login In</span>
            </p>
        </div>

        <div>
            <button class="w-full bg-red-700 rounded-full py-3">Continue</button>
        </div>
    </div>
</template>

<style scoped>

</style>