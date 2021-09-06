<?php

namespace Database\Seeders;

use App\Models\Biografi;
use Illuminate\Database\Seeder;

class BiografiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Biografi::create([
            'nama' => 'dang goreng',
            'biografi' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'user_id' => 2,
            'publish' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Biografi::create([
            'nama' => 'dang goreng',
            'biografi' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'user_id' => 2,
            'publish' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Biografi::create([
            'nama' => 'dang goreng',
            'biografi' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'user_id' => 2,
            'publish' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Biografi::create([
            'nama' => 'dang goreng',
            'biografi' => '<p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use model factories to conveniently generate large amounts of database records. First, review the model factory documentation to learn how to define your factories.</p>',
            'user_id' => 2,
            'publish' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
