<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        // User::factory(10)->create();
        // create register data
        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'mamun@gmail.com';
        $user->password = bcrypt('123');
        $user->save();

    }
}
