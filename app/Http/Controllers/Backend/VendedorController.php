<?php

namespace App\Http\Controllers\Backend;

use App\Models\Vendedor;
use App\DataTables\VendedorDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VendedorDataTable $dataTable)
    {
        return $dataTable->render('admin.vendedor.index');
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
    // Validação dos dados
    $request->validate([
        'nome' => 'required|string|max:255',
        'whatsapp' => 'required|url',
        'telefone' => 'required|string|max:20',
    ]);

    // Criação do novo vendedor
    Vendedor::create([
        'nome' => $request->nome,
        'whatsapp' => $request->whatsapp,
        'telefone' => $request->telefone,
    ]);

    toastr()->success('Cadastrado com sucesso!');
    return redirect()->route('vendedor.index');
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
    $vendedor = Vendedor::findOrFail($id);
    return response()->json($vendedor); // Retorna os dados do vendedor como JSON
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $request->validate([
        'nome' => 'required|string|max:255',
        'whatsapp' => 'required|url',
        'telefone' => 'required|string|max:20',
    ]);

    $vendedor = Vendedor::findOrFail($id);

    // Atualiza os dados corretamente
    $vendedor->nome = $request->nome;
    $vendedor->telefone = $request->telefone;
    $vendedor->whatsapp = $request->whatsapp;
    $vendedor->save();

    toastr()->success('Atualizado com sucesso!');
    return redirect()->route('vendedor.index'); // Certifique-se de que a rota está correta
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vendedor = Vendedor::findOrFail($id);
        $vendedor->delete();

        return response(['status' => 'success', 'message' => 'Excluído com sucesso!']);
    }

    
}
