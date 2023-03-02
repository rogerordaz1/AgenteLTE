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
            'username'=>'roger',
            'email' => 'roger@gmail.com',
            'password' => bcrypt('123123123')
        ])->assignRole('admin');

       $this->call(OcomercialeSeeder::class);











    }
}
