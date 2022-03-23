<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // dd('a');
        // for ($i=0;$i<$i;$i++) {

            // $new_user = new User;

            // $new_user->name = 'user1';
            // $new_user->email = 'user'. $i + 1 . '@gmail.com';
            // $new_user->password = Hash::make('password'.$i+1);
            // $new_user->created_at = date('Y-m-d H:i:s');
            // $new_user->save();
        // }

        // factory(User::class, 10)->create()->each(function ($user) {
        // });

        DB::table('users')->insert([
            'name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
