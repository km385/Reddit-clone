<script setup lang="ts">
const emit = defineEmits(['navigate'])
</script>
<template>
    <div class="flex flex-col gap-3 p-16">
        <div><p class="text-3xl font-bold">Log in</p></div>
        <div>
            <p class="text-sm">
                By continuing, you agree to our User Agreement and acknowledge that you understand the Privacy
                Policy.
            </p>
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
            <input type="text" placeholder="Username *"
                   class="rounded-full w-full py-3 px-6 bg-[#1a282d] hover:bg-[#223237] cursor-text">
        </div>
        <div>
            <input type="password" placeholder="Password *"
                   class="rounded-full w-full py-3 px-6 bg-[#1a282d] hover:bg-[#223237] cursor-text">
        </div>
        <div>
            <p>Forgot your <span class="text-blue-600 hover:underline cursor-pointer">username</span> or <span
                class="text-blue-600 hover:underline cursor-pointer">password</span>?
            </p>
        </div>
        <div>
            <p>New to Reddit? <span @click.stop="emit('navigate', 'signup')"
                                     class="text-blue-600 hover:underline cursor-pointer">Sign Up</span></p>
        </div>
        <div>
            <button class="w-full bg-red-700 rounded-full py-3">Log in</button>
        </div>
    </div>
</template>
