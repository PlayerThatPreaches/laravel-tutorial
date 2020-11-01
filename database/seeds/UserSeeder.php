<?php

use App\User;
use App\Profession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $professions = DB::select('SELECT id FROM professions LIMIT 0,1', ['Desarrollador back-end']);
 $professionId = Profession::where('title', 'Desarrollador back-end')->value('id');
      factory(User::class)->create([
           'name'  => 'Charlie',
           'email' => 'deulios.net',
           'password' => bcrypt('laravel'),
           'profession_id' => $professionId,
           'is_admin' => true,

         ]);
      factory(User::class)->create([
              'profession_id' => $professionId

         ]);
      factory(User::class, 48)->create();
    }
}
