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
                'user.edit-setting',
                'user.destroy',

                'dashboard.main',

                'entity-category.list',
                'entity-category.edit',

                'entity.list',
                'entity.create',
                'entity.edit',
                'entity.destroy',

                'item-category.list',
                'item-category.create',
                'item-category.edit',
                'item-category.destroy',

                'unit-of-measurement.list',
                'unit-of-measurement.create',
                'unit-of-measurement.edit',
                'unit-of-measurement.destroy',
            ];

            $itemIds = Permission::query()->pluck('id', 'id');
            foreach ($data as $itemName) {
                $query = Permission::query()->updateOrCreate([
                    'name' => $itemName
                ]);

                if ($itemIds->contains($query->id)) {
                    $itemIds->forget($query->id);
                }
            }

            if ($itemIds->count()) {
                Permission::query()->whereIn('id', $itemIds->toArray())->delete();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            dd($e);
        }
    }
}
