<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlumniResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // colom inilah yang akan di keluarkan atau di return
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'tahum_masuk' => $this->tahum_masuk,
            'tahun_keluar' => $this->tahun_keluar,
            'no_hp' => $this->no_hp,
            'no_kamar' => $this->no_kamar,
            'published' => $this->created_at->format('d F, Y'),
        ];
    }
}
