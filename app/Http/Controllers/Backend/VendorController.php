<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Vendedor;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VendorController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $vendedor = Vendedor::where('email', $user->email)->first();

        if (!$vendedor) {
            return redirect()->route('login')->with('error', 'Vendedor não encontrado.');
        }

        // Estatísticas do vendedor
        $totalVendas = Venda::where('vendedor_id', $vendedor->id)->count();
        $valorTotalVendas = Venda::where('vendedor_id', $vendedor->id)->sum('valor_venda');

        // Vendas do mês atual
        $vendasMesAtual = Venda::where('vendedor_id', $vendedor->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Comissão do mês atual
        $comissaoMesAtual = $vendedor->comissaoDoMes();

        // Valor das vendas concluídas do mês atual
        $valorVendasMesAtual = Venda::where('vendedor_id', $vendedor->id)
            ->where('status', true) // Apenas vendas confirmadas
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('valor_venda');

        // Estado que mais vendeu
        $estadoMaisVendeu = Venda::where('vendedor_id', $vendedor->id)
            ->selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->orderBy('total', 'desc')
            ->first();

        // Vendas recentes (ordenadas por status - não concluídas primeiro)
        $vendasRecentes = Venda::where('vendedor_id', $vendedor->id)
            ->orderBy('status', 'asc') // false (0) vem antes de true (1)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('vendor.index', compact(
            'vendedor',
            'totalVendas',
            'valorTotalVendas',
            'vendasMesAtual',
            'valorVendasMesAtual',
            'comissaoMesAtual',
            'estadoMaisVendeu',
            'vendasRecentes'
        ));
    }

    public function getVendasData(Request $request)
    {
        $user = Auth::user();
        $vendedor = Vendedor::where('email', $user->email)->first();

        if (!$vendedor) {
            return response()->json(['error' => 'Vendedor não encontrado'], 404);
        }

        $query = Venda::where('vendedor_id', $vendedor->id);

        // Filtrar por data se fornecido
        if ($request->has('data_inicio') && $request->data_inicio) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }

        if ($request->has('data_fim') && $request->data_fim) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        $vendas = $query->orderBy('status', 'asc') // Não concluídas primeiro
            ->orderBy('created_at', 'desc')
            ->get();

        return datatables($vendas)
            ->addColumn('status_badge', function ($venda) {
                $class = $venda->status ? 'success' : 'warning';
                $text = $venda->status ? 'Concluída' : 'Pendente';
                return "<span class='badge badge-{$class}'>{$text}</span>";
            })
            ->addColumn('valor_formatado', function ($venda) {
                return 'R$ ' . number_format($venda->valor_venda, 2, ',', '.');
            })
            ->addColumn('data_formatada', function ($venda) {
                return $venda->created_at->format('d/m/Y H:i');
            })
            ->addColumn('actions', function ($venda) {
                return '<button class="btn btn-sm btn-info mr-1" onclick="verDetalhes('.$venda->id.')">
                    <i class="fas fa-eye"></i> Detalhes
                </button>
                <button class="btn btn-sm btn-danger" onclick="excluirVenda('.$venda->id.')">
                    <i class="fas fa-trash"></i> Excluir
                </button>';
            })
            ->rawColumns(['status_badge', 'actions'])
            ->make(true);
    }

    public function getStatsByPeriod(Request $request)
    {
        $user = Auth::user();
        $vendedor = Vendedor::where('email', $user->email)->first();

        if (!$vendedor) {
            return response()->json(['error' => 'Vendedor não encontrado'], 404);
        }

        $dataInicio = $request->get('data_inicio');
        $dataFim = $request->get('data_fim');

        // Se não houver datas, usar mês atual
        if (!$dataInicio || !$dataFim) {
            $dataInicio = now()->startOfMonth()->format('Y-m-d');
            $dataFim = now()->endOfMonth()->format('Y-m-d');
        }

        // Vendas do período
        $vendasPeriodo = Venda::where('vendedor_id', $vendedor->id)
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->count();

        // Valor das vendas concluídas do período
        $valorVendasPeriodo = Venda::where('vendedor_id', $vendedor->id)
            ->where('status', true) // Apenas vendas confirmadas
            ->whereBetween('created_at', [$dataInicio, $dataFim])
            ->sum('valor_venda');

        // Comissão do período
        $comissaoPeriodo = ($valorVendasPeriodo * $vendedor->comissao) / 100;

        return response()->json([
            'vendas_periodo' => $vendasPeriodo,
            'valor_vendas_periodo' => $valorVendasPeriodo,
            'comissao_periodo' => $comissaoPeriodo,
            'periodo_formatado' => Carbon::parse($dataInicio)->format('d/m/Y') . ' - ' . Carbon::parse($dataFim)->format('d/m/Y')
        ]);
    }

    public function storeVenda(Request $request)
    {
        $user = Auth::user();
        $vendedor = Vendedor::where('email', $user->email)->first();

        if (!$vendedor) {
            return response()->json(['error' => 'Vendedor não encontrado'], 404);
        }

        // Validar dados
        $request->validate([
            'comprador_nome' => 'required|string|max:255',
            'valor_venda' => 'required|numeric|min:0.01',
            'descricao' => 'required|string|max:2000',
            'cpf_cnpj' => 'nullable|string|max:20',
            'cep' => 'nullable|string|max:10',
            'rua' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'complemento' => 'nullable|string|max:255',
        ]);

        try {
            $vendaData = $request->only([
                'comprador_nome', 'valor_venda', 'descricao',
                'cpf_cnpj', 'cep', 'rua', 'numero', 'bairro', 'cidade', 'estado', 'complemento'
            ]);
            $vendaData['vendedor_id'] = $vendedor->id;
            $vendaData['status'] = false; // Venda pendente por padrão
            $venda = Venda::create($vendaData);

            return response()->json([
                'success' => true,
                'message' => 'Venda cadastrada com sucesso!',
                'venda_id' => $venda->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar venda: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteVenda($id)
    {
        $user = Auth::user();
        $vendedor = Vendedor::where('email', $user->email)->first();

        if (!$vendedor) {
            return response()->json(['error' => 'Vendedor não encontrado'], 404);
        }

        try {
            $venda = Venda::where('id', $id)->where('vendedor_id', $vendedor->id)->first();

            if (!$venda) {
                return response()->json([
                    'success' => false,
                    'message' => 'Venda não encontrada ou você não tem permissão para excluí-la.'
                ], 404);
            }

            $venda->delete();

            return response()->json([
                'success' => true,
                'message' => 'Venda excluída com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao excluir venda: ' . $e->getMessage()
            ], 500);
        }
    }



}
