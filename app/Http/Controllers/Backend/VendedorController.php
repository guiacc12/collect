<?php

namespace App\Http\Controllers\Backend;

use App\Models\Vendedor;
use App\Models\User;
use App\DataTables\VendedorDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
        'email' => 'required|email|unique:users,email|unique:vendedors,email',
        'senha' => 'required|string|min:6',
        'comissao' => 'required|numeric|min:0|max:100',
    ]);

    // Criação do usuário na tabela users
    $user = User::create([
        'name' => $request->nome,
        'email' => $request->email,
        'password' => Hash::make($request->senha),
        'role' => 'vendor',
    ]);

    // Criação do novo vendedor
    Vendedor::create([
        'nome' => $request->nome,
        'whatsapp' => $request->whatsapp,
        'telefone' => $request->telefone,
        'email' => $request->email,
        'senha' => Hash::make($request->senha),
        'role' => 'vendor',
        'comissao' => $request->comissao,
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

        // Correção: buscar usuário pelo email, não pelo nome
        $user = User::where('email', $vendedor->email)->first();

        return response()->json([
            'nome' => $vendedor->nome,
            'telefone' => $vendedor->telefone,
            'whatsapp' => $vendedor->whatsapp,
            'email' => $vendedor->email ?? null,
            'role' => $vendedor->role ?? 'vendor',
            'comissao' => $vendedor->comissao,
            'senha' => '',
        ]);
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
            'email' => 'required|email',
            'senha' => 'nullable|string|min:6',
            'comissao' => 'required|numeric|min:0|max:100',
        ]);

        $vendedor = Vendedor::findOrFail($id);
        $oldEmail = $vendedor->email;

        // Atualizar vendedor
        $vendedor->nome = $request->nome;
        $vendedor->telefone = $request->telefone;
        $vendedor->whatsapp = $request->whatsapp;
        $vendedor->email = $request->email;
        $vendedor->comissao = $request->comissao;

        // Atualizar senha apenas se fornecida
        if (!empty($request->senha)) {
            $vendedor->senha = Hash::make($request->senha);
        }

        $vendedor->save();

        // Atualizar usuário correspondente na tabela users
        $user = User::where('email', $oldEmail)->first();
        if ($user) {
            $user->name = $request->nome;
            $user->email = $request->email;

            if (!empty($request->senha)) {
                $user->password = Hash::make($request->senha);
            }

            $user->save();
        }

        toastr()->success('Atualizado com sucesso!');
        return redirect()->route('vendedor.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vendedor = Vendedor::findOrFail($id);
        $user = User::where('email', $vendedor->email)->first();
        if ($user) {
        $user->delete();
    }
        $vendedor->delete();

        return response(['status' => 'success', 'message' => 'Excluído com sucesso!']);
    }


}
