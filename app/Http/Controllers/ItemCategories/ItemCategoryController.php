<?php

namespace App\Http\Controllers\ItemCategories;

use App\DataTables\ItemCategories\ItemCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemCategories\StoreItemCategoryRequest;
use App\Http\Requests\ItemCategories\UpdateItemCategoryRequest;
use App\Repositories\ItemCategories\ItemCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ItemCategoryController extends Controller
{
    private $itemCategoryRepository;

    public function __construct(
        ItemCategoryRepository $itemCategoryRepository
    ) {
        $this->itemCategoryRepository = $itemCategoryRepository;
    }

    public function index(ItemCategoryDataTable $dataTable)
    {
        return $dataTable->render('contents.item-categories.index');
    }

    public function create(): View
    {
        return view('contents.item-categories.create');
    }

    public function store(StoreItemCategoryRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->itemCategoryRepository->store($request->data());
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
        $query = $this->itemCategoryRepository->find($id);

        return view('contents.item-categories.edit', [
            'query' => $query,
        ]);
    }

    public function update($id, UpdateItemCategoryRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->itemCategoryRepository->update($id, $request->data());
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

            $res = $this->itemCategoryRepository->destroy($id);
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
