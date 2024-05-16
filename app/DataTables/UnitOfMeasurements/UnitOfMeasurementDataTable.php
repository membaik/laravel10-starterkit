<?php

namespace App\DataTables\UnitOfMeasurements;

use App\Repositories\UnitOfMeasurements\UnitOfMeasurementRepository;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UnitOfMeasurementDataTable extends DataTable
{
    private $unitOfMeasurementRepository;

    public function __construct(
        UnitOfMeasurementRepository $unitOfMeasurementRepository
    ) {
        $this->unitOfMeasurementRepository = $unitOfMeasurementRepository;
    }

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('is_active_to_text', function ($query) {
                return view('contents.unit-of-measurements.datatables.is-active', [
                    'query' => $query
                ]);
            })
            ->addColumn('action', function ($query) {
                return view('contents.unit-of-measurements.datatables.action', [
                    'query' => $query
                ]);
            })
            ->setRowAttr([
                'data-id' => function ($query) {
                    return $query->id;
                },
            ])
            ->rawColumns([
                'is_active_to_text'
            ])
            ->filterColumn('is_active', function ($query, $keyword) {
                $sql = 'IF(unit-of-measurements.is_active=1, "Active", "Inactive") like ?';
                $query->whereRaw($sql, ["{$keyword}%"]);
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(): QueryBuilder
    {
        return $this->unitOfMeasurementRepository->query();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('table_unit_of_measurement')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1, 'asc')
            ->drawCallback("function() { KTMenu.init(); }");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('#')
                ->searchable(false)
                ->orderable(false)
                ->width(5)
                ->addClass('text-center'),
            Column::make('name')
                ->title(__('Name')),
            Column::make('is_active_to_text')
                ->title(__('Status'))
                ->name('is_active'),
            Column::computed('action')
                ->title(__('Actions'))
                ->searchable(false)
                ->orderable(false)
                ->width(5)
                ->addClass('text-end'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Unit_of_Measurement_' . date('Y_m_d_His');
    }
}
