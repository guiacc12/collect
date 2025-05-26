<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ColaboradorDataTable;
use App\Models\Colaborador;
use App\Models\Servico;
use App\Models\ColaboradorServico;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ColaboradorController extends Controller
{
    // Listar colaboradores
    public function index(ColaboradorDataTable $dataTable)
    {
        return $dataTable->render('admin.colaborador.index');
    }

    // Adicionar colaborador
    public function storeColaborador(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
        ]);

        Colaborador::create($request->all());

        return response()->json(['success' => true]);
    }

    // Adicionar serviço
    public function storeServico(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Servico::create($request->all());

        return response()->json(['success' => true]);
    }

    // Adicionar serviço a um colaborador
    public function storeServicoColaborador(Request $request, $colaboradorId)
    {
    $request->validate([
        'servico_id' => 'required|exists:servicos,id',
        'quantidade' => 'required|integer|min:1',
        'valor' => 'required|numeric',
        'data_producao' => 'required|date',
    ]);

    try {
        ColaboradorServico::create([
            'colaborador_id' => $colaboradorId,
            'servico_id' => $request->servico_id,
            'quantidade' => $request->quantidade,
            'valor' => $request->valor,
            'data_producao' => $request->data_producao,
        ]);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Erro ao adicionar serviço.'], 500);
    }
    }

    // Detalhes do colaborador
    public function detalhes($colaboradorId, Request $request)
    {
    $colaborador = Colaborador::find($colaboradorId);

    if (!$colaborador) {
        return response()->json(['error' => 'Colaborador não encontrado'], 404);
    }

    $query = $colaborador->servicos();

    if ($request->has('data_inicio') && $request->has('data_fim')) {
        $query->whereBetween('colaborador_servico.data_producao', [
            $request->data_inicio,
            $request->data_fim
        ]);
    }

    $servicos = $query->get()->map(function ($servico) {
        return [
            'nome_servico' => $servico->nome,
            'quantidade' => $servico->pivot->quantidade,
            'valor' => number_format($servico->pivot->valor, 2, ',', '.'),
            'valor_total' => number_format($servico->pivot->valor * $servico->pivot->quantidade, 2, ',', '.'),
            'data_producao' => $servico->pivot->data_producao,
        ];
    });

    return response()->json([
        'servicos' => $servicos,
    ]);
    }

    public function listarServicos()
    {
        $servicos = Servico::select('id', 'nome')->get();
        return response()->json($servicos);
    }

    public function destroy($id)
    {
    try {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->delete();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Erro ao excluir colaborador.'], 500);
    }
    }

}
