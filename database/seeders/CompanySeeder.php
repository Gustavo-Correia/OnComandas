<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create([
            'name' => 'Restaurante Exemplo',
            'address' => 'Rua Principal, 123',
            'phone' => '(11) 99999-9999',
        ]);

        Company::create([
            'name' => 'Pizzaria Demo',
            'address' => 'Avenida Central, 456',
            'phone' => '(11) 88888-8888',
        ]);

        Company::create([
            'name' => 'Lanchonete Teste',
            'address' => 'Praça Central, 789',
            'phone' => '(11) 77777-7777',
        ]);
    }
}
