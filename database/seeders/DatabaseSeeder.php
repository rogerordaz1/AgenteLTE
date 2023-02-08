<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cliente;
use App\Models\Factura;
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
         User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('123123123')

        ])->assignRole('operadora');

        
        User::factory(6)->create();
        
       $this->call(OcomercialeSeeder::class);

       
       
      

      
        
        // Factura::create([
        //     'oficina' => '33',
        //     'agrupacion' => '1231233321',
        //     'cuenta' => '12332131',
        //     'no_factura' => '34234234',
        //     'nombre_cliente' => 'Roger Luis Ordaz',
        //     'servicio_cliente'  => '48713264',
        //     'cuota' => fake()->randomNumber(),
        //     'LDN'  => fake()->randomNumber(),
        //     'LDI'  => fake()->randomNumber(),
        //     'local'  => fake()->randomNumber(),
        //     'otros' => fake()->randomNumber(),
        //     'impuesto' => fake()->randomNumber(),
        //     'comision' => fake()->randomNumber(),
        //     'facturado' => fake()->randomNumber(),
        //     'atrasos' => fake()->randomNumber(),
        //     'total' => fake()->randomNumber(),
        // ]);
          


    }
}
