<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Promocao;
use App\Models\Produto;
use App\Models\Categoria;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::where('status', 1)->get();
        $promocoes = Promocao::where('status', 1)->get();
        $produtos = Produto::where('status', 1)->get();


        $produtosEmPromocao = $produtos->whereNotNull('promocao_id')->shuffle();
        $outrosProdutos = $produtos->whereNull('promocao_id')->shuffle();
        $produtosSelecionados = $produtosEmPromocao->concat($outrosProdutos)->take(15);

        $itens = collect($sliders)->merge($promocoes)->shuffle();

        return view('front-end.index', compact('itens', 'produtosSelecionados'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
