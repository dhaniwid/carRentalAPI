<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder {

    public function run()
    {
        DB::table('clients')->delete();

        \App\Client::create(['name' => 'Ahmad', 'gender' => 'male']);
        \App\Client::create(['name' => 'Rizki', 'gender' => 'male']);
        \App\Client::create(['name' => 'Widodo', 'gender' => 'male']);
    }

}