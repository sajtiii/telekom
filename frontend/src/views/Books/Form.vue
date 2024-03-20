<template>
    <form class="w-2/3 space-y-6" @submit.prevent="handleSubmit">
      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <FormField name="title">
            <FormItem>
              <FormLabel>Title</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Title of the book" v-model="book.title" :disabled="isShow" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
        </div>
        <div>
          <FormField name="author">
            <FormItem>
              <FormLabel>Author</FormLabel>
              <FormControl>
                <Input type="text" placeholder="Author of the book" v-model="book.author" :disabled="isShow" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
        </div>
      </div>
      <div class="grid md:grid-cols-4 gap-4">
        <div>
          <FormField name="isbn">
            <FormItem>
              <FormLabel>ISBN</FormLabel>
              <FormControl>
                <Input type="text" placeholder="ISBN identifier" v-model="book.isbn" :disabled="isShow" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
        </div>
        <div>
          <FormField name="publish_date">
            <FormItem>
              <FormLabel>Publish Date</FormLabel>
              <FormControl>
                <Input type="date" placeholder="Publish date of the book" v-model="book.publish_date" :disabled="isShow" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
        </div>
        <div>
          <FormField name="on_store">
            <FormItem>
              <FormLabel>On Store Qty.</FormLabel>
              <FormControl>
                <Input type="number" placeholder="On store quantity" v-model="book.on_store" min="0" step="1" :disabled="isShow" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
        </div>
        <div>
          <FormField name="price">
            <FormItem>
              <FormLabel>Price</FormLabel>
              <FormControl>
                <Input type="number" placeholder="Price of the book" v-model="book.price" min="0" step="1" :disabled="isShow" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
        </div>
      </div>
      <div class="grid md:grid-cols-1 gap-4">
        <div>
          <FormField name="summary">
            <FormItem>
              <FormLabel>Summary</FormLabel>
              <FormControl>
                <Textarea placeholder="Summary from the book" v-model="book.summary" :disabled="isShow" />
              </FormControl>
              <FormMessage />
            </FormItem>
          </FormField>
        </div>
      </div>
      <div class="flex justify-end">
          <RouterLink :to="{ name: 'books.index' }">
            <Button type="button" variant="link" class="mr-2">
              <X class="w-4 h-4 mr-2" /> Cancel
            </Button>
          </RouterLink>
        <div v-if="!props.isShow">
          <RouterLink :to="{ name: 'books.show', params: { id: route.params.id } }" v-if="!props.isCreate">
            <Button type="button" variant="outline" class="mr-2">
              <Eye class="w-4 h-4 mr-2" /> View
            </Button>
          </RouterLink>
          <Button type="button" v-if="loading">
            <Loader2 class="w-4 h-4 mr-2 animate-spin" /> Saving
          </Button>
          <Button type="submit" v-if="!loading">
            <Check class="w-4 h-4 mr-2" /> Save
          </Button>
        </div>
        <div v-else>
          <RouterLink :to="{ name: 'books.edit', params: { id: route.params.id } }">
            <Button type="button" variant="outline">
              <Pencil class="w-4 h-4 mr-2" /> Edit
            </Button>
          </RouterLink>
        </div>
      </div>
    </form>
</template>


<script setup lang="ts">
import { defineProps, ref, onMounted } from 'vue';
import { useRoute, useRouter, RouterLink } from 'vue-router';
import axios from 'axios';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { useToast } from '@/components/ui/toast';
import { Button } from '@/components/ui/button';
import { Loader2, Pencil, Eye, Check, X } from 'lucide-vue-next';

const { toast } = useToast();

const route = useRoute();
const router = useRouter();

const props = defineProps<{
  isCreate: Boolean,
  isShow: Boolean,
}>();


interface Book {
  title: string;
  author: string;
  isbn: string;
  publish_date: string;
  on_store: number;
  summary: string;
  price: number;
}

const book = ref({} as Book);
const validationErrors = ref({} as any);
const loading = ref(false);

onMounted(() => {
  fetchBook();
});

const fetchBook = async () => {
  if (props.isCreate) {
    return;
  }

  loading.value = true;
  axios.get('http://localhost:8000/api/books/' + route.params.id)
    .then(response => {
      let data = response.data.data;
      delete data.id;
      data.publish_date = data.publish_date.split(' ')[0];
      book.value = data;
    })
    .catch(error => {
      if (error.response.status === 404) {
        toast({
          title: 'Book not found',
          description: 'The book you are looking for does not exist.',
          variant: 'destructive',
        });
      } else {
        toast({
          title: 'Uh oh! Something went wrong.',
          description: 'There was a problem with your request. Please contact support.',
          variant: 'destructive',
        });
      }
      router.push({ name: 'books.index' });
    })
    .finally(() => {
      loading.value = false;
    });
};

const handleSubmit = ((values: any) => {
  if (props.isShow) {
    return;
  }  

  loading.value = true;
  axios({
      method: props.isCreate ? 'post' : 'put',
      url: 'http://localhost:8000/api/books/' + (props.isCreate ? '' : route.params.id),
      data: book.value,
    })
    .then(response => {
      toast({
        title: 'Book ' + (props.isCreate ? 'created' : 'updated') + ' successfully',
        description: 'The book has been ' + (props.isCreate ? 'created' : 'updated') + ' successfully',
      });
      
      router.push({ name: 'books.show', params: { id: response.data.data.id } });
    })
    .catch(error => {
      if (error.response.status === 422) {
        validationErrors.value = error.response.data.errors;
      } else {
        toast({
          title: 'Uh oh! Something went wrong.',
          description: 'There was a problem with your request. Please contact support.',
          variant: 'destructive',
        });
      }
    })
    .finally(() => {
      loading.value = false;
    });
})
</script>