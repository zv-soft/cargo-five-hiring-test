<?php



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Database\Seeders\CitiesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        User::create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'name' => 'Administrador',
        ]);


    }
}
