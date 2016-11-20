<?php

use Illuminate\Database\Seeder;

class CarTableSeeder extends Seeder {

    public function run()
    {
        DB::table('cars')->delete();

        \App\Car::create(['brand' => 'Honda', 'type' => 'CRV', 'year' => '2015', 'color' => 'Red', 'plate' => 'D 108 HND']);
        \App\Car::create(['brand' => 'Toyota', 'type' => 'Yaris', 'year' => '2015', 'color' => 'Black', 'plate' => 'D 112 TYT']);
        \App\Car::create(['brand' => 'BMW', 'type' => 'M2', 'year' => '2015', 'color' => 'White', 'plate' => 'D 1 BMW']);
    }

}