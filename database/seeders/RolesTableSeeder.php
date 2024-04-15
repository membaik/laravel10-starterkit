<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

use DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $roles = [
                'Main' => [
                    'auth.edit',
                    'auth.edit-email',
                    'auth.edit-password',

                    'role.list',
                    'role.create',
                    'role.edit',
                    'role.destroy',

                    'user.list',
                    'user.create',
                    'user.edit',
                    'user.edit-security',
                    'user.edit-role',
                    'user.destroy',
                ],
                'Superadmin' => [
                    'auth.edit',
                    'auth.edit-email',
                    'auth.edit-password',

                    'user.list',
                    'user.create',
                    'user.edit',
                    'user.edit-security',
                    'user.edit-role',
                    'user.destroy',

                    'dashboard.main',
                ],
                'Admin' => [
                    'auth.edit',
                    'auth.edit-email',
                    'auth.edit-password',
                ],
            ];

            $roleIds = Role::query()->pluck('id', 'id');
            foreach ($roles as $roleName => $permissions) {
                $role = Role::query()->updateOrCreate([
                    'name' => $roleName
                ], []);

                if ($roleIds->contains($role->id)) {
                    $roleIds->forget($role->id);
                }

                foreach ($permissions as $permissionName) {
                    Permission::query()->updateOrCreate([
                        'name' => $permissionName
                    ], []);
                }

                $role->syncPermissions($permissions);
            }

            if ($roleIds->count()) {
                Permission::query()->whereIn('id', $roleIds->toArray())->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            dd($e);
        }
    }
}
