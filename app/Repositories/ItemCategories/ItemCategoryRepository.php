<?php

namespace App\Repositories\ItemCategories;

use App\Models\ItemCategory;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

class ItemCategoryRepository
{
    protected $app;

    public function __construct(
        Application $app,
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
        return ItemCategory::class;
    }

    public function query()
    {
        return $this->model->query()
            ->selectRaw('
                item_categories.id                                      AS id,
                item_categories.name                                    AS name,
                item_categories.thumbnail_url                           AS thumbnail_url,
                item_categories.is_active                               AS is_active,
                IF(item_categories.is_active=1, "Active", "Inactive")   AS status
            ');
    }

    public function store(array $data)
    {
        $query = $this->model->query()
            ->where('item_categories.name', $data['name'])
            ->first();
        if ($query) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 409,
                    'message'   => 'Item category is already exists',
                    'errors'    => []
                ],
                'data' => [],
            ];
        }

        $query = $this->model->query()
            ->create([
                'name' => $data['name'],
                'thumbnail_url' => $data['thumbnail_url'],
                'is_active' => $data['is_active'],
            ]);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Item category created successfully',
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
        $query->name = $data['name'];
        if ($data['is_thumbnail_removed'] === true) {
            $query->thumbnail_url = null;
        } else {
            if ($data['thumbnail_url']) {
                $query->thumbnail_url = $data['thumbnail_url'];
            }
        }
        $query->is_active = $data['is_active'];
        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Item category updated successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function destroy(string $id): array
    {
        $query = $this->find($id);
        $query->delete();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Item category deleted successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }
}
