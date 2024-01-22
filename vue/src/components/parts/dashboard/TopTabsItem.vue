<template>
    <li class="me-2">
        <button
            type="button"
            v-bind:class="{
                'inline-block p-4 rounded-t-lg': true,
                'active text-blue-600 bg-gray-100 dark:bg-gray-800 dark:text-blue-500': active,
                'hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300': !active,
                'text-gray-400 cursor-not-allowed dark:text-gray-500' : disabled,
            }"
            v-bind:disabled="disabled"
        >
            <slot />
        </button>
    </li>
</template>

<script setup>
import { onMounted, computed, shallowRef, defineProps } from 'vue'
const props = defineProps({
    active: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
})

let active = computed(() => !!props.active)
let disabled = computed(() => !!props.disabled)
</script>
