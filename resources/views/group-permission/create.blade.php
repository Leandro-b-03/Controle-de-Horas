@extends('app')

@section('title')
    SVLabs | Grupo de Permissões
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
    <!-- bootstrap-switch -->
    {!! Html::style("library/adminLTE/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css") !!}
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
      <div id="messages">
        @if (Session::get('return'))
        <div class="alert alert-{!! Session::get('return')['class'] !!} alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4>    <i class="icon fa fa-{!! Session::get('return')['faicon'] !!}"></i> {!! Session::get('return')['status'] !!}!</h4>
          {!! Session::get('return')['message'] !!}
        </div>
        @endif
      </div>
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">{!! Lang::get('general.create'); !!}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            @if (Request::is('group-permissions/create'))
            {!! Form::open(array('route' => 'group-permissions.store')) !!}
            @else
            {!! Form::open(array('route' => [ 'group-permissions.update', $data['group']->id ], 'method' => 'PUT')) !!}
            @endif
              <div class="box-body">
                <div class="form-group col-xs-8">
                  <label for="name">{!! Lang::get('general.name'); !!}</label>
                  <input type="text" class="form-control" name="name" id="name"  value="{!! (isset($data['group']) ? $data['group']->name : (Request::old('name') ? Request::old('name') : '')) !!}" placeholder="{!! Lang::get('group-permissions.ph-name') !!}" required>
                </div>
                <div class="form-group col-xs-8">
                  <label for="display_name">{!! Lang::get('group-permissions.label-display_name') !!}</label>
                  <input type="text" class="form-control" name="display_name" id="display_name"  value="{!! (isset($data['group']) ? $data['group']->display_name : (Request::old('display_name') ? Request::old('display_name') : '')) !!}" placeholder="{!! Lang::get('group-permissions.ph-display_name') !!}" required>
                </div>
                <div class="form-group col-xs-12">
                  <label for="description">{!! Lang::get('group-permissions.label-description') !!}</label>
                  <textarea class="form-control" name="description" id="description" placeholder="{!! Lang::get('group-permissions.ph-description') !!}" required>{!! (isset($data['group']) ? $data['group']->description : (Request::old('description') ? Request::old('description') : '')) !!}</textarea>
                </div>
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="col-xs-12" id="user-permissions">
                  <table style="width:500px" class="table table-bordered table-striped permission">
                    <thead>
                      <tr>
                        <th>Páginas</th>
                        <th>Visualizar</th>
                        <th>{!! Lang::get('general.criar'); !!}</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $permissions = Request::old('permission') ?>
                      @foreach ($controllers as $controller)
                      <tr>
                        <td> {!! Lang::get('general.' . $controller) !!}</td>
                        <td><div class="btn-group btn-toggle">
                            <input type="checkbox" class="permission-check" name="permission[{!! $controller !!}][index]" {!! (isset($data['group']) ? $data['group']->has($controller . '@index') : (isset($permissions[$controller]['index']) ? 'checked' : '')) !!}>
                          </div></td>
                        <td><div class="btn-group btn-toggle">
                            <input type="checkbox" class="permission-check" name="permission[{!! $controller !!}][create]" {!! (isset($data['group']) ? $data['group']->has($controller . '@create') : (isset($permissions[$controller]['create']) ? 'checked' : '')) !!}>
                          </div></td>
                        <td><div class="btn-group btn-toggle">
                            <input type="checkbox" class="permission-check" name="permission[{!! $controller !!}][edit]" {!! (isset($data['group']) ? $data['group']->has($controller . '@edit') : (isset($permissions[$controller]['edit']) ? 'checked' : ''))!!}>
                          </div></td>
                        <td><div class="btn-group btn-toggle">
                            <input type="checkbox" class="permission-check" name="permission[{!! $controller !!}][delete]" {!! (isset($data['group']) ? $data['group']->has($controller . '@delete') : (isset($permissions[$controller]['delete']) ? 'checked' : '')) !!}>
                          </div></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{!! URL::to('group-permissions') !!}" class="btn btn-danger">Voltar</a>
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
    <!-- bootstrap-switch -->
    {!! Html::script("library/adminLTE/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js") !!}
@endsection