<?php

use Illuminate\Database\Seeder;
use App\Reference;
use App\Kios;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call([
            UserSeeder::class,
        ]);
    }
}
