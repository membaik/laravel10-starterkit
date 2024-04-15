<?php

namespace App\Http\Requests\Users;

use App\Repositories\Roles\RoleRepository;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRoleRequest extends FormRequest
{
    private $roleRepository;

    public function __construct(
        RoleRepository $roleRepository
    ) {
        $this->roleRepository = $roleRepository;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "role.*" => "nullable|string",
        ];
    }

    public function data(): array
    {
        $company = auth()->user()->company;

        return [
            'roles' => $this->getRoles($company),
        ];
    }

    public function getRoles($company = null)
    {
        return $this->roleRepository->query($company)->whereIn('roles.id', $this->input('role') ?? [])->get();
    }
}
