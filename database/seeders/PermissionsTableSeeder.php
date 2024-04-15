<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

use DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $data = [
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

                'dashboard.main',
            ];

            $permissionIds = Permission::query()->pluck('id', 'id');
            foreach ($data as $permissionName) {
                $permission = Permission::query()->updateOrCreate([
                    'name' => $permissionName
                ]);

                if ($permissionIds->contains($permission->id)) {
                    $permissionIds->forget($permission->id);
                }
            }

            if ($permissionIds->count()) {
                Permission::query()->whereIn('id', $permissionIds->toArray())->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            dd($e);
        }
    }
}
