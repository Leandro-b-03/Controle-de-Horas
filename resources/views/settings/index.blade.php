@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.settings')]) !!}
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
            {!! Lang::get('general.settings') !!}
            @if (Request::is('settings/create'))
            <small>{!! Lang::get('settings.create') !!}</small>
            @else
            <small>{!! Lang::get('settings.edit') !!}</small>
            @endif
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
              <h3 class="box-title">{!! Lang::get('general.edit'); !!}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(array('route' => [ 'settings.update', $data['settings']->id ], 'method' => 'PUT')) !!}
              <div class="box-body">
                <div class="form-group col-xs-6">
                  <label for="title">{!! Lang::get('settings.label-title') !!}</label>
                  <input type="text" class="form-control" name="title" id="title"  value="{!! (isset($data['settings']) ? $data['settings']->title : (Request::old('title') ? Request::old('title') : '')) !!}" placeholder="{!! Lang::get('settings.ph-title') !!}" data-validation="length" data-validation-length="3-40" data-validation-error-msg="{!! Lang::get('settings.error-title') !!}" required>
                </div>
                <div class="form-group col-xs-6">
                  <label for="api_key">{!! Lang::get('settings.label-api_key') !!}</label>
                  <input type="text" class="form-control" name="api_key" id="api_key"  value="{!! (isset($data['settings']) ? $data['settings']->api_key : (Request::old('api_key') ? Request::old('api_key') : '')) !!}" placeholder="{!! Lang::get('settings.ph-api_key') !!}" data-validation="length" data-validation-length="3-40" data-validation-error-msg="{!! Lang::get('settings.error-api_key') !!}" required>
                </div>
                <div class="form-group col-xs-6">
                  <label for="description">{!! Lang::get('settings.label-description') !!}</label>
                  <textarea type="text" class="form-control" name="description" id="description" data-validation="length" data-validation-length="3-40" data-validation-error-msg="{!! Lang::get('settings.error-description') !!}" placeholder="{!! Lang::get('settings.ph-description') !!}" rows="12" required>{!! (isset($data['settings']) ? $data['settings']->description : (Request::old('description') ? Request::old('description') : '')) !!}</textarea>
                </div>
                <div class="form-group col-xs-3">
                  <label for="page_size">{!! Lang::get('settings.label-page_size') !!}</label>
                  <input type="number" class="form-control" name="page_size" id="page_size"  value="{!! (isset($data['settings']) ? $data['settings']->page_size : (Request::old('page_size') ? Request::old('page_size') : '')) !!}" placeholder="{!! Lang::get('settings.ph-page_size') !!}" data-validation="number length" data-validation-length="1-5" data-validation-error-msg="{!! Lang::get('settings.error-page_size') !!}" required>
                </div>
                <div class="form-group col-xs-3">
                  <label for="locktime">{!! Lang::get('settings.label-locktime') !!}</label>
                  <input type="number" class="form-control" name="locktime" id="locktime"  value="{!! (isset($data['settings']) ? $data['settings']->locktime : (Request::old('locktime') ? Request::old('locktime') : '')) !!}" placeholder="{!! Lang::get('settings.ph-locktime') !!}" data-validation="number length" data-validation-length="1-5" data-validation-error-msg="{!! Lang::get('settings.error-locktime') !!}" required>
                </div>
                <div class="form-group col-xs-5">
                  <label for="default_theme">{!! Lang::get('settings.label-default_theme') !!}</label>
                  <select type="text" class="form-control" name="default_theme" id="default_theme"  value="{!! (isset($data['settings']) ? $data['settings']->default_theme : (Request::old('default_theme') ? Request::old('default_theme') : '')) !!}" data-validation-error-msg="{!! Lang::get('settings.error-default_theme') !!}" required>
                    <option value="">{{ Lang::get('general.select') }}</option>
                    <option value="skin-blue">Blue</option>
                    <option value="skin-black">Black</option>
                    <option value="skin-purple">Purple</option>
                    <option value="skin-green">Green</option>
                    <option value="skin-red">Red</option>
                    <option value="skin-yellow">Yellow</option>
                    <option value="skin-blue-light">Blue Light</option>
                    <option value="skin-black-light">Black Light</option>
                    <option value="skin-purple-light">Purple Light</option>
                    <option value="skin-green-light">Green Light</option>
                    <option value="skin-red-light">Red Light</option>
                    <option value="skin-yellow-light">Yellow Light</option>
                  </select>
                </div>
                <div class="form-group col-xs-2">
                  <label for="maintenance">{!! Lang::get('settings.label-maintenance') !!}</label>
                  <input type="checkbox" name="maintenance" id="maintenance" value="{!! (isset($data['settings']) ? $data['settings']->maintenance : (Request::old('maintenance') ? Request::old('maintenance') : '')) !!}" {!! (isset($data['settings']) ? 'checked' : (Request::old('maintenance') ? 'checked' : '')) !!} placeholder="{!! Lang::get('settings.ph-maintenance') !!}" data-validation="number length" data-validation-length="1-5" data-validation-error-msg="{!! Lang::get('settings.error-maintenance') !!}">
                </div>
                <div class="form-group col-xs-4">
                  <label for="maintenance_message">{!! Lang::get('settings.label-maintenance_message') !!}</label>
                  <textarea type="text" class="form-control" name="maintenance_message" id="maintenance_message" data-validation="length" data-validation-length="3-400" data-validation-error-msg="{!! Lang::get('settings.error-maintenance_message') !!}" placeholder="{!! Lang::get('settings.ph-maintenance_message') !!}" rows="4" required>{!! (isset($data['settings']) ? $data['settings']->maintenance_message : (Request::old('maintenance_message') ? Request::old('maintenance_message') : '')) !!}</textarea>
                </div>
                <div class="form-group col-xs-12">
                <hr />
                </div>
                <div class="form-group col-xs-6">
                  <label for="from_address">{!! Lang::get('settings.label-from_address') !!}</label>
                  <input type="email" class="form-control" name="from_address" id="from_address"  value="{!! (isset($data['settings']) ? $data['settings']->from_address : (Request::old('from_address') ? Request::old('from_address') : '')) !!}" placeholder="{!! Lang::get('settings.ph-from_address') !!}" data-validation="length" data-validation-length="3-40" data-validation-error-msg="{!! Lang::get('settings.error-from_address') !!}" required>
                </div>
                <div class="form-group col-xs-6">
                  <label for="from_name">{!! Lang::get('settings.label-from_name') !!}</label>
                  <input type="text" class="form-control" name="from_name" id="from_name"  value="{!! (isset($data['settings']) ? $data['settings']->from_name : (Request::old('from_name') ? Request::old('from_name') : '')) !!}" placeholder="{!! Lang::get('settings.ph-from_name') !!}" data-validation="length" data-validation-length="3-40" data-validation-error-msg="{!! Lang::get('settings.error-from_name') !!}" required>
                </div>
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                </div>
                <div class="form-group col-xs-12">
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.save') !!}</button>
                <a href="{!! URL::to('settings') !!}" class="btn btn-danger">{!! Lang::get('general.back') !!}</a>
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

    <script>
      $.validate();

      $('form').submit(function(e) {
        if ($(this).find('.has-error').length > 0) {
          e.preventDefault();
          var data = {class:'danger', faicon:'ban', status:"{!! Lang::get('general.failed') !!}", message:"{!! html_entity_decode(Lang::get('general.failed-fields')) !!}"};
            $('#messages').html(throwMessage(data));
        } else {
          return;
        }
      });

      function throwMessage(data) {
          html = '<div class="alert alert-' + data.class + ' alert-dismissable">';
          html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
          html += '<h4>    <i class="icon fa fa-' + data.faicon + '"></i> ' + data.status + '</h4>';
          html += data.message;
          html += '</div>';

          return html;
      }
    </script>
@endsection