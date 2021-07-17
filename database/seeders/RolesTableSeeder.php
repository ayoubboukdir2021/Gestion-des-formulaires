<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $adminRole = Role::create([
            'name'=>'admin',
            'display_name'=>'Administrator',
            'description'=>'System Administrator',
        ]);

        $editorRole = Role::create([
            'name'=>'editor',
            'display_name'=>'Supervisor',
            'description'=>'System Supervisor',
        ]);

        $userRole = Role::create([
            'name'=>'user',
            'display_name'=>'User',
            'description'=>'Normal User',
        ]);

        $admin = User::create([
            'name'=>'AYOUB BOUKDIR',
            'username'=>'admin',
            'email'=>'programmeur2020@gmail.com',
            'phone'=>'+212616434988',
            'email_verified_at'=>Carbon::now(),
            'password'=>Hash::make('123123123'),
            'status'=>1,
            'role_id'=>$adminRole->id,
        ]);



        $editor = User::create([
            'name'=>'Editor',
            'username'=>'editor',
            'email'=>'editor@gmail.com',
            'phone'=>'+2126234567891',
            'email_verified_at'=>Carbon::now(),
            'password'=>Hash::make('123123123'),
            'status'=>1,
            'role_id'=>$editorRole->id,
        ]);



        $user1 = User::create([
            'name'=>'User',
            'username'=>'user',
            'email'=>'user@gmail.com',
            'phone'=>'+2126987654321',
            'email_verified_at'=>Carbon::now(),
            'password'=>Hash::make('123123123'),
            'status'=>1,
            'role_id'=>$userRole->id,
        ]);

        for ($i=0; $i < 10; $i++) {
            $user = User::create([
                'name'=>$faker->name,
                'username'=>$faker->userName,
                'email'=>$faker->email,
                'phone'=> '+2126' . random_int(100000000,199999999),
                'email_verified_at'=>Carbon::now(),
                'password'=>Hash::make('123123123'),
                'status'=>1,
                'role_id'=>$userRole->id,
            ]);


        }

    }
}
