<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin/dashboard');
    }

    public function login()
    {
        return view('admin/auth/login');
    }

    public function forgot()
    {
        return view('admin/auth/forgot-password');
    }

    public function faturamentoIndex()
    {
        return view('admin.faturamento.index');
    }

    public function faturamentoFiltrar(Request $request)
    {
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');
        $status = $request->input('status');

        // Query base
        $query = \App\Models\Venda::query();

        // Aplicar filtros de data
        if ($dataInicio && $dataFim) {
            $query->whereBetween('created_at', [$dataInicio . ' 00:00:00', $dataFim . ' 23:59:59']);
        }

        // Aplicar filtro de status
        if ($status !== null && $status !== '') {
            $query->where('status', (bool) $status);
        }

        // Estatísticas principais
        $vendasConcluidas = (clone $query)->where('status', true)->count();
        $vendasAberto = (clone $query)->where('status', false)->count();
        $totalFaturado = (clone $query)->where('status', true)->sum('valor_venda');

        $vendasParaTicket = (clone $query)->where('status', true);
        $totalVendas = $vendasParaTicket->count();
        $ticketMedio = $totalVendas > 0 ? $totalFaturado / $totalVendas : 0;

        // Estado top vendas
        $estadoTop = (clone $query)->select('estado', DB::raw('COUNT(*) as total'))
            ->where('status', true)
            ->groupBy('estado')
            ->orderByDesc('total')
            ->first();

        // Performance semanal (baseada no período filtrado)
        if ($dataInicio && $dataFim) {
            // Se há filtro de data, usar o período filtrado
            $vendasSemana = (clone $query)->where('status', true)->sum('valor_venda');
            $qtdSemana = (clone $query)->where('status', true)->count();
        } else {
            // Se não há filtro, usar semana atual
            $vendasSemana = \App\Models\Venda::where('status', true)
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->sum('valor_venda');
            $qtdSemana = \App\Models\Venda::where('status', true)
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();
        }

        // Calcular percentual da meta semanal
        $metaSemanal = 50000; // Meta de R$ 50.000 por semana
        $percentualMeta = $metaSemanal > 0 ? min(($vendasSemana / $metaSemanal) * 100, 100) : 0;

        // Status das vendas
        $totalTodasVendas = (clone $query)->count();
        $percentualConcluidas = $totalTodasVendas > 0 ? ($vendasConcluidas / $totalTodasVendas) * 100 : 0;

        // Top 5 Vendedores
        $vendedorIds = (clone $query)->where('status', true)->pluck('vendedor_id')->unique();
        $topVendedores = \App\Models\Vendedor::whereIn('id', $vendedorIds)
            ->with(['vendas' => function($q) use ($dataInicio, $dataFim) {
                $q->where('status', true);
                if ($dataInicio && $dataFim) {
                    $q->whereBetween('created_at', [$dataInicio . ' 00:00:00', $dataFim . ' 23:59:59']);
                }
            }])
            ->get()
            ->map(function($vendedor) {
                return [
                    'nome' => $vendedor->nome,
                    'total' => $vendedor->vendas->sum('valor_venda'),
                    'quantidade' => $vendedor->vendas->count()
                ];
            })
            ->sortByDesc('total')
            ->take(5);

        // Top 5 Cidades
        $topCidades = (clone $query)->select('cidade', DB::raw('COUNT(*) as quantidade'), DB::raw('SUM(valor_venda) as total'))
            ->where('status', true)
            ->groupBy('cidade')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Resumo executivo
        $totalVendasResumo = (clone $query)->count();
        $faturamentoResumo = (clone $query)->where('status', true)->sum('valor_venda');
        $estadosAtendidos = (clone $query)->select('estado')->distinct()->count();
        $cidadesAtendidas = (clone $query)->select('cidade')->distinct()->count();
        $vendedoresAtivos = \App\Models\Vendedor::has('vendas')->count();

        // Calcular média diária baseada no período filtrado
        if ($dataInicio && $dataFim) {
            $dias = \Carbon\Carbon::parse($dataInicio)->diffInDays(\Carbon\Carbon::parse($dataFim)) + 1;
        } else {
            $dias = now()->day;
        }
        $mediaDiaria = $dias > 0 ? $faturamentoResumo / $dias : 0;

        return response()->json([
            'vendasConcluidas' => $vendasConcluidas,
            'vendasAberto' => $vendasAberto,
            'totalFaturado' => number_format($totalFaturado, 2, ',', '.'),
            'ticketMedio' => number_format($ticketMedio, 2, ',', '.'),
            'estadoTop' => $estadoTop,
            'vendasSemana' => number_format($vendasSemana, 2, ',', '.'),
            'qtdSemana' => $qtdSemana,
            'percentualMeta' => number_format($percentualMeta, 1),
            'metaSemanal' => number_format($metaSemanal, 2, ',', '.'),
            'percentualConcluidas' => number_format($percentualConcluidas, 1),
            'topVendedores' => $topVendedores,
            'topCidades' => $topCidades,
            'resumo' => [
                'totalVendas' => $totalVendasResumo,
                'faturamento' => number_format($faturamentoResumo, 0, ',', '.'),
                'estadosAtendidos' => $estadosAtendidos,
                'cidadesAtendidas' => $cidadesAtendidas,
                'vendedoresAtivos' => $vendedoresAtivos,
                'mediaDiaria' => number_format($mediaDiaria, 0, ',', '.')
            ]
        ]);
    }
}
