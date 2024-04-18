<?php

namespace App\Repositories\Auth;

use App\Repositories\Users\UserRepository;

class ProfileRepository
{
    private $userRepository;
    private $userId;

    public function __construct(
        UserRepository $userRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->userId = auth()->user()->id;
    }

    public function update(string $id, array $data): array
    {
        $query = $this->userRepository->find($id);
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

        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Profile updated successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function updateEmail(array $data): array
    {
        $id = $this->userId;
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

        if (Hash::check($data['password'], $query->password) === false) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 401,
                    'message'   => 'Password does not match',
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

    public function updatePassword(array $data): array
    {
        $id = $this->userId;
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

        if (Hash::check($data['current_password'], $query->password) === false) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 401,
                    'message'   => 'Current password does not match',
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
}
