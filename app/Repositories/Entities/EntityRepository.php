<?php

namespace App\Repositories\Entities;

use App\Models\Entity;
use App\Repositories\EntityCategories\EntityCategoryRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

class EntityRepository
{
    protected $app;
    protected $entityCategoryRepository;

    public function __construct(
        Application $app,
        EntityCategoryRepository $entityCategoryRepository,
    ) {
        $this->app = $app;
        $this->makeModel();

        $this->entityCategoryRepository = $entityCategoryRepository;
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
        return Entity::class;
    }

    public function query()
    {
        return $this->model->query()
            ->selectRaw('
                entities.id                                     AS id,
                entities.full_name                              AS full_name,
                entities.is_active                              AS is_active,
                IF(entities.is_active=1, "Active", "Inactive")  AS status
            ');
    }

    public function store(array $data)
    {
        $query = $this->model->query()
            ->create([
                'full_name' => $data['full_name'],
                'is_active' => $data['is_active'],
            ]);

        if ($data['entity_categories']) {
            $entityCategories = $this->entityCategoryRepository->query()->whereIn('id', $data['entity_categories'])->where('entity_categories.is_active', true)->get();
            $query->entityCategories()->sync($entityCategories);
        }

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Entity created successfully',
                'errors'    => []
            ],
            'data' => $query,
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

    public function update(string $id, array $data)
    {
        $query = $this->find($id);

        $query->full_name = $data['full_name'];
        $query->is_active = $data['is_active'];
        $query->save();

        if ($query->userSetting) {
            $user = $query->userSetting->user;
            $user->full_name = $query->full_name;
            $user->save();
        }

        if ($data['entity_categories']) {
            $entityCategories = $this->entityCategoryRepository->query()->whereIn('id', $data['entity_categories'])->where('entity_categories.is_active', true)->get();
        } else {
            $entityCategories = [];
        }
        $query->entityCategories()->sync($entityCategories);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Entity updated successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function destroy(string $id): array
    {
        $query = $this->find($id);
        if ($query->userSetting) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 500,
                    'message'   => 'Entity belongs to user',
                    'errors'    => []
                ],
                'data' => $query,
            ];
        }

        $query->delete();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Entity deleted successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }
}
