<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'email'     => 'admin@admin.com',
            'password'  => bcrypt('123456'),
            'name'      => 'Leonel Antonietti',
            'type'      => 5,
        ]);

    }
}
