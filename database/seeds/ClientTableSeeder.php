<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $clients = ['Ahmed', 'Mohamed'];

        foreach ($clients as $client) {
            Client::create([

                'name' => $client,
                'phone' => '6070',
                'address' => 'Giza'

            ]);

        }//end of foreach

    }
}
