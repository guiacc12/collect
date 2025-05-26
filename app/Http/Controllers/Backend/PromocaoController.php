<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\PromocaoDataTable;
use App\Http\Controllers\Controller;
use App\Models\Promocao;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromocaoController extends Controller
{
    use UploadImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(PromocaoDataTable $dataTable)
{
    $now = now();

    // Ativa promoções cuja data de início já passou
    Promocao::where('inicio', '<=', $now)
           ->where('status', 0)
           ->update(['status' => 1]);

    // Desativa promoções cuja data de fim já passou
    Promocao::where('fim', '<=', $now)
           ->where('status', 1)
           ->update(['status' => 0]);

    // Renderiza a DataTable
    return $dataTable->render('admin/promocao/index');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/promocao/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'imagem' => ['required', 'image', 'max:2048'],
            'titulo' => ['string', 'unique:promocaos,titulo', 'max:200'],
            'status' => ['required'],
            'inicio' => ['required', 'date'],
            'fim' => ['required', 'date', 'after:inicio'],
        ]);

        $statusAutomatico = now() >= $request->inicio && now() <= $request->fim;
        $status = $request->status == 1 ? 1 : ($statusAutomatico ? 1 : 0);

        $imagePath = $this->uploadImage($request, 'imagem', 'uploads');

        $promocao = new Promocao();
        $promocao->imagem = $imagePath;
        $promocao->titulo = $request->titulo;
        $promocao->slug = Str::slug($request->titulo);
        $promocao->status = $status;
        $promocao->inicio = $request->inicio;
        $promocao->fim = $request->fim;
        $promocao->save();

        toastr()->success('Cadastrado com sucesso!');
        return redirect()->route('promocao.index');
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
        $promocao = Promocao::findOrFail($id);
        return view('admin.promocao.edit', compact('promocao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'imagem' => ['nullable', 'image', 'max:2048'],
            'titulo' => ['string', 'max:200', 'unique:promocaos,titulo,'.$id],
            'status' => ['required'],
            'inicio' => ['required', 'date'],
            'fim' => ['required', 'date', 'after:inicio'],
        ]);

        $promocao = Promocao::findOrFail($id);

        if ($request->hasFile('imagem')) {
            $imagePath = $this->updateImage($request, 'imagem', 'uploads', $promocao->imagem);
            $promocao->imagem = $imagePath;
        }
        $promocao->titulo = $request->titulo;
        $promocao->slug = Str::slug($request->titulo);
        $promocao->status = $request->status;
        $promocao->inicio = $request->inicio;
        $promocao->fim = $request->fim;
        $promocao->save();

        toastr('Atualizado com sucesso!', 'success');
        return redirect()->route('promocao.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promocao = Promocao::findOrFail($id);
        $this->deleteImage ($promocao->imagem);
        $promocao->delete();

        return response(['status' => 'success', 'message' => 'Excluído com sucesso!']);
    }

    public function proMudaStatus(Request $request)
    {
        $promocao = Promocao::findOrFail($request->id);
        $promocao->status = $request->status == 'true' ? 1 : 0;
        $promocao->save();

        return response(['message' => 'Status atualizado com sucesso!']);
    }
}
