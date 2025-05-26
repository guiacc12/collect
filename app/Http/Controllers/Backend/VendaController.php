<?php

namespace App\Http\Controllers\Backend;

use App\Models\Venda;
use App\Models\Vendedor;
use App\DataTables\VendaDataTable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class VendaController extends Controller
{
    public function index(VendaDataTable $dataTable)
    {
    return $dataTable->render('admin.vendas.index');
    }

    public function getVendas(Request $request, $vendedor_id)
    {
        $query = Venda::where('vendedor_id', $vendedor_id);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $totalVendas = $query->sum('valor_venda');
        $totalPecas = $query->sum('quantidade');

        return response()->json([
            'total_pecas' => $totalPecas,
            'total_vendas' => $totalVendas,
            'vendas' => $query->get(),
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $venda = Venda::findOrFail($id);
        $venda->status = $request->status;
        $venda->save();

        return response()->json(['message' => 'Status atualizado com sucesso!']);
    }

    public function show($id)
    {
        return response()->json(Venda::findOrFail($id));
    }

    public function buscarVendas(Request $request, $id)
    {
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    $vendas = Venda::where('vendedor_id', $id);

    if ($startDate && $endDate) {
        $vendas->whereBetween('created_at', [$startDate, $endDate]);
    }

    return DataTables::of($vendas)->make(true);
    }

    public function detalhes($id)
    {
    $venda = Venda::with(['vendedor'])->findOrFail($id);

    return view('admin.vendas.detalhes', compact('venda'));
    }

    public function concluirVenda($id)
{
    $venda = Venda::findOrFail($id);
    $venda->status = true; // Define o status como true (1) para "Venda concluída"
    $venda->save();

    return response()->json(['success' => true]);
}

}
