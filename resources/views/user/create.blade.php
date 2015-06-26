@extends('app')

@section('title')
    SVLabs | Clientes
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
@stop

@section('content')
        <h1>
            Clientes
            <small>criar clientes</small>
        </h1>
        <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
        </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Criar</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            @if (Request::is('users/create'))
            {!! Form::open(array('route' => 'users.store')) !!}
            @else
            {!! Form::open(array('route' => [ 'users.update', $data['user']->id ], 'method' => 'PUT')) !!}
            @endif
              <div class="box-body">
                <div class="form-group col-xs-12">
                  <label for="name">Nome de usuário</label>
                  <input type="text" class="form-control" name="name" id="name"  value="{!! (isset($data['user']) ? $data['user']->name : "") !!}" placeholder="Nome do Colaborador" required>
                </div>
                <div class="form-group col-xs-6">
                  <label for="first_name">Primeiro Nome</label>
                  <input type="first_name" class="form-control" name="first_name" id="first_name"  value="{!! (isset($data['user']) ? $data['user']->first_name : "") !!}" placeholder="Primeiro nome do colaborador" required>
                </div>
                <div class="form-group col-xs-6">
                  <label for="last_name">Ultimo Nome</label>
                  <input type="text" class="form-control" name="last_name" id="last_name"  value="{!! (isset($data['user']) ? $data['user']->last_name : "") !!}" placeholder="Ultimo nome do colaborador" required>
                </div>
                <div class="form-group col-xs-8">
                  <label for="email">E-mail</label>
                  <input type="email" class="form-control" name="email" id="email"  value="{!! (isset($data['user']) ? $data['user']->email : "") !!}" placeholder="E-mail do responsável" required>
                </div>
                <div class="form-group col-xs-4">
                  <label for="phone">Telefone</label>
                  <input type="text" class="form-control" name="phone" id="phone"  value="{!! (isset($data['user']) ? $data['user']->phone : "") !!}" placeholder="Telefone do responsável" required>
                </div>
                <div class="form-group col-xs-6">
                  <label for="rg">RG</label>
                  <input type="rg" class="form-control" name="rg" id="rg"  value="{!! (isset($data['user']) ? $data['user']->rg : "") !!}" placeholder="RG do colaborador" required>
                </div>
                <div class="form-group col-xs-6">
                  <label for="last_name">CPF</label>
                  <input type="text" class="form-control" name="last_name" id="last_name"  value="{!! (isset($data['user']) ? $data['user']->last_name : "") !!}" placeholder="CPF do colaborador" required>
                </div>
                <div class="form-group col-xs-6">
                  <label for="name">Foto</label>
                  <br />
                  <ul class="ch-grid">
                    <li>
                      <div class="ch-item"> 
                        <div class="ch-info">
                          <h3>Trocar foto</h3>
                          <p><a href="#filemanager" role="button" class="" data-toggle="modal">Abrir gerenciador</a></p>
                        </div>
                        <div class="ch-thumb ch-img-1">
                          <img id="image" src="{{ URL::to('/') }}/{{ (isset($data['user']) ? $data['user']->photo : "uploads/img-not-found.jpg") }}">
                        </div>
                      </div>
                    </li>
                  </ul>
                  <input type='hidden' class="form-control" id='photo' name='photo' value='{!! (isset($data['user']) ? $data['user']->photo : "source/img-not-found.jpg") !!}' />
                </div>
                <div class="form-group col-xs-6">
                  <label for="password">Senha</label>
                  <input type="text" class="form-control" name="password" id="password"  value="{!! (isset($data['user']) ? $data['user']->password : "") !!}" placeholder="Senha" required>
                </div>
                <div class="form-group col-xs-6">
                  <label for="confirm_password">Confirmar Senha</label>
                  <input type="text" class="form-control" name="confirm_password" id="confirm_password"  value="{!! (isset($data['user']) ? $data['user']->confirm_password : "") !!}" placeholder="Confirmar Senha" required>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{!! URL::to('users') !!}" class="btn btn-danger">Voltar</a>
              </div>
            {!! Form::close() !!}
          </div><!-- /.box -->
        </div>
      </div>
    </section>
@endsection

@section('scripts')
@endsection