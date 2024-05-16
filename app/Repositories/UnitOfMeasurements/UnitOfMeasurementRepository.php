<?php

namespace App\Repositories\UnitOfMeasurements;

use App\Models\UnitOfMeasurement;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

class UnitOfMeasurementRepository
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
        return UnitOfMeasurement::class;
    }

    public function query()
    {
        return $this->model->query()
            ->selectRaw('
                unit_of_measurements.id                                     AS id,
                unit_of_measurements.name                                   AS name,
                unit_of_measurements.is_active                              AS is_active,
                IF(unit_of_measurements.is_active=1, "Active", "Inactive")  AS status
            ');
    }

    public function store(array $data)
    {
        $query = $this->model->query()
            ->where('unit_of_measurements.name', $data['name'])
            ->first();
        if ($query) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 409,
                    'message'   => 'Unit of measurement is already exists',
                    'errors'    => []
                ],
                'data' => [],
            ];
        }

        $query = $this->model->query()
            ->create([
                'name' => $data['name'],
                'is_active' => $data['is_active'],
            ]);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Unit of measurement created successfully',
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
        $query->is_active = $data['is_active'];
        $query->save();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Unit of measurement updated successfully',
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
                'message'   => 'Unit of measurement deleted successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }
}
