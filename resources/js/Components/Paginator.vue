<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});
</script>


<template>
    <div v-if="data.links.length > 3" class="flex justify-center mt-4 space-x-4">
        <Link
            v-for="(link, k) in data.links"
            :key="k"
            class="px-4 py-3 text-sm leading-4 bg-white  text-gray-900 rounded hover:bg-blue-400 focus:text-indigo-600 hover:shadow"
            :class="{'bg-blue-600 text-indigo-600': link.active}"
            :href="link.url"
            v-html="link.label"
        />
    </div>
</template>
