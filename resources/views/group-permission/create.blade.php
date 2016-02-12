@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.group-permissions')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
    <!-- bootstrap-switch -->
    {!! Html::style("library/adminLTE/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::style("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/theme-default.min.css") !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.group-permissions') !!}
            @if (Request::is('group-permissions/create'))
            <small>{!! Lang::get('group-permissions.create') !!}</small>
            @else
            <small>{!! Lang::get('group-permissions.edit') !!}</small>
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
        <div class="col-md-10">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header">
              @if (Request::is('group-permissions/create'))
              <h3 class="box-title">{!! Lang::get('general.create'); !!}</h3>
              @else
              <h3 class="box-title">{!! Lang::get('general.edit'); !!}</h3>
              @endif
            </div><!-- /.box-header -->
            <!-- form start -->
            @if (Request::is('group-permissions/create'))
            {!! Form::open(array('route' => 'group-permissions.store')) !!}
            @else
            {!! Form::open(array('route' => [ 'group-permissions.update', $data['role']->id ], 'method' => 'PUT')) !!}
            @endif
              <div class="box-body">
                <div class="form-group col-xs-8">
                  <label for="name">{!! Lang::get('general.name'); !!}</label>
                  <input type="text" class="form-control" name="name" id="name"  value="{!! (isset($data['role']) ? $data['role']->name : (Request::old('name') ? Request::old('name') : '')) !!}" placeholder="{!! Lang::get('group-permissions.ph-name') !!}" data-validation="alphanumeric length" data-validation-length="3-80" data-validation-allowing="-_" data-validation-error-msg="{!! Lang::get('group-permissions.error-name') !!}">
                </div>
                <div class="form-group col-xs-8">
                  <label for="display_name">{!! Lang::get('group-permissions.label-display_name') !!}</label>
                  <input type="text" class="form-control" name="display_name" id="display_name"  value="{!! (isset($data['role']) ? $data['role']->display_name : (Request::old('display_name') ? Request::old('display_name') : '')) !!}" placeholder="{!! Lang::get('group-permissions.ph-display_name') !!}" data-validation="length" data-validation-length="3-80" data-validation-error-msg="{!! Lang::get('group-permissions.error-display_name') !!}">
                </div>
                <div class="form-group col-xs-12">
                  <label for="description">{!! Lang::get('group-permissions.label-description') . ' (<span id="maxlength">255</span>) ' . Lang::get('group-permissions.char_left') !!}</label>
                  <textarea class="form-control" name="description" id="description" placeholder="{!! Lang::get('group-permissions.ph-description') !!}" data-validation="length" data-validation-length="10-255" data-validation-error-msg="{!! Lang::get('group-permissions.error-description') !!}">{!! (isset($data['role']) ? $data['role']->description : (Request::old('description') ? Request::old('description') : '')) !!}</textarea>
                </div>
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="col-xs-12" id="user-permissions">
                  <table style="width:500px" class="table table-bordered table-striped permission">
                    <thead>
                      <tr>
                        <th>{!! Lang::get('general.page'); !!}</th>
                        <th>{!! Lang::get('general.view'); !!}</th>
                        <th>{!! Lang::get('general.create'); !!}</th>
                        <th>{!! Lang::get('general.edit'); !!}</th>
                        <th>{!! Lang::get('general.delete'); !!}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $permissions = Request::old('permission') ?>
                      @foreach ($controllers as $controller)
                      <tr>
                        <td> {!! Lang::get('general.' . $controller) !!}</td>
                        <td><div class="btn-group btn-toggle">
                            <input type="checkbox" class="permission-check" name="permission[{!! $controller !!}][index]" {!! (isset($data['role']) ? ($data['role']->perms()->findName($controller . '@index')->get()->count() != 0 ? 'checked' : '') : (isset($permissions[$controller]['index']) ? 'checked' : '')) !!}>
                          </div></td>
                        <td><div class="btn-group btn-toggle">
                            <input type="checkbox" class="permission-check" name="permission[{!! $controller !!}][create]" {!! (isset($data['role']) ? ($data['role']->perms()->findName($controller . '@create')->get()->count() != 0 ? 'checked' : '') : (isset($permissions[$controller]['create']) ? 'checked' : '')) !!}>
                          </div></td>
                        <td><div class="btn-group btn-toggle">
                            <input type="checkbox" class="permission-check" name="permission[{!! $controller !!}][edit]" {!! (isset($data['role']) ? ($data['role']->perms()->findName($controller . '@edit')->get()->count() != 0 ? 'checked' : '') : (isset($permissions[$controller]['edit']) ? 'checked' : ''))!!}>
                          </div></td>
                        <td><div class="btn-group btn-toggle">
                            <input type="checkbox" class="permission-check" name="permission[{!! $controller !!}][delete]" {!! (isset($data['role']) ? ($data['role']->perms()->findName($controller . '@delete')->get()->count() != 0 ? 'checked' : '') : (isset($permissions[$controller]['delete']) ? 'checked' : '')) !!}>
                          </div></td>
                      </tr>
                      @endforeach
                    </tbody>
                    <thead>
                      <tr>
                        <th>{!! Lang::get('general.page') !!}</th>
                        <th colspan="4">{!! Lang::get('group-permissions.special') !!}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td> {!! Lang::get('general.TimesheetController') !!}</td>
                        <th colspan="2">{!! Lang::get('group-permissions.overtime_manager') !!}</th>
                        <td colspan="2"><div class="btn-group btn-toggle">
                            <input type="checkbox" class="permission-check" name="permission[TimesheetController][natura-special]" {!! (isset($data['role']) ? ($data['role']->perms()->findName('TimesheetController@natura-special')->get()->count() != 0 ? 'checked' : '') : (isset($permissions['TimesheetController']['natura-special']) ? 'checked' : '')) !!}>
                          </div></td>
                      </tr>
                    </tbody>
                    {{-- <tfooter>
                      <tr>
                      <td colspan="5"><a id="select-all" class="btn btn-primary">{!! Lang::get('general.select-all') !!}</a> <a class="btn btn-primary">{!! Lang::get('general.deselect-all') !!}</a></td>
                      </tr>
                    </tfooter> --}}
                  </table>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.save'); !!}</button>
                <a href="{!! URL::to('group-permissions') !!}" class="btn btn-danger">{!! Lang::get('general.back'); !!}</a>
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
    <!-- jQuery-Form-Validator -->
    {!! Html::script("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/jquery.form-validator.min.js") !!}

    <script>
      $.validate();
      
      $('#description').restrictLength($('#maxlength'));
      
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