<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $books = json_decode(File::get(storage_path('app/books.json')), true);
        DB::table('books')->insert($books);
        if (DB::getDriverName() === 'pgsql') {
            DB::update('ALTER SEQUENCE books_id_seq RESTART WITH '.(count($books) + 1));
        }
    }
}
