<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();


        $this->call(PermissionsSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(SubjectSeeder::class);

        Schema::enableForeignKeyConstraints();

    }
}
