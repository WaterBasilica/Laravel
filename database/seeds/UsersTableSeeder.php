<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
      [
        'name' => 'yamada',
        'email' => 'aaa@gmail.com',
        'password' => bcrypt('aaaaaaaa'),
      ],
      [
        'name' => 'tanaka',
        'email' => 'bbb@gmail.com',
        'password' => bcrypt('bbbbbbbb'),
      ],
      [
        'name' => 'sato',
        'email' => 'sss@gmail.com',
        'password' => bcrypt('ssssssss'),
      ],
      [
        'name' => str_random(10),
        'email' => 'www@gmail.com',
        'password' => bcrypt('wwwwwwww'),
        ],
      [
        'name' => str_random(10),
        'email' => 'rrr@gmail.com',
        'password' => bcrypt('rrrrrrrr'),
      ],
      [
        'name' => str_random(10),
        'email' => 'ttt@gmail.com',
        'password' => bcrypt('tttttttt'),
      ],
    ]);
    }
}
