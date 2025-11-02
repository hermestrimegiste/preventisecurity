<script setup>
import { Link } from '@inertiajs/vue3';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid';

defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
        <div class="-mt-px flex w-0 flex-1">
            <Link
                v-if="links[0].url"
                :href="links[0].url"
                class="inline-flex items-center border-t-2 border-transparent pr-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700"
            >
                <ChevronLeftIcon class="mr-3 h-5 w-5 text-gray-400" />
                Previous
            </Link>
        </div>
        <div class="hidden md:-mt-px md:flex">
            <template v-for="(link, index) in links.slice(1, -1)" :key="index">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    :class="[
                        link.active
                            ? 'border-medicare-500 text-medicare-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                        'inline-flex items-center border-t-2 px-4 pt-4 text-sm font-medium',
                    ]"
                    v-html="link.label"
                />
                <span
                    v-else
                    class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500"
                    v-html="link.label"
                />
            </template>
        </div>
        <div class="-mt-px flex w-0 flex-1 justify-end">
            <Link
                v-if="links[links.length - 1].url"
                :href="links[links.length - 1].url"
                class="inline-flex items-center border-t-2 border-transparent pl-1 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700"
            >
                Next
                <ChevronRightIcon class="ml-3 h-5 w-5 text-gray-400" />
            </Link>
        </div>
    </nav>
</template>

