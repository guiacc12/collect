<?php

namespace App\DataTables;

use App\Models\Vendedor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendedorDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
    return (new EloquentDataTable($query))
        ->addColumn('action', function($query){
            $edit = "<a href='#' class='btn btn-primary mb-2 edit-vendedor' data-id='".$query->id."' data-toggle='modal' data-target='#editVendedorModal'><i class='far fa-edit'></i></a>";
            $delete = "<a href='".route('vendedor.destroy', $query->id)."' class='btn btn-danger delete-item'><i class='far fa-trash-alt'></i></a>";
            return $edit . $delete;
        })
        ->addColumn('nome', function($query) {
            return '<a href="#" class="view-vendas" data-id="' . $query->id . '" data-nome="' . $query->nome . '">' . $query->nome . '</a>';
        })
        ->rawColumns(['action', 'nome']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Vendedor $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    //->setTableId('vendedor-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->language([
                        'url' => asset('backend/assets/traducao-datatable-BR-collect/pt-BR-collect.json')
                    ])
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            
            Column::make('nome')->title('Nome')->orderable(false)->searchable(false),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Vendedor_' . date('YmdHis');
    }
}
