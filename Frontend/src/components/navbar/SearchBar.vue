<template>
    <div class="flex cursor-pointer h-full py-1 min-w-20">
        <input type="search"
               class="search rounded-full pl-14 text-white w-full text-sm outline-0 ring-0 border-none"
               placeholder="Search Reddit">
    </div>
</template>
<script lang="ts">
export default {
    name: 'SearchBar'
}
</script>
<style scoped>
input.search {
    background: #1a282d no-repeat 10px url("../../assets/search.svg");
    background-size: 24px;
}

input.search:hover {
    background-color: #223237;
}

</style>