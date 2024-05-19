<?php

namespace App\Http\Controllers\Items;

use App\DataTables\Items\ItemDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Items\StoreItemRequest;
use App\Http\Requests\Items\UpdateItemRequest;
use App\Repositories\Items\ItemRepository;
use App\Repositories\ItemCategories\ItemCategoryRepository;
use App\Repositories\UnitOfMeasurements\UnitOfMeasurementRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ItemController extends Controller
{
    private $itemRepository;
    private $itemCategoryRepository;
    private $unitOfMeasurementRepository;

    public function __construct(
        ItemRepository $itemRepository,
        ItemCategoryRepository $itemCategoryRepository,
        UnitOfMeasurementRepository $unitOfMeasurementRepository,
    ) {
        $this->itemRepository = $itemRepository;
        $this->itemCategoryRepository = $itemCategoryRepository;
        $this->unitOfMeasurementRepository = $unitOfMeasurementRepository;
    }

    public function index(ItemDataTable $dataTable)
    {
        return $dataTable->render('contents.items.index');
    }

    public function create(): View
    {
        $itemCategories = $this->itemCategoryRepository->query()->where('item_categories.is_active', true)->orderBy('item_categories.name')->get();
        $unitOfMeasurements = $this->unitOfMeasurementRepository->query()->where('unit_of_measurements.is_active', true)->orderBy('unit_of_measurements.name')->get();

        return view('contents.items.create', [
            'itemCategories' => $itemCategories,
            'unitOfMeasurements' => $unitOfMeasurements,
        ]);
    }

    public function store(StoreItemRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->itemRepository->store($request->data());
            if ($res['meta']['success'] === true) {
                DB::commit();
            } else {
                DB::rollback();
            }
        } catch (\Exception $e) {
            DB::rollback();

            $res = [
                'meta' => [
                    'success'   => false,
                    'code'      => \App\Constants\StatusCodeConstant::label($e->getCode()) ? $e->getCode() : 500,
                    'message'   => $e->getMessage(),
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        return response()->json($res, $res['meta']['code']);
    }

    public function edit($id): View
    {
        $query = $this->itemRepository->find($id);
        $itemCategories = $this->itemCategoryRepository->query()->where('item_categories.is_active', true)->orderBy('item_categories.name')->get();
        $unitOfMeasurements = $this->unitOfMeasurementRepository->query()->where('unit_of_measurements.is_active', true)->orderBy('unit_of_measurements.name')->get();

        return view('contents.items.edit', [
            'query' => $query,
            'itemCategories' => $itemCategories,
            'unitOfMeasurements' => $unitOfMeasurements,
        ]);
    }

    public function update($id, UpdateItemRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->itemRepository->update($id, $request->data());
            if ($res['meta']['success'] === true) {
                DB::commit();
            } else {
                DB::rollback();
            }
        } catch (\Exception $e) {
            DB::rollback();

            $res = [
                'meta' => [
                    'success'   => false,
                    'code'      => \App\Constants\StatusCodeConstant::label($e->getCode()) ? $e->getCode() : 500,
                    'message'   => $e->getMessage(),
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        return response()->json($res, $res['meta']['code']);
    }

    public function destroy($id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->itemRepository->destroy($id);
            if ($res['meta']['success'] === true) {
                DB::commit();
            } else {
                DB::rollback();
            }
        } catch (\Exception $e) {
            DB::rollback();

            $res = [
                'meta' => [
                    'success'   => false,
                    'code'      => \App\Constants\StatusCodeConstant::label($e->getCode()) ? $e->getCode() : 500,
                    'message'   => $e->getMessage(),
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        return response()->json($res, $res['meta']['code']);
    }
}
