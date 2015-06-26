@extends('app')

@section('title')
    SVLabs | Clientes
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
    <!-- Datepicker -->
    {!! Html::style("library/adminLTE/plugins/datepicker/datepicker3.css") !!}
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
            {!! Form::open(array('route' => 'users.store', 'name' => 'user-form')) !!}
            @else
            {!! Form::open(array('route' => [ 'users.update', $data['user']->id ], 'method' => 'PUT', 'name' => 'user-form')) !!}
            @endif
              <div class="box-body">
                <div class="form-group col-xs-12">
                  <label for="username">Nome de usuário</label>
                  <input type="text" class="form-control" name="username" id="username"  value="{!! (isset($data['user']) ? $data['user']->username : "") !!}" placeholder="Nome do Colaborador" required>
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
                  <input type="rg" class="form-control input-mask" data-mask="99.999.999-*" name="rg" id="rg"  value="{!! (isset($data['user']) ? $data['user']->rg : "") !!}" placeholder="RG do colaborador" required>
                </div>
                <div class="form-group col-xs-6">
                  <label for="cpf">CPF</label>
                  <input type="text" class="form-control input-mask" data-mask="999.999.999-99" name="cpf" id="cpf"  value="{!! (isset($data['user']) ? $data['user']->cpf : "") !!}" placeholder="CPF do colaborador" required>
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
                  <label for="birthday">Data de nascimento</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control date input-mask" data-mask="99/99/9999" name="birthday" id="birthday"  value="{!! (isset($data['user']) ? date('d/m/Y', strtotime($data['user']->birthday)) : "") !!}" placeholder="Data de nascimento do colaborador" required>
                  </div>
                </div>
                <div class="form-group col-xs-6">
                  <hr />
                </div>
                <div class="form-group col-xs-6">
                  <label for="password">Senha</label>
                  <input type="password" class="form-control" name="password" id="password"  value="" placeholder="Senha" required>
                </div>
                <div class="form-group col-xs-6">
                  <label for="confirm_password">Confirmar Senha</label>
                  <input type="password" class="form-control" name="confirm_password" id="confirm_password"  value="" placeholder="Confirmar Senha" required>
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
    <!-- Jasny-bootstrap -->
    {!! Html::script("library/adminLTE/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js") !!}
    <!-- Datepicker -->
    {!! Html::script("library/adminLTE/plugins/datepicker/bootstrap-datepicker.js") !!}
    <!-- Validete.js -->
    {!! Html::script("library/adminLTE/plugins/validate/validate.min.js") !!}

    <script>
      var validator = new FormValidator('user-form', [{
          name: 'req',
          display: 'required',
          rules: 'required'
      }, {
          name: 'alphanumeric',
          rules: 'alpha_numeric'
      }, {
          name: 'password',
          rules: 'required'
      }, {
          name: 'confirm_password',
          display: 'password confirmation',
          rules: 'required|matches[password]'
      }, {
          name: 'email',
          rules: 'valid_email',
          depends: function() {
              return Math.random() > .5;
          }
      }, {
          name: 'minlength',
          display: 'min length',
          rules: 'min_length[8]'
      }], function(errors, event) {
          if (errors.length > 0) {
              // Show the errors
          }
      });
    </script>
@endsection