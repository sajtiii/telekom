<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isIndex = $request->route()->uri == 'api/books';

        return [
            'id' => $this->id,
            'author' => $this->author,
            'title' => $this->title,
            'isbn' => $this->isbn,
            'publish_date' => $this->publish_date,
            'on_store' => $this->on_store,
            'summary' => $isIndex ? Str::limit($this->summary, 30, '...') : $this->summary,
            'price' => $this->whenNotNull($this->price),
            'links' => $this->when($isIndex, [
                'self' => route('books.show', ['book' => $this->id]),
            ]),
        ];
    }
}
