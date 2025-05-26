<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Produto;

class PortifolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categorias = Categoria::where('status', 1)->get();
        return view('front-end.portifolio', compact('categorias'));
    }

    public function produtosPorCategoria($slug)
    {
    // Buscar a categoria pelo slug
    $categorias = Categoria::where('slug', $slug)->firstOrFail();

    // Buscar produtos relacionados à categoria
    $produtos = Produto::where('categoria_id', $categorias->id)->get();

    return view('front-end.produtos.index', compact('categorias', 'produtos'));
    }


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
    public function show($categoria, $produto)
{
    $produto = Produto::where('slug', $produto)->firstOrFail();
    return view('front-end.produtos.show', compact('produto'));
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
