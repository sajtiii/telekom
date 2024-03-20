<template>
  <header>
    <h1 class="text-center text-4xl mt-5 font-bolder tracking-wide">Book management site</h1>
  </header>

  <div clas="container">
    <RouterView />
  </div>

  <Toaster />
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router';
import Toaster from '@/components/ui/toast/Toaster.vue';
</script>