<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Traits\UserTrait;


class RoleSeeder extends Seeder
{

    use UserTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //super admin
        $superAdminRole = Role::create(['name' => $this->superAdminRole]);
        $superAdminRole->givePermissionTo(Permission::all());

        //admin
        $adminRole = Role::create(['name' => $this->adminRole]);
        Role::create(['name' => $this->userRole]);

        // //director
        // Role::create(['name' => $this->directorRole]);

        //employee
        // $employeeRole = Role::create(['name' => $this->employeeRole]);

        //registering a superuser account
        $superAdmin = User::create(
            [
                'first_name' => $this->superadminSeedFirstName,
                'last_name' => $this->superadminSeedLastName,
                'full_name' => $this->superadminSeedFullName,
                'address' =>"Dhaka",
                'email' => $this->superadminSeedEmail,
                'status' => $this->userActive,
                'phone' => "01700000000",
                'dob' => now(),
                'password' => bcrypt('123456'), // password = 123456
                'remember_token' => Str::random(10),
            ]
        );

        //assigning role to super admin
        $superAdmin->assignRole($superAdminRole);

        $admin = User::create(
            [
                'first_name' => $this->adminSeedFirstName,
                'last_name' => $this->adminSeedLastName,
                'full_name' => $this->adminSeedFullName,
                'address' =>"Dhaka",
                'email' => $this->adminSeedEmail,
                'status' => $this->userActive,
                'phone' => "01700000001",
                'dob' => now(),
                'password' => bcrypt('admin'),
                'remember_token' => Str::random(10),
            ]
        );

        //assigning role to super admin
        $admin->assignRole($adminRole);
    }
}
