<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

class BooksEndpointTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setup(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        $this->user = User::first();
    }

    /** @test */ 
    public function books_index_endpoint(): void
    {
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
    public function books_show_endpoint(): void
    {
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


    /** @test */
    public function books_create_endpoint(): void
    {
        $response = $this->post('/api/books', [
            'author' => 'John Doe',
            'title' => 'T',
            'publish_date' => '2024-03-18',
            'isbn' => '1234567890456123',
            'summary' => 'A book about something',
            'price' => -5,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'title',
            'price',
            'isbn',
            'on_store',
        ]);

        $response = $this->post('/api/books', [
            'author' => 'John Doe',
            'title' => 'The Book',
            'publish_date' => '2024-03-18',
            'isbn' => '1234567890123',
            'summary' => 'A book about something',
            'price' => 100,
            'on_store' => 10,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'success',
                'id',
            ],
        ]);
    }

    /** @test */
    public function books_update_endpoint(): void
    {
        $response = $this->put('/api/books/1', [
            'author' => 'John Doe',
            'title' => 'T',
            'publish_date' => '2024-03-18',
            'isbn' => '1234567890456123',
            'summary' => 'A book about something',
            'price' => -5,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'title',
            'price',
            'isbn',
            'on_store',
        ]);

        $response = $this->put('/api/books/1', [
            'author' => 'John Doe',
            'title' => 'The Book',
            'publish_date' => '2024-03-18',
            'isbn' => '1234567890123',
            'summary' => 'A book about something',
            'price' => 100,
            'on_store' => 10,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'success',
                'id',
            ],
        ]);
        $this->assertDatabaseHas(Book::class, [
            'author' => 'John Doe',
            'title' => 'The Book',
            'publish_date' => '2024-03-18',
            'isbn' => '1234567890123',
            'summary' => 'A book about something',
            'price' => 100,
            'on_store' => 10,
        ]);
    }

    /** @test */
    public function books_delete_endpoint(): void
    {
        $response = $this->delete('/api/books/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'success',
            ],
        ]);

        $this->assertDatabaseMissing(Book::class, [
            'id' => '1',
        ]);
    }
}
