<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar empresas
        $company1 = Company::create([
            'name' => 'Restaurante Alpha',
            'address' => 'Rua A, 100',
            'phone' => '(11) 91111-1111',
        ]);

        $company2 = Company::create([
            'name' => 'Pizzaria Beta',
            'address' => 'Rua B, 200',
            'phone' => '(11) 92222-2222',
        ]);

        // Criar usuários para empresa 1
        User::create([
            'name' => 'Admin Restaurante',
            'email' => 'admin@restaurante.com',
            'password' => bcrypt('password'),
            'company_id' => $company1->id,
        ]);

        // Criar usuários para empresa 2
        User::create([
            'name' => 'Admin Pizzaria',
            'email' => 'admin@pizzaria.com',
            'password' => bcrypt('password'),
            'company_id' => $company2->id,
        ]);
    }
}
