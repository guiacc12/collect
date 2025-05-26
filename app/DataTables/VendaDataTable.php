<?php

namespace App\DataTables;

use App\Models\Venda;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendaDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($venda) {
                return '<a href="' . route('vendas.detalhes', $venda->id) . '" class="btn btn-primary btn-sm">Detalhes</a>';
            })
            ->editColumn('status', function ($venda) {
                // Exibe "0: Em progresso" ou "1: Concluído"
                return $venda->status ? '1: Concluído' : '0: Em progresso';
            });
    }

    public function query(Venda $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
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

    protected function getColumns(): array
    {
        return [
            Column::make('id')->className('text-left'),
            Column::make('produto_nome'),
            Column::make('comprador_nome'),
            Column::make('quantidade')->className('text-left'),
            Column::make('valor_venda')->className('text-left'),
            Column::make('status')->className('text-left'), // Alinha o status à esquerda
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Vendas_' . date('YmdHis');
    }
}
