@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.import')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
    <!-- jQuery-Autocomplete -->
    {!! Html::style("library/adminLTE/plugins/jQuery-Autocomplete/content/styles-custom.css") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::style("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/theme-default.min.css") !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.import') !!}
            <small>{!! Lang::get('import.file') !!}</small>
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
        <div class="col-md-10">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">{!! Lang::get('general.import'); !!}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(array('route' => 'import.store')) !!}
              <div class="box-body">
                <div class="form-group col-xs-3">
                  <label for="type">{!! Lang::get('import.label-type') !!}</label>
                  <div class="radio">
                    <label><input name="type" id="type" value="WP" type="radio" data-validation-qty="min1" data-validation-error-msg="{!! Lang::get('import.error-type_female') !!}" {!! (isset($data['user']) ? ($data['user']->type == 'F') ? 'checked="checked"' : ((Request::old('type')) ? ((Request::old('type') == 'F') ? 'checked="checked"' : '') : '') : '' ) !!} required> {!! Lang::get('import.ph-type_wp') !!}</label>
                  <div class="radio">
                  </div>
                    <label><input name="type" id="type" value="TS" type="radio" {!! (isset($data['user']) ? ($data['user']->type == 'M') ? 'checked="checked"' : ((Request::old('type')) ? ((Request::old('type') == 'M') ? 'checked="checked"' : '') : '') : '' ) !!}> {!! Lang::get('import.ph-type_ts') !!}</label>
                  </div>
                </div>
                <div class="form-group col-xs-4">
                  <label for="name">{!! Lang::get('import.label-name') !!}</label>
                  <div class="input-group">
                    <input class="form-control" id="file-name" type="text" disabled="disabled">
                    <span class="input-group-btn">
                      <a href="#filemanager" role="button" class="btn btn-info btn-flat" data-toggle="modal" title="{!! Lang::get('users.a-open_filemanager') !!}"><span class="fa fa-file-excel-o"></span></a>
                    </span>
                  </div>
                  <input type="hidden" id="xlsx" name="xlsx" value="source/">
                  {{-- <input type="file" class="form-control" name="name" id="name"  value="" placeholder="{!! Lang::get('import.ph-name') !!}" data-validation="length" data-validation-length="3-40" data-validation-error-msg="{!! Lang::get('import.error-name') !!}" required> --}}
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.import') !!}</button>
              </div>
            {!! Form::close() !!}
          </div><!-- /.box -->
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">{!! Lang::get('general.import') !!}</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <table id="tasks-table" class="table table-responsive table-hover table-border table-striped table-bordered">
                <thead>
                  <tr>
                    <th>{!! Lang::get('import.title-name') !!}</th>
                    <th>{!! Lang::get('import.title-user') !!}</th>
                    <th>{!! Lang::get('import.title-success') !!}</th>
                    <th>{!! Lang::get('import.title-error') !!}</th>
                    <th>{!! Lang::get('import.title-created_at') !!}</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($data['imports'])
                  @foreach ($data['imports'] as $import)
                  <tr>
                    <td>{!! $import->file !!}</td>
                    <td>{!! $import->getUser()->getResults()->first_name !!}</td>
                    <td>{!! $import->status ? Lang::get('general.success') : Lang::get('general.failed') !!}</td>
                    <td>{!! $import->error !!}</td>
                    <td>{!! date('d/m/Y', strtotime($import->created_at)) !!}</td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div><!-- /.box-body -->
            <div class="box-footer">
            {!! $data['imports']->render() !!}
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
        </div>
      </div>
    </section>
@endsection

@section('scripts')
    <!-- Jasny-bootstrap -->
    {!! Html::script("library/adminLTE/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js") !!}
    <!-- jQuery-Autocomplete -->
    {!! Html::script("library/adminLTE/plugins/jQuery-Autocomplete/dist/jquery.autocomplete.js") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::script("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/jquery.form-validator.min.js") !!}
@endsection