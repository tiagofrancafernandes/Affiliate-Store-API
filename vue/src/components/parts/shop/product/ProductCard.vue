<template>
    <!-- https://flowbite.com/docs/components/card/#e-commerce-card -->
<div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <a href="#" class="img-container">
        <!-- <img class="p-8 rounded-t-lg" :src="mainImage.url" :alt="mainImage.alt" /> -->
        <img class="max-w-{899} s-899x567 object-contain" :src="mainImage.url" alt="descrição da imagem">
    </a>

    <div class="px-5 pb-3 pt-2">
        <a href="#">
            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                <span v-if="debug">{{ product.id }}</span>
                {{ product.name }}
            </h5>
        </a>

        <div
            class="flex items-center mt-2.5 mb-3"
            :class="{
                'py-3': !product.show_review_rating
            }"
        >
            <ProductRating
                :rating="product.review_rating"
                :hidden="!product.show_review_rating"
            />
        </div>

        <div class="flex items-center justify-between">
            <span class="text-3xl font-bold text-gray-900 dark:text-white">$599</span>
            <a href="#" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add to cart</a>
        </div>
    </div>
</div>
</template>

<script setup>
import { onMounted, computed, shallowRef, defineProps } from 'vue'
import ProductRating from '@/components/parts/shop/product/ProductRating.vue'
const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    debug: {
        type: Boolean,
    },
})

let mainImage = computed(() => {
    let images = props.product.images || [];
    let dummyImage = {
        alt: 'Product image',
        url: 'https://via.placeholder.com/899x567.png?text=899x567'
    };

    let image = images[0] || dummyImage;

    return {
        url: image.url || dummyImage.url,
        alt: image.alt || dummyImage.alt,
    }
})
let disabled = computed(() => !!props.disabled)
let debug = computed(() => !!props.debug)
</script>

<style scoped>
.img-container {
    max-height: 16rem;
    overflow-y: hidden;
    display: block;
    display: flex;
    align-items: center;
    justify-content: center;
    /* border-radius: inherit; */
    /* border-top-left-radius: 0.5rem; */
    border-top-left-radius: inherit;
    /* border-top-right-radius: 0.5rem; */
    border-top-right-radius: inherit;
}
</style>
