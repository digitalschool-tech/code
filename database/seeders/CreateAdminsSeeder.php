<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ardit = User::create([
            'name' => 'Ardit Xhaferi',
            'email' => 'ardit@msoshqip.tech',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('ArditXhaferi2@2@'),
            'remember_token' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $ardit->assignRole('admin');

        $denis = User::create([
            'name' => 'Denis Hoti',
            'email' => 'denis@msoshqip.tech',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('DenisHoti2@2@'),
            'remember_token' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $denis->assignRole('admin');
    }
}
