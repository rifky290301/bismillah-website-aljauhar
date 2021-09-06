<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Berita::create([
            'user_id' => 2,
            'judul' => 'dang goreng',
            'isi' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'publish' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Berita::create([
            'user_id' => 2,
            'judul' => 'dang goreng',
            'isi' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'publish' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Berita::create([
            'user_id' => 2,
            'judul' => 'dang goreng',
            'isi' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'publish' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Berita::create([
            'user_id' => 2,
            'judul' => 'dang goreng',
            'isi' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'publish' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
