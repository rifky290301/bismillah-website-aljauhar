<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArtikelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'isi' => $this->isi,
            // 'created_by' => $this->user->name,
            'published' => $this->created_at->format('d F, Y'),
        ];
    }
}
