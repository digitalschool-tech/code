<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create permissions
        Permission::create(['name' => 'createSchools']);
        Permission::create(['name' => 'manageSchools']);
        Permission::create(['name' => 'createTeachers']);
        Permission::create(['name' => 'createStudents']);
        Permission::create(['name' => 'learningSection']);

        //create Roles and assign to permissions to them
        $admin = Role::create(['name' => 'admin'])
            ->givePermissionTo(['createSchools', 'manageSchools', 'createTeachers', 'createStudents', 'learningSection']);
        $school = Role::create(['name' => 'school'])
            ->givePermissionTo(['createTeachers', 'createStudents', 'learningSection']);
        $teacher = Role::create(['name' => 'teacher'])
            ->givePermissionTo(['createStudents', 'learningSection']);
        $student = Role::create(['name' => 'student'])
            ->givePermissionTo([ 'learningSection']);


    }
}
