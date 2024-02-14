<template>
    <div>
        <div>
            <p>Comment as <span class="text-blue-600 hover:underline cursor-pointer">user</span></p>
        </div>
        <div class="border border-gray-600 focus-within:border-white rounded-md ">
                        <textarea
                            class="text-white pl-3 p-1 rounded-t-md bg-[#1a1a1b] outline-0 w-full min-h-40 resize-y"
                            placeholder="What are your thoughts?"
                            oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea>
            <div class="bg-[#272729] rounded-b-md flex">
                <div class="grow" id="edits"></div>
                <div class="p-2">
                    <button class="rounded-full bg-white px-2 text-black ">Comment</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'CommentsTextArea'
}
</script>