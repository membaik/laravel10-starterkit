<?php

namespace App\Http\Controllers\Entities;

use App\DataTables\Entities\EntityDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Entities\StoreEntityRequest;
use App\Http\Requests\Entities\UpdateEntityRequest;
use App\Repositories\Entities\EntityRepository;
use App\Repositories\EntityCategories\EntityCategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EntityController extends Controller
{
    private $entityRepository;
    private $entityCategoryRepository;

    public function __construct(
        EntityRepository $entityRepository,
        EntityCategoryRepository $entityCategoryRepository,
    ) {
        $this->entityRepository = $entityRepository;
        $this->entityCategoryRepository = $entityCategoryRepository;
    }

    public function index(EntityDataTable $dataTable)
    {
        return $dataTable->render('contents.entities.index');
    }

    public function create(): View
    {
        $entityCategories = $this->entityCategoryRepository->query()->where('entity_categories.is_active', true)->orderBy('entity_categories.sequence')->get();

        return view('contents.entities.create', [
            'entityCategories' => $entityCategories,
        ]);
    }

    public function store(StoreEntityRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->entityRepository->store($request->data());
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
        $query = $this->entityRepository->find($id);
        $entityCategories = $this->entityCategoryRepository->query()->where('entity_categories.is_active', true)->orderBy('entity_categories.sequence')->get();

        return view('contents.entities.edit', [
            'query' => $query,
            'entityCategories' => $entityCategories,
        ]);
    }

    public function update($id, UpdateEntityRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->entityRepository->update($id, $request->data());
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

            $res = $this->entityRepository->destroy($id);
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
