<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //VIZUALIZAR PERFIL
    public function index(){
        return view('admin/profile/index');
    }

    //ATUALIZAR PERFIL
    public function update(Request $request){
       //dd($request->all());
      $request->validate([
       'name' => ['required', 'max:100'],
       'email' => ['required', 'email', 'unique:users,email,' . Auth::user()->id],
       ]);

      $user = Auth::user();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->save();

      flash()->success('Dados atualizados com sucesso!');
      return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password)
        ]);

        flash()->success('Senha alterada com sucesso!');
        return redirect()->back();

    }
}
