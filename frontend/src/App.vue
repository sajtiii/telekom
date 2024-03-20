<template>
  <header>
    <h1 class="text-center text-4xl mt-5 font-bolder tracking-wide">Book management site</h1>
    <div>
      <RouterLink to="{ name: 'books.create' }" class="text-center text-2xl mt-5 font-bolder tracking-wide"><Plus class="size-4"/> Create new</RouterLink>
    </div>
  </header>

  <div clas="container">
    <RouterView />
  </div>
</template>

<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router';
import { Plus } from 'lucide-vue-next';
</script>