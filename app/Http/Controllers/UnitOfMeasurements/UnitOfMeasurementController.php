<?php

namespace App\Http\Controllers\UnitOfMeasurements;

use App\DataTables\UnitOfMeasurements\UnitOfMeasurementDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UnitOfMeasurements\StoreUnitOfMeasurementRequest;
use App\Http\Requests\UnitOfMeasurements\UpdateUnitOfMeasurementRequest;
use App\Repositories\UnitOfMeasurements\UnitOfMeasurementRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UnitOfMeasurementController extends Controller
{
    private $unitOfMeasurementRepository;

    public function __construct(
        UnitOfMeasurementRepository $unitOfMeasurementRepository
    ) {
        $this->unitOfMeasurementRepository = $unitOfMeasurementRepository;
    }

    public function index(UnitOfMeasurementDataTable $dataTable)
    {
        return $dataTable->render('contents.unit-of-measurements.index');
    }

    public function create(): View
    {
        return view('contents.unit-of-measurements.create');
    }

    public function store(StoreUnitOfMeasurementRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->unitOfMeasurementRepository->store($request->data());
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
        $query = $this->unitOfMeasurementRepository->find($id);

        return view('contents.unit-of-measurements.edit', [
            'query' => $query,
        ]);
    }

    public function update($id, UpdateUnitOfMeasurementRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $res = $this->unitOfMeasurementRepository->update($id, $request->data());
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

            $res = $this->unitOfMeasurementRepository->destroy($id);
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
