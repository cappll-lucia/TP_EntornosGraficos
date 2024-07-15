<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'martinsola11@gmail.com',
            'role_id' => 1,
            'password' => bcrypt('12345678'),
            'first_name' => 'Martin',
            'last_name' => 'Sola',
            'legajo' => '48618',
        ]);

        User::create([
            'email' => 'franco.pinciroli@hotmail.com',
            'role_id' => 1,
            'password' => bcrypt('12345678'),
            'first_name' => 'Martin',
            'last_name' => 'Sola',
            'legajo' => '48618',
        ]);

        User::create([
            'email' => 'dia.fernandezcariaga.ezequiel@gmail.com',
            'role_id' => 2,
            'password' => bcrypt('12345678'),
            'first_name' => 'Martin',
            'last_name' => 'Sola',
            'legajo' => '48618',
        ]);

        User::create([
            'email' => 'danieladiaz@gmail.com',
            'role_id' => 3,
            'password' => bcrypt('12345678'),
            'first_name' => 'Martin',
            'last_name' => 'Sola',
            'legajo' => '48618',
        ]);
    }
}
