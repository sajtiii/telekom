<template>
  <div>
    <div class="flex items-center justify-between mb-3">
      <div class="relative w-full max-w-sm items-center">
        <Input
          id="search"
          type="text"
          class="pl-10"
          placeholder="Type here your search term"
          v-model="searchTerm"
          v-debounce:300ms="search()"
        />
        <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
          <Search class="size-6 text-muted-foreground" />
        </span>
      </div>
      <RouterLink :to="{ name: 'books.create' }">
        <Button type="button"> <Plus class="w-4 h-4 mr-2" /> Create </Button>
      </RouterLink>
    </div>
    <div v-if="loading">
      <h1 class="text-xl font-bold text-center">Loading books...</h1>
    </div>
    <div v-else>
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead class="text-center">ID</TableHead>
            <TableHead>Title</TableHead>
            <TableHead>Author</TableHead>
            <TableHead>ISBN</TableHead>
            <TableHead>On Store</TableHead>
            <TableHead>Summary</TableHead>
            <TableHead class="text-right">Actions</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-if="books.length === 0">
            <TableCell class="text-center" :colspan="7">No books found!</TableCell>
          </TableRow>
          <TableRow v-for="book in books" :key="book.id">
            <TableCell class="text-center">{{ book.id }}</TableCell>
            <TableCell>{{ book.title }}</TableCell>
            <TableCell>{{ book.author }}</TableCell>
            <TableCell>{{ book.isbn }}</TableCell>
            <TableCell>{{ book.on_store }}</TableCell>
            <TableCell>{{ book.summary }}</TableCell>
            <TableCell class="text-right">
              <div class="flex items-center justify-end">
                <RouterLink :to="{ name: 'books.show', params: { id: book.id } }" class="mr-2"
                  >View</RouterLink
                >
                <DropdownMenu>
                  <DropdownMenuTrigger><Ellipsis class="size-4" /></DropdownMenuTrigger>
                  <DropdownMenuContent>
                    <DropdownMenuItem>
                      <RouterLink
                        :to="{ name: 'books.show', params: { id: book.id } }"
                        class="cursor-pointer"
                      >
                        <div class="flex items-center">
                          <div class="mr-2">
                            <Pencil class="size-4" />
                          </div>
                          <div>Edit</div>
                        </div>
                      </RouterLink>
                    </DropdownMenuItem>
                    <DropdownMenuItem>
                      <a class="text-red-500 cursor-pointer" @click="deleteBook(book.id)">
                        <div class="flex items-center">
                          <div class="mr-2">
                            <Trash2 class="size-4" />
                          </div>
                          <div>Delete</div>
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

      <div class="mt-3">
        <Pagination v-slot="{ page }" :total="meta.last_page" :sibling-count="1" show-edges :default-page="1">
          <PaginationList class="flex items-center gap-1 justify-end">
            <template v-for="(item, index) in meta.links">
              <PaginationListItem v-if="item.type === 'page'" :key="index" :value="item.label" as-child>
                <Button class="w-10 h-10 p-0" :variant="item.active ? 'default' : 'outline'">
                  {{ item.label }}
                </Button>
              </PaginationListItem>
            </template>
          </PaginationList>
        </Pagination>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import axios from 'axios'
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow
} from '@/components/ui/table'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger
} from '@/components/ui/dropdown-menu'
import {
  Pagination,
  PaginationEllipsis,
  PaginationFirst,
  PaginationLast,
  PaginationList,
  PaginationListItem,
  PaginationNext,
  PaginationPrev,
} from '@/components/ui/pagination'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Trash2, Ellipsis, Pencil, Plus, Search } from 'lucide-vue-next'
import { useToast } from '@/components/ui/toast'
import vueDebounce from 'vue-debounce'

const { toast } = useToast()
const books = ref()
const meta = ref()
const loading = ref(true as Boolean)
const searchTerm = ref('')
const page = ref(1 as Number)
const vDebounce = vueDebounce({ lock: true })

onMounted(() => {
  fetchBooks()
})

const search = () => {
  page.value = 1
  fetchBooks()
}

const fetchBooks = () => {
  axios
    .get('http://localhost:8000/api/books?page=' + page.value + '&=' + searchTerm.value)
    .then((response) => {
      books.value = response.data.data
      meta.value = response.data.meta
    })
    .catch((error) => {
      toast({
        title: 'Uh oh! Something went wrong.',
        description: 'There was a problem with your request. Please contact support.',
        variant: 'destructive'
      })
    })
    .finally(() => {
      loading.value = false
    })
}

const deleteBook = (id: number) => {
  axios
    .delete(`http://localhost:8000/api/books/${id}`)
    .then((response) => {
      books.value = books.value.filter((book: any) => book.id !== id)
      toast({
        title: 'Book deleted',
        description: 'The book was deleted successfully.'
      })
    })
    .catch((error) => {
      toast({
        title: 'Uh oh! Something went wrong.',
        description: 'There was a problem with your request. Please contact support.',
        variant: 'destructive'
      })
    })
}
</script>
