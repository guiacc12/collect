<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProdutoDataTable;
use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Promocao;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdutoController extends Controller
{
    use UploadImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(ProdutoDataTable $dataTable)
    {
        return $dataTable->render('admin.produto.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        $promocaos = Promocao::all();
        return view('admin.produto.create', compact('categorias', 'promocaos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'imagem' => ['required', 'image', 'max:2048'],
            'titulo' => ['string', 'unique:produtos,titulo', 'max:200'],
            'descricao' => ['required', 'max:1000'],
            'valor' => ['required', 'numeric'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'promocao_id' => ['nullable', 'exists:promocaos,id'],
            'valor_promocional' => ['nullable', 'numeric'],
            'status' => ['required'],
        ]);

        $produto = new Produto();

        $imagePath = $this->uploadImage($request, 'imagem', 'uploads');

        $produto->imagem = $imagePath;
        $produto->titulo = $request->titulo;
        $produto->descricao = $request->descricao;
        $produto->valor = $request->valor;
        $produto->categoria_id = $request->categoria_id;
        $produto->slug = Str::slug($request->titulo);
        $produto->promocao_id = $request->promocao_id;
        $produto->valor_promocional = $request->valor_promocional;
        $produto->status = $request->status;
        $produto->save();

        toastr()->success('Cadastrado com sucesso!');
        return redirect()->route('produto.index');
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
        $produto = Produto::findOrFail($id);
        $categorias = Categoria::all();
        $promocaos = Promocao::all();
        return view('admin.produto.edit', compact('categorias', 'produto', 'promocaos'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'imagem' => ['nullable', 'image', 'max:2048'],
            'titulo' => ['string', 'max:200', 'unique:produtos,titulo,'.$id],
            'descricao' => ['required', 'max:1000'],
            'valor' => ['required', 'numeric'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'promocao_id' => ['nullable', 'exists:promocaos,id'],
            'valor_promocional' => ['nullable', 'numeric'],
            'status' => ['required'],
        ]);

        $produto = Produto::findOrFail($id);

        if ($request->hasFile('imagem')) {
            $imagePath = $this->updateImage($request, 'imagem', 'uploads', $produto->imagem);
            $produto->imagem = $imagePath;
        }
        $produto->titulo = $request->titulo;
        $produto->descricao = $request->descricao;
        $produto->valor = $request->valor;
        $produto->categoria_id = $request->categoria_id;
        $produto->slug = Str::slug($request->titulo);
        $produto->promocao_id = $request->promocao_id;
        $produto->valor_promocional = $request->valor_promocional;
        $produto->status = $request->status;
        $produto->save();

        toastr('Atualizado com sucesso!', 'success');
        return redirect()->route('produto.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produto = Produto::findOrFail($id);
        $this->deleteImage ($produto->imagem);
        $produto->delete();

        return response(['status' => 'success', 'message' => 'Excluído com sucesso!']);
    }

    public function pMudaStatus(Request $request)
    {
        $produto = Produto::findOrFail($request->id);
        $produto->status = $request->status == 'true' ? 1 : 0;
        $produto->save();

        return response(['message' => 'Status atualizado com sucesso!']);
    }


    public function getProdutos()
    {
        $produtos = Produto::where('status', 1) // Apenas produtos disponíveis
            ->get(['imagem', 'titulo', 'descricao', 'valor', 'valor_promocional', 'promocao_id']);

        return response()->json($produtos);
    }

}
