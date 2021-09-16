<?php

namespace Database\Seeders;

use App\Models\Testimoni;
use Illuminate\Database\Seeder;

class TestimoniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Testimoni::create([
            'nama' => 'Naruto',
            'testimoni' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'publish' => true,
            'pekerjaan' => "presiden",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Testimoni::create([
            'nama' => 'Naruto',
            'testimoni' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'publish' => true,
            'pekerjaan' => "presiden",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Testimoni::create([
            'nama' => 'Naruto',
            'testimoni' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'publish' => true,
            'pekerjaan' => "presiden",
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Testimoni::create([
            'nama' => 'Naruto',
            'testimoni' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'publish' => true,
            'pekerjaan' => "presiden",
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
