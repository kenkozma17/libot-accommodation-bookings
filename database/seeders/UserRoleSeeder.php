<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $doesReporterRoleExist = Role::where('name', 'reporter')->first();

        if(!$doesReporterRoleExist) {
            $role = Role::create(['name' => 'reporter']);
            $permission = Permission::create(['name' => 'manage reports']);
            $role->givePermissionTo($permission);
        }

        $user = User::where('email', 'carina@catmidinn.com')->first();
        if($user && $user->hasRole('reporter') === false) {
            $user->assignRole('reporter');
        }
    }
}
