<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if(config("app.env") == "production"){
            $password = Str::password();
        }else{
            $password = "password";
        }

        $user = User::create([
            "name" => "superadmin",
            "email" => "admin@localhost",
            "password" => Hash::make($password),
        ]);

        Role::create(["name" => "super-admin"]);
        $user->assignRole("super-admin");

        $this->command->info("    created administrator account");
        $this->command->info("    E-Mail:   $user->email");
        $this->command->info("    Password: $password");
    }
}
