<template>
  <html>
    <head>
      <title>Book management site</title>
    </head>
    <body :class="{ dark: darkModeEnabled }">
      <div id="app" class="min-w-screen min-h-screen pt-5">
        <div class="max-w-full md:max-w-[50%] mx-auto">
          <header class="relative">
            <div class="absolute top-0 right-0 mt-2">
              <Button
                type="button"
                variant="outline"
                class="rounded-full px-2 py-2"
                @click="darkModeEnabled = !darkModeEnabled"
              >
                <Sun class="w-6 h-6" v-if="darkModeEnabled" />
                <Moon class="w-6 h-6" v-else />
              </Button>
            </div>

            <h1 class="text-center text-4xl font-bolder tracking-wide">Book management site</h1>
          </header>

          <div id="content" class="mt-20 border rounded p-4">
            <RouterView />
          </div>
        </div>
      </div>
    </body>
  </html>

  <Toaster />
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { RouterView } from 'vue-router'
import Toaster from '@/components/ui/toast/Toaster.vue'
import { Button } from '@/components/ui/button'
import { Sun, Moon } from 'lucide-vue-next'

const darkModeEnabled = ref(false)
</script>
