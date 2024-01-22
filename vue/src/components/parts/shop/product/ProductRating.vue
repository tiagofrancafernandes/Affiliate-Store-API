<template>
    <div
        v-if="!hidden"
        class="flex items-center space-x-1 rtl:space-x-reverse"
    >
        <template
            v-for="star in getStars"
            v-key="star.starNum"
        >
            <svg v-if="star.fill" class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>

            <svg v-else class="w-4 h-4 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>

        </template>
        <span
            class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ms-3"
        >{{ getRating + ' / 5' }}</span>
    </div>
</template>

<script setup>
import { onMounted, computed, shallowRef, defineProps } from 'vue'
const props = defineProps({
    rating: {
        type: Number,
    },
    hidden: {
        type: Boolean,
    },
})

let getRating = computed(() => {
    let rating = parseFloat(props.rating);

    if (isNaN(rating)) {
        return 0
    }

    if (rating > 5) {
        return 5
    }

    if (rating < 0) {
        return 0
    }

    return rating
})

let getStars = computed(() => {
    let rating = getRating.value;
    let stars = [];

    [...Array(5).keys()].forEach(item => {
        if (rating <= 0) {
            stars.push({
                fill: false,
                starNum: parseInt(item) + 1,
            });
            return;
        }

        stars.push({
            fill: (item < rating),
            starNum: parseInt(item) + 1,
        });
    })

    return stars;
})
let hidden = computed(() => !(getRating.value >= 0 ) || props.hidden)
</script>
