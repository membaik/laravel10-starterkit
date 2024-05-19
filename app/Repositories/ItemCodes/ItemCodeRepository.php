<?php

namespace App\Repositories\ItemCodes;

use App\Models\ItemCode;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

class ItemCodeRepository
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
        return ItemCode::class;
    }

    public function query()
    {
        return $this->model->query()
            ->selectRaw('
                item_codes.id       AS id,
                item_codes.item_id  AS item_id,
                item_codes.value    AS value
            ');
    }

    public function find(string $id)
    {
        return $this->model->query()->find($id);
    }

    public function findOrFail(string $id)
    {
        return $this->model->query()->findOrFail($id);
    }
}
