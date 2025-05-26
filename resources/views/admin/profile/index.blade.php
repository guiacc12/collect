@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Meus Dados</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></div>
            <div class="breadcrumb-item">Perfil</div>
        </div>
    </div>
    <div class="section-body">


        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-7">

                <div class="card" style="background: #e5dad4">
                    <form action="{{ route('admin.profile.update') }}" method="post" class="needs-validation" novalidate="">
                        @csrf
                        <div class="card-header">
                            <h4 style="color: #203a4e">Atualizar Perfil</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label style="color: #203a4e">Nome</label>
                                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required="">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label style="color: #203a4e">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required="">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary" >Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-7">
                <div class="card" style="background: #e5dad4">
                    <form action="{{ route('admin.profile.password') }}" method="post" class="needs-validation" novalidate="">
                        @csrf
                        <div class="card-header">
                            <h4 style="color: #203a4e">Atualizar Senha</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label style="color: #203a4e">Senha Atual</label>
                                    <input type="password" class="form-control" name="current_password" placeholder="Digite sua senha atual">
                                </div>

                                <div class="form-group col-12">
                                    <label style="color: #203a4e">Nova Senha</label>
                                    <input type="password" class="form-control" name="password" placeholder="Digite uma nova senha de no minimo 8 dígitos" >
                                </div>

                                <div class="form-group col-12">
                                    <label style="color: #203a4e">Confirme a Senha</label>
                                    <input type="password" class="form-control" name="passwaord_confirmation" placeholder="Confirme sua senha">
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary" >Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
