<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $table = 'books';

    protected $fillable = [
        'author',
        'title',
        'publish_date',
        'isbn',
        'summary',
        'price',
        'on_store',
    ];
}
