<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = ModelsUser::create([
            'name' => 'Asaf',
            'email' => 'asaf@gmail.com',
            'phone' => '070832727',
            'password' => Hash::make('123456789')
        ]);
        $user->assignRole('superadmin');
    }
}
