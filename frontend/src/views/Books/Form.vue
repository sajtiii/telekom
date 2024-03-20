<template>
    <form class="w-2/3 space-y-6" @submit="onSubmit">
        <FormField v-slot="{ componentField }" name="username">
        <FormItem>
            <FormLabel>Username</FormLabel>
            <FormControl>
            <Input type="text" placeholder="shadcn" v-bind="componentField" />
            </FormControl>
            <FormDescription>
            This is your public display name.
            </FormDescription>
            <FormMessage />
        </FormItem>
        </FormField>
        <Button type="submit">
        Submit
        </Button>
    </form>
</template>


<script setup lang="ts">
import { defineProps } from 'vue';
import { RouterLink } from 'vue-router';
import { Button } from '@/components/ui/button'
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { toast } from '@/components/ui/toast'

defineProps({
    isCreate: Boolean,
    isShow: Boolean,
    id: Number,
})


const onSubmit = ((values: Object) => {
  toast({
    title: 'You submitted the following values:',
    description: values,
  })
})
</script>