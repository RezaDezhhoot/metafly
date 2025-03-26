<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'show_dashboard' , 'guard_name'=> 'web'],

            ['name' => 'show_users' , 'guard_name'=> 'web'],
            ['name' => 'create_users' , 'guard_name'=> 'web'],
            ['name' => 'edit_users' , 'guard_name'=> 'web'],
            ['name' => 'delete_users' , 'guard_name'=> 'web'],

            ['name' => 'show_roles' , 'guard_name'=> 'web'],
            ['name' => 'create_roles' , 'guard_name'=> 'web'],
            ['name' => 'edit_roles' , 'guard_name'=> 'web'],
            ['name' => 'delete_roles' , 'guard_name'=> 'web'],

            ['name' => 'show_categories' , 'guard_name'=> 'web'],
            ['name' => 'create_categories' , 'guard_name'=> 'web'],
            ['name' => 'edit_categories' , 'guard_name'=> 'web'],
            ['name' => 'delete_categories' , 'guard_name'=> 'web'],

            ['name' => 'show_faq' , 'guard_name'=> 'web'],
            ['name' => 'create_faq' , 'guard_name'=> 'web'],
            ['name' => 'edit_faq' , 'guard_name'=> 'web'],
            ['name' => 'delete_faq' , 'guard_name'=> 'web'],

            ['name' => 'show_points' , 'guard_name'=> 'web'],
            ['name' => 'create_points' , 'guard_name'=> 'web'],
            ['name' => 'edit_points' , 'guard_name'=> 'web'],
            ['name' => 'delete_points' , 'guard_name'=> 'web'],

            ['name' => 'show_settings' , 'guard_name'=> 'web'],
            ['name' => 'create_settings' , 'guard_name'=> 'web'],
            ['name' => 'edit_settings' , 'guard_name'=> 'web'],
            ['name' => 'delete_settings' , 'guard_name'=> 'web'],

            ['name' => 'show_blogs' , 'guard_name'=> 'web'],
            ['name' => 'create_blogs' , 'guard_name'=> 'web'],
            ['name' => 'edit_blogs' , 'guard_name'=> 'web'],
            ['name' => 'delete_blogs' , 'guard_name'=> 'web'],

            ['name' => 'show_topics' , 'guard_name'=> 'web'],
            ['name' => 'create_topics' , 'guard_name'=> 'web'],
            ['name' => 'edit_topics' , 'guard_name'=> 'web'],
            ['name' => 'delete_topics' , 'guard_name'=> 'web'],

            ['name' => 'show_transports' , 'guard_name'=> 'web'],
            ['name' => 'create_transports' , 'guard_name'=> 'web'],
            ['name' => 'edit_transports' , 'guard_name'=> 'web'],
            ['name' => 'delete_transports' , 'guard_name'=> 'web'],

            ['name' => 'show_comments' , 'guard_name'=> 'web'],
            ['name' => 'edit_comments' , 'guard_name'=> 'web'],
            ['name' => 'delete_comments' , 'guard_name'=> 'web'],
        ];

        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate([
                'name' => $permission['name']
            ],[
                'guard_name' => 'web'
            ]);
        }
    }
}
