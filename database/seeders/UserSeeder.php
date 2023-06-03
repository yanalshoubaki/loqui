<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserFollow;
use App\Models\UserMeta;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->has(UserMeta::factory(), 'meta')->create([
            'email' => 'me@yanalshoubaki.com',
            'username' => 'yanalshoubaki',
            'name' => 'Yanal Shoubaki',
        ])->assignRole('Super Admin');
        User::factory()->count(10)->has(UserMeta::factory(), 'meta')->has(
            UserFollow::factory()->state(function (array $attributes, User $user) {
                return ['follow_id' => User::where('id', '!=', $user->id)->inRandomOrder()->first()->id];
            }),
            'following'
        )->create();
    }
}
