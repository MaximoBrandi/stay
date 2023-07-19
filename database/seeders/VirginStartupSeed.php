<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Privileges;

class VirginStartupSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accountant = User::factory(1)->create()->first();

        $accountant->id = 1;
        $accountant->name = 'Admin';
        $accountant->email = 'admin@admin.com';
        $accountant->password = bcrypt('1234');
        $accountant->save();

        $privilege = new Privileges;
        $privilege->user_id = $accountant->id;
        $privilege->privilege_grade = 4;
        $privilege->save();
    }
}
