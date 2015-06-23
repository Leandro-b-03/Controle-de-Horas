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
            {!! Form::open(array('route' => 'clients.store')) !!}
              <div class="box-body">
                <div class="form-group col-xs-12">
                  <label for="name">Nome</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Nome do cliente" required>
                </div>
                <div class="form-group col-xs-12">
                  <label for="responsible">Responsável</label>
                  <input type="text" class="form-control" name="responsible" id="responsible" placeholder="Responsável pelo cliente" required>
                </div>
                <div class="form-group col-xs-8">
                  <label for="email">E-mail</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="E-mail do responsável" required>
                </div>
                <div class="form-group col-xs-4">
                  <label for="phone">Telefone</label>
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="Telefone do responsável" required>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
              </div>
            {!! Form::close() !!}
          </div><!-- /.box -->
        </div>
      </div>
    </section>
@endsection

@section('scripts')
@endsection