<?php

namespace App\DataTables;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProdutoDataTable extends DataTable
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
                $edit= "<a href='".route('produto.edit', $query->id)."' class='btn btn-primary mb-2'><i class='far fa-edit'></i></a>";
                $delete= "<a href='".route('produto.destroy', $query->id)."' class='btn btn-danger delete-item'><i class='far fa-trash-alt'></i></a>";
                return $edit.$delete;
            })
            ->addColumn('status', function($query){
                if($query->status == 1){
                $botao = '<label class="custom-switch mt-2">
                        <input type="checkbox" checked name="custom-switch-checkbox" data-id="'.$query->id.'" class="custom-switch-input pMuda-status">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description"></span>
                      </label>';
                }else{
                    $botao = '<label class="custom-switch mt-2">
                        <input type="checkbox" name="custom-switch-checkbox" data-id="'.$query->id.'" class="custom-switch-input pMuda-status">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description"></span>
                      </label>';
                }
                    return $botao;
            })
            ->addColumn('categoria', function($query){
                return $query->categoria->nome; // Exibe o nome da categoria
            })
            ->addColumn('imagem', function($query){
               return $img = "<img src='". asset($query->imagem) ."' style='width: 35%; height:auto;'>";
            })
            ->rawColumns(['status', 'imagem', 'action', 'categoria'])
            ->setRowId('id');

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Produto $model): QueryBuilder
    {
        return $model->newQuery()->with('categoria');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    //->setTableId('brasilTraducaoCollect')
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

            Column::make('id'),
            Column::make('imagem'),
            Column::make('titulo'),
            Column::make('valor')->className('text-left'),
            Column::make('categoria'),
            Column::make('status'),
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
        return 'Produto_' . date('YmdHis');
    }
}
