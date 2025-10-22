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

    // Mostrar detalhes do colaborador
    public function show(Colaborador $colaborador)
    {
        $colaborador->load(['colaboradorServicos.servico']);
        return view('admin.colaborador.show', compact('colaborador'));
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
    public function adicionarServicoColaborador(Request $request, $colaboradorId)
    {
        $validated = $request->validate([
            'servico_id' => 'required|exists:servicos,id',
            'quantidade' => 'required|integer|min:1',
            'valor' => 'required|numeric|min:0',
            'data_producao' => 'required|date',
        ]);

        $validated['colaborador_id'] = $colaboradorId;

        $colaboradorServico = ColaboradorServico::create($validated);

        return response()->json(['success' => true, 'message' => 'Serviço adicionado com sucesso!']);
    }    // Detalhes do colaborador
    public function detalhes($colaboradorId, Request $request)
    {
        $colaborador = Colaborador::find($colaboradorId);

        if (!$colaborador) {
            return response()->json(['error' => 'Colaborador não encontrado'], 404);
        }

        $query = $colaborador->colaboradorServicos()->with('servico');

        if ($request->has('data_inicio') && $request->has('data_fim')) {
            $query->whereBetween('data_producao', [
                $request->data_inicio,
                $request->data_fim
            ]);
        }

        $servicos = $query->get()->map(function ($colaboradorServico) {
            return [
                'id' => $colaboradorServico->id,
                'nome_servico' => $colaboradorServico->servico->nome,
                'quantidade' => $colaboradorServico->quantidade,
                'valor' => number_format($colaboradorServico->valor, 2, ',', '.'),
                'valor_total' => number_format($colaboradorServico->valor_total, 2, ',', '.'),
                'data_producao' => \Carbon\Carbon::parse($colaboradorServico->data_producao)->format('d/m/Y'),
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

    // Excluir serviço de um colaborador
    public function destroyServicoColaborador($colaboradorId, $servicoId)
    {
        try {
            $colaboradorServico = ColaboradorServico::where('colaborador_id', $colaboradorId)
                ->where('id', $servicoId)
                ->firstOrFail();

            $colaboradorServico->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao excluir serviço.'], 500);
        }
    }

}
