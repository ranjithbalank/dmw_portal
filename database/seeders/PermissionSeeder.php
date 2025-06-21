<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            "role-list",
            "role-create",
            "role-edit",
            "role-view",
            "role-delete",
            "leave-list",
            "leave-create",
            "leave-edit",
            "leave-view",
            "leave-delete",
            "leave-approve",

        ];
        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
