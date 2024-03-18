<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;
use Database\Seeders\DatabaseSeeder;

class BooksEndpointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */ 
    public function books_index_endpoint(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get('/api/books');

        $response->assertStatus(200);
        $response->assertJsonCount(Book::count(), 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'author',
                    'title',
                    'isbn',
                    'publish_date',
                    'on_store',
                    'links' => [
                        'self'
                    ],
                ],
            ],
        ]);
    }


    /** @test */
    /** @test */ 
    public function books_show_endpoint(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get('/api/books/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'author',
                'title',
                'isbn',
                'publish_date',
                'on_store',
                'summary',
                'price',
            ],
        ]);
        $response->assertJsonFragment([
            'id' => 1,
        ]);
    }
}
