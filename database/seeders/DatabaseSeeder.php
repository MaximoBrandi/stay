<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = \App\Models\User::factory(User::class, 60)->create();

        foreach($users as $user) {
            $user->name = 'Student '.$user->id;
            $user->email = 'student-'.$user->id.'@gmail.com';
            $user->save();
        }
    }
}
