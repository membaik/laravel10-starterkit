<?php

namespace App\Repositories\Items;

use App\Models\Item;
use App\Repositories\ItemCategories\ItemCategoryRepository;
use App\Repositories\ItemCodes\ItemCodeRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

class ItemRepository
{
    protected $app;
    protected $itemCategoryRepository;
    protected $itemCodeRepository;

    public function __construct(
        Application $app,
        ItemCategoryRepository $itemCategoryRepository,
        ItemCodeRepository $itemCodeRepository,
    ) {
        $this->app = $app;
        $this->makeModel();

        $this->itemCategoryRepository = $itemCategoryRepository;
        $this->itemCodeRepository = $itemCodeRepository;
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
        return Item::class;
    }

    public function query()
    {
        return $this->model->query()
            ->selectRaw('
                items.id                                    AS id,
                items.name                                  AS name,
                items.thumbnail_url                         AS thumbnail_url,
                items.is_active                             AS is_active,
                IF(items.is_active=1, "Active", "Inactive") AS status
            ');
    }

    public function store(array $data)
    {
        $query = $this->model->query()
            ->where('items.name', $data['name'])
            ->first();
        if ($query) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 409,
                    'message'   => 'Item is already exists',
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

        if ($data['categories']) {
            $itemCategories = $this->itemCategoryRepository->query()->whereIn('id', $data['categories'])->where('item_categories.is_active', true)->get();
            $query->itemCategories()->sync($itemCategories);
        }

        if ($data['details']) {
            foreach ($data['details'] as $detail) {
                $itemDetail = $query->itemDetails()->where('unit_of_measurement_id', $detail['unit_of_measurement_id'])->first();
                if ($itemDetail === null) {
                    $query->itemDetails()->create([
                        'unit_of_measurement_id' => $detail['unit_of_measurement_id'],
                        'quantity' => $detail['quantity'],
                        'cost' => $detail['cost'],
                        'is_active' => $detail['is_active'],
                    ]);
                }
            }
        }

        if ($data['codes']) {
            foreach ($data['codes'] as $code) {
                $itemCode = $this->itemCodeRepository->query()->where('item_codes.value', $code)->first();
                if ($itemCode === null) {
                    $query->itemCodes()->create([
                        'value' => $code,
                    ]);
                } else {
                    return [
                        'meta' => [
                            'success'   => false,
                            'code'      => 409,
                            'message'   => 'Item code ' . $code .  ' is already exists',
                            'errors'    => []
                        ],
                        'data' => [],
                    ];
                }
            }
        }

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Item created successfully',
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

        if ($data['is_thumbnail_removed'] === true) {
            $query->thumbnail_url = null;
        } else {
            if ($data['thumbnail_url']) {
                $query->thumbnail_url = $data['thumbnail_url'];
            }
        }

        $query->save();

        if ($data['categories']) {
            $itemCategories = $this->itemCategoryRepository->query()->whereIn('id', $data['categories'])->where('item_categories.is_active', true)->get();
            $query->itemCategories()->sync($itemCategories);
        }

        $itemDetailIds = $query->itemDetails->pluck("id", "id");
        if ($data['details']) {
            foreach ($data['details'] as $detail) {
                $itemDetail = $query->itemDetails()->where('unit_of_measurement_id', $detail['unit_of_measurement_id'])->first();
                if ($itemDetail === null) {
                    $query->itemDetails()->create([
                        'unit_of_measurement_id' => $detail['unit_of_measurement_id'],
                        'quantity' => $detail['quantity'],
                        'cost' => $detail['cost'],
                        'is_active' => $detail['is_active'],
                    ]);
                } else {
                    $itemDetail->quantity = $detail['quantity'];
                    $itemDetail->cost = $detail['cost'];
                    $itemDetail->is_active = $detail['is_active'];
                    $itemDetail->save();

                    if ($itemDetailIds->contains($itemDetail->id)) {
                        $itemDetailIds->forget($itemDetail->id);
                    }
                }
            }
        }

        if ($itemDetailIds->count()) {
            $query->itemDetails()->whereIn('id', $itemDetailIds->toArray())->delete();
        }

        $itemCodeIds = $query->itemCodes->pluck("id", "id");
        if ($data['codes']) {
            foreach ($data['codes'] as $code) {
                $itemCode = $query->itemCodes()->where('value', $code)->first();
                if ($itemCode) {
                    if ($itemCodeIds->contains($itemCode->id)) {
                        $itemCodeIds->forget($itemCode->id);
                    }
                } else {
                    $itemCode = $this->itemCodeRepository->query()->where('item_codes.value', $code)->first();
                    if ($itemCode === null) {
                        $query->itemCodes()->create([
                            'value' => $code,
                        ]);
                    } else {
                        return [
                            'meta' => [
                                'success'   => false,
                                'code'      => 409,
                                'message'   => 'Item code ' . $code .  ' is already exists',
                                'errors'    => []
                            ],
                            'data' => [],
                        ];
                    }
                }
            }
        }

        if ($itemCodeIds->count()) {
            $query->itemCodes()->whereIn('id', $itemCodeIds->toArray())->delete();
        }

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Item updated successfully',
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
                    'message'   => 'Item belongs to user',
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
                'message'   => 'Item deleted successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }
}
