<?php

use Illuminate\Database\Seeder;
use App\Models\User\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      	User::create([
      		'name'=>'Demo',
      		'surname' => 'User',
      		'email' => 'demo@user.com',
      		'password' => Hash::make('password')
      		]);  
    }
}
