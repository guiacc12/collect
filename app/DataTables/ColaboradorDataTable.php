<?php

namespace App\DataTables;

use App\Models\Colaborador;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ColaboradorDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function($query) {
                $detalhes = "<a href='#' class='btn btn-info btn-sm btnDetalhes' data-id='".$query->id."'><i class='fas fa-eye'></i></a>";
                $excluir = "<button class='btn btn-danger btn-sm btnExcluirColaborador' data-id='".$query->id."'><i class='fas fa-trash'></i></button>";
                return $detalhes . ' ' . $excluir;
            });
    }

    public function query(Colaborador $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
                    ->setTableId('colaboradores-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reload')
                    )
                    ->language([
                        'url' => asset('backend/assets/traducao-datatable-BR-collect/pt-BR-collect.json') // Tradução para português
                    ]);
    }

    protected function getColumns()
    {
        return [
            Column::make('nome')->title('Nome'),
            Column::make('telefone')->title('Telefone')->className('text-left'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Colaboradores_' . date('YmdHis');
    }
}
