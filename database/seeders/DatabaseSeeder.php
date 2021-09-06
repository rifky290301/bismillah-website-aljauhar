<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Auth\Events\Registered;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleSuper = Role::create([
            'name' => 'Super admin',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $roleBPH = Role::create([
            'name' => 'BPH',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $roleSantri = Role::create([
            'name' => 'Santri',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Permission::create([
            'name' => 'create user',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Permission::create([
            'name' => 'create role',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Permission::create([
            'name' => 'create permission',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Permission::create([
            'name' => 'membuat artikel',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Permission::create([
            'name' => 'membuat berita',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Permission::create([
            'name' => 'melihat pendaftar',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Permission::create([
            'name' => 'membuat biografi',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $roleSuper->givePermissionTo(['create user', 'create permission', 'create role', 'membuat berita', 'membuat artikel', 'melihat pendaftar', 'membuat biografi']);

        $roleBPH->givePermissionTo(['create user', 'membuat berita', 'membuat artikel', 'melihat pendaftar', 'membuat biografi']);

        $roleSantri->givePermissionTo('membuat artikel');

        $superAdmin = User::create([
            'name' => 'Superadmin akun',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('superadmin123'),
            'remember_token' => \Str::random(60),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $superAdmin->assignRole('Super admin');
        event(new Registered($superAdmin));

        $roleBPH = User::create([
            'name' => 'akun bph',
            'email' => 'bph@gmail.com',
            'password' => bcrypt('bph123'),
            'remember_token' => \Str::random(60),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $roleBPH->assignRole('BPH');
        event(new Registered($roleBPH));

        $roleSantri = User::create([
            'name' => 'akun santri',
            'email' => 'santri@gmail.com',
            'password' => bcrypt('santri123'),
            'remember_token' => \Str::random(60),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $roleSantri->assignRole('Santri');
        event(new Registered($roleSantri));
     
     
     
        $this->call(ArtikelSeeder::class);
        $this->call(BeritaSeeder::class);
        $this->call(BiografiSeeder::class);
        $this->call(TestimoniSeeder::class);
    }


}
