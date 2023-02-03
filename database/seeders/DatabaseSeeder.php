<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cliente;
use App\Models\Ocomerciale;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
         User::create([
            'name' => 'Roger',
            'email' => 'roger@gmail.com',
            'password' => bcrypt('123123123')

        ])->assignRole('admin');

        
        User::factory(6)->create();
        
        Ocomerciale::factory(4)->create();

        Cliente::create([
        'id_oficina_comercial' => '1',
        'servicio' => fake()->phoneNumber(), 
        'sector' =>  'R',
        'nombre' => fake()->name(),
        'direccion' => fake()->address(),
        'cuenta_bancaria' => '99900394944',
        'fecha_alta' => fake()->date()
        ]);


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        

          


    }
}
