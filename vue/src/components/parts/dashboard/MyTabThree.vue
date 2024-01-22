<script setup>
import { ref } from 'vue'
const msg = ref('')
</script>

<template>
  <p>Current component: MyTabThree</p>
  <span>Message is: {{ msg }}</span>
  <input v-model="msg">
</template>
