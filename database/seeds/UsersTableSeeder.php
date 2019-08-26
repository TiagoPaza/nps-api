<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'social_reason' => 'Tiago Paza ME',
            'fantasy_name' => 'TP Sistemas',
            'document' => '68215304110001',
            'state_registration' => '43612800',
            'email' => 'tiago.paza9@gmail.com',
            'password' => bcrypt('tiagopz007'),
            'phone' => '54991383654',
            'cep' => '99740000',
            'address' => 'Rua José Mantovani',
            'number' => 32,
            'complement' => '',
            'state' => 'RS',
            'city' => 'Barão de Cotegipe',
            'country' => 'BR'
        ]);
    }
}
