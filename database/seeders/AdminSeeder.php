<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
   
    public function run(): void
    {
        // User::create([
        //     'username' => 'admin admin' ,
        //     'password' => Hash::make('admin12345') ,
        //     'role' => 'admin' ,
        // ]);
    }
}
