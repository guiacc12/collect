<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoriaDataTable;
use App\Models\Categoria;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\UploadImageTrait;

class CategoriaController extends Controller
{
    use UploadImageTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(CategoriaDataTable $dataTable)
    {
        return $dataTable->render('admin.categoria.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'foto' => ['required', 'image', 'max:2048'],
            'nome' => ['required', 'max:200', 'unique:categorias,nome,'],
            'status' => ['required'],
        ]);

        $categoria = new Categoria();

        $imagePath = $this->uploadImage($request, 'foto', 'uploads');

        $categoria->foto = $imagePath;
        $categoria->nome = $request->nome;
        $categoria->slug = Str::slug($request->nome);
        $categoria->status = $request->status;
        $categoria->save();

        toastr('Cadastrado com sucesso!', 'success');
        return redirect()->route('categoria.index');
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
        $categoria = Categoria::findOrFail($id);
        return view('admin.categoria.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'foto' => ['nullable', 'image', 'max:2048'],
            'nome' => ['required', 'max:200', 'unique:categorias,nome,'.$id],
            'status' => ['required'],
        ]);

        $categoria = Categoria::findOrFail($id);

        if ($request->hasFile('foto')) {
            $imagePath = $this->uploadImage($request, 'foto', 'uploads');
            $categoria->foto = $imagePath;
        }
        $categoria->nome = $request->nome;
        $categoria->slug = Str::slug($request->nome);
        $categoria->status = $request->status;
        $categoria->save();

        toastr('Atualizado com sucesso!', 'success');
        return redirect()->route('categoria.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::findOrFail($id);
        $this->deleteImage ($categoria->foto);
        $categoria->delete();

        return response(['status' => 'success', 'message' => 'Excluído com sucesso!']);

    }

    public function cMudaStatus(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->status = $request->status == 'true' ? 1 : 0;
        $categoria->save();

        return response(['message' => 'Status atualizado com sucesso!']);
    }
}
