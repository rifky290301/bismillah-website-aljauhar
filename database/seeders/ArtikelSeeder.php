<?php

namespace Database\Seeders;

use App\Models\Artikel;
use Illuminate\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artikel::create([
            'judul' => 'dang goreng',
            'isi' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'publish' => "faforit",
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Artikel::create([
            'judul' => 'dang goreng',
            'isi' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'publish' => "faforit",
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Artikel::create([
            'judul' => 'dang goreng',
            'isi' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'publish' => "faforit",
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Artikel::create([
            'judul' => 'dang goreng',
            'isi' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'publish' => "not",
            'user_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
