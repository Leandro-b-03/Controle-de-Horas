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
                <div class="form-group col-xs-2">
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
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.save') !!}</button>
                <a href="{!! URL::to('import') !!}" class="btn btn-danger">{!! Lang::get('general.back') !!}</a>
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
    <!-- jQuery-Autocomplete -->
    {!! Html::script("library/adminLTE/plugins/jQuery-Autocomplete/dist/jquery.autocomplete.js") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::script("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/jquery.form-validator.min.js") !!}
@endsection