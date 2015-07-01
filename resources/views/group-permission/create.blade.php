@extends('app')

@section('title')
    SVLabs | Grupo de Permissões
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
@stop

@section('content')
        <h1>
            Grupo de Permissões
            <small>criar grupo</small>
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
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Criar</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            @if (Request::is('group-permissions/create'))
            {!! Form::open(array('route' => 'group-permissions.store')) !!}
            @else
            {!! Form::open(array('route' => [ 'group-permissions.update', $data['group']->id ], 'method' => 'PUT')) !!}
            @endif
              <div class="box-body">
                <div class="form-group col-xs-8">
                  <label for="name">Nome</label>
                  <input type="text" class="form-control" name="name" id="name"  value="{!! (isset($data['group']) ? $data['group']->name : "") !!}" placeholder="Nome do grupo" required>
                </div>
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="form-group col-xs-1">
                  <label>Ação</label>
                  <label>Visualizar</label>
                  <label>Criar</label>
                  <label>Editar</label>
                  <label>Excluir</label>
                </div>
                <div class="roles">
                  @foreach ($controllers as $controller)
                  <div class="form-group col-xs-1 controllers-role">
                    <label for="name" class="text-angle">{!! $controller !!}</label>
                    @for ($i = 0; $i < 4; $i++)
                    <br />
                    <input type="checkbox" />
                    @endfor
                  </div>
                  @endforeach
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{!! URL::to('groups') !!}" class="btn btn-danger">Voltar</a>
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
@endsection