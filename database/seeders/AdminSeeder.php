<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the first development administrator.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            [
                'email' => 'admin@isa.test',
            ],
            [
                'name' => 'ISA Administrator',
                'password' => Hash::make('admin123'),
            ]
        );
    }
}
