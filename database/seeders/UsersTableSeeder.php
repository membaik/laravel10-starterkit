<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $users = [
                [
                    'full_name' => 'Sintas Support',
                    'username' => 'support@membasuh.com',
                    'email' => 'support@membasuh.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'image_url' => null,
                    'remember_token' => Str::random(10),
                    'is_active' => true,
                    'roles' => Role::query()->whereIn('name', ['Main'])->get()
                ],
                [
                    'full_name' => 'Azis Alvriyanto',
                    'username' => 'azisalvriyanto@membasuh.com',
                    'email' => 'azisalvriyanto@membasuh.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'image_url' => null,
                    'remember_token' => Str::random(10),
                    'is_active' => true,
                    'roles' => Role::query()->whereIn('name', ['Superadmin'])->get()
                ],
                [
                    'full_name' => 'Sintas Guest',
                    'username' => 'guest@membasuh.com',
                    'email' => 'guest@membasuh.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'image_url' => null,
                    'remember_token' => Str::random(10),
                    'is_active' => true,
                    'roles' => Role::query()->whereIn('name', ['Admin'])->get()
                ],
            ];

            foreach ($users as $data) {
                $user = User::query()
                    ->updateOrCreate([
                        'full_name' => $data['full_name'],
                        'username' => $data['username'],
                    ], [
                        'email' => $data['email'],
                        'email_verified_at' => $data['email_verified_at'],
                        'password' => $data['password'],
                        'image_url' => $data['image_url'],
                        'remember_token' => $data['remember_token'],
                        'is_active' => $data['is_active'],
                        'created_by' => null,
                        'updated_by' => null,
                    ]);

                if (count($data['roles'])) {
                    $user->syncRoles($data['roles']);
                }

                $user->userSetting()->updateOrCreate([
                    'user_id' => $user->id,
                ], [
                    'created_by' => null,
                    'updated_by' => null,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            dd($e);
        }
    }
}
