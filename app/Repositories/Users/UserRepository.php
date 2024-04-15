<?php

namespace App\Repositories\Users;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use App\Models\User;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserRepository
{
    protected $app;

    public function __construct(
        Application $app
    ) {
        $this->app = $app;
        $this->makeModel();
    }

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function model()
    {
        return User::class;
    }

    public function query(): QueryBuilder
    {
        $query = $this->model->query()
            ->selectRaw('
                users.id                            AS id,
                users.full_name                     AS full_name,
                users.email                         AS email,
                users.image_url                     AS image_url,
                users.is_active                     AS is_active,
                IF(users.is_active=1, "Active", "Inactive") AS status
            ');

        if (auth()->user()->hasRole('Main') === false) {
            $query = $query->whereHas('roles', function ($query) {
                return $query->where('name', '!=', 'Main');
            });
        }

        return $query;
    }

    public function store(array $data): array
    {
        $query = $this->model->query()->whereEmail($data['email'])->first();
        if ($query) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 409,
                    'message'   => 'This email is already registered',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        $query = $this->model->query()
            ->create([
                'full_name' => $data['full_name'],
                'username' => $data['username'],
                'password' => $data['password'],
                "email" => $data['email'],
                'image_url' => $data['image_url'],

                'email_verified_at' => now(),
                'is_active' => $data['is_active'],
            ]);

        $query->syncRoles($data['roles']);

        $userSetting = $query->userSetting()->updateOrCreate([
            'user_id' => $query->id,
        ], []);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 201,
                'message'   => 'User created successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function find(string $id)
    {
        return $this->model->query()->find($id);
    }

    public function findOrFail(string $id)
    {
        return $this->model->query()->findOrFail($id);
    }

    public function update(string $id, array $data): array
    {
        $query = $this->find($id);
        if ($data['is_image_removed'] === false) {
            if ($data['image_url']) {
                if ($query->image_url) {
                    $this->userRepository->removeImage($query->image_url);
                }

                $query->image_url = $data['image_url'];
            }
        } else {
            $query->image_url = null;
        }

        $query->full_name   = $data['full_name'];
        $query->is_active   = $data['is_active'];
        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'User updated successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function updateEmail(string $id, array $data): array
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'User not found',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        $query->username    = $data['email'];
        $query->email       = $data['email'];
        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Email updated successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function updatePassword(string $id, array $data): array
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'User not found',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        $query->password    = $data['password'];
        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Password updated successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function updateRole(string $id, array $data): array
    {
        $query = $this->find($id);
        $query->syncRoles($data['roles']);

        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Role updated successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function updateSetting(string $id, array $data): array
    {
        $user = $this->find($id);
        $query = $user->userSetting()->updateOrCreate([
            'user_id' => $user->id,
        ], []);

        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'User setting updated successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function destroy(string $id, array $data): array
    {
        // if ($data['is_deactivated'] === false) {
        //     return [
        //         'meta' => [
        //             'success'   => false,
        //             'code'      => 500,
        //             'message'   => 'Please check the box to deactivate your account',
        //             'errors'    => []
        //         ],
        //         'data' => null,
        //     ];
        // }

        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'User not found',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        $query->save();

        $query->syncRoles([]);
        $query->delete();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'User deleted successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function removeImage($imageUrl)
    {
        if (Storage::disk('public')->exists($imageUrl)) {
            Storage::disk('public')->delete($imageUrl);
        }
    }
}
