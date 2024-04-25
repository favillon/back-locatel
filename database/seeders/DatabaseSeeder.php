<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $numberUsers       = 15;
        $numberAccount     = 30;
        $numberTransaction = 40;

        \App\Models\AccountType::factory()->create(['name' => 'Ahorro']);
        \App\Models\AccountType::factory()->create(['name' => 'Corriente']);
        
        \App\Models\TransactionType::factory()->create(['name' => 'Consignacion']);
        \App\Models\TransactionType::factory()->create(['name' => 'Retiro']);

        \App\Models\User::factory()->create([
            'name' => 'Prueba Fabian',
            'email' => 'f@f.co',
            'identification' => 1010194,
            'password' => 'pass'
        ]);
        \App\Models\User::factory($numberUsers)->create();
        
        \App\Models\Account::factory($numberAccount)->create();
        \App\Models\Transaction::factory($numberTransaction)->create();
        
    }
}
