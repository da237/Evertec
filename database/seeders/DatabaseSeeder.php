<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        $this->call(RolesPermisosSeeder::class);
        
        $userAdmin=\App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password'=> bcrypt('admin123456')
        ]);
        $userAdmin->assignRole('admin');
        
        
        
        
         $userClient=\App\Models\User::factory()->create([
            'name' => 'client',
            'email' => 'client@example.com',
            'password'=> bcrypt('123456')
        
        ]);
        $userClient->assignRole('cliente');
    }
}
