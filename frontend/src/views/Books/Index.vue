<template>
  <div>
      <div v-if="loading">
        <h1 class="text-xl font-bold center">Loading books...</h1>
      </div>
      <div v-else>
        <Table>
          <TableCaption>Books</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead class="text-center">ID</TableHead>
              <TableHead>Title</TableHead>
              <TableHead>Author</TableHead>
              <TableHead>ISBN</TableHead>
              <TableHead>On Store</TableHead>
              <TableHead class="text-right">Actions</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="book in books" :key="book.id">
              <TableCell class="text-center">{{ book.id }}</TableCell>
              <TableCell>{{ book.title }}</TableCell>
              <TableCell>{{ book.author }}</TableCell>
              <TableCell>{{ book.isbn }}</TableCell>
              <TableCell>{{ book.on_store }}</TableCell>
              <TableCell class="text-right">
                <div class="flex items-center justify-end">
                  <RouterLink :to="{ name: 'books.show', params: { id: book.id } }" class="mr-2">View</RouterLink>
                  <DropdownMenu>
                    <DropdownMenuTrigger><Ellipsis class="size-4" /></DropdownMenuTrigger>
                    <DropdownMenuContent>
                      <DropdownMenuItem>
                        <RouterLink :to="{ name: 'books.show', params: { id: book.id } }" class="cursor-pointer">
                          <div class="flex items-center">
                            <div class="mr-2">
                              <Pencil class="size-4" />
                            </div>
                            <div>
                              Edit
                            </div>
                          </div>
                        </RouterLink>
                      </DropdownMenuItem>
                      <DropdownMenuItem>
                        <a class="text-red-500 cursor-pointer" @click="deleteBook(book.id)">
                          <div class="flex items-center">
                            <div class="mr-2">
                              <Trash2 class="size-4" />
                            </div>
                            <div>
                              Delete
                            </div>
                          </div>
                        </a>
                      </DropdownMenuItem>
                    </DropdownMenuContent>
                  </DropdownMenu>
                </div>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { Trash2, Ellipsis, Pencil } from 'lucide-vue-next'
const books = ref()
const loading = ref(true)

onMounted(() => {
  console.log('loading');
  axios.get('http://localhost:8000/api/books')
    .then(response => {
      books.value = response.data.data
    })
    .catch(error => {
      console.log(error)
    })
    .finally(() => {
      loading.value = false
    })
});

function deleteBook(id: number) {
  axios.delete(`http://localhost:8000/api/books/${id}`)
    .then(response => {
      books.value = books.value.filter((book: any) => book.id !== id)
    })
    .catch(error => {
      console.log(error)
    })
}

</script>
