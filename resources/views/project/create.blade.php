@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.projects')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
    <!-- Datepicker -->
    {!! Html::style("library/adminLTE/plugins/datepicker/datepicker3.css") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::style("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/theme-default.min.css") !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.projects') !!}
            @if (Request::is('projects/create'))
            <small>{!! Lang::get('projects.create') !!}</small>
            @else
            <small>{!! Lang::get('projects.edit') !!}</small>
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
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header">
              @if (Request::is('projects/create'))
              <h3 class="box-title">{!! Lang::get('general.create'); !!}</h3>
              @else
              <h3 class="box-title">{!! Lang::get('general.edit'); !!}</h3>
              @endif
            </div><!-- /.box-header -->
            <!-- form start -->
            @if (Request::is('projects/create'))
            {!! Form::open(array('route' => 'projects.store', 'name' => 'project-form')) !!}
            @else
            {!! Form::open(array('route' => [ 'projects.update', $data['project']->id ], 'method' => 'PUT', 'name' => 'project-form', 'id' => 'edit')) !!}
            @endif
              <div class="box-body">
                <div class="form-group col-xs-4">
                  <label for="name">{!! Lang::get('projects.label-name') !!}</label>
                  <input type="text" class="form-control" name="name" id="name"  value="{!! (isset($data['project']) ? $data['project']->name : (Request::old('name') ? Request::old('name') : '')) !!}" placeholder="{!! Lang::get('projects.ph-name') !!}" data-validation="length" data-validation-length="3-25" data-validation-error-msg="{!! Lang::get('projects.error-name') !!}" required>
                </div>
                <div class="form-group col-xs-4">
                  <label for="user_id">{!! Lang::get('projects.label-manager') !!}</label>
                  <select name="user_id" id="user_id" class="form-control" data-validation="required" data-validation-error-msg="{!! Lang::get('projects.error-manager') !!}" required>
                    <option value="">{!! Lang::get('general.select') !!}</option>
                    @foreach ($data['users'] as $user)
                    <option value="{!! $user->id !!}" {!! (isset($data['project']) ? ($project->user()->id == $user->id ? 'selected="selected"' : "") : "") !!}>{!! $user->username !!}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-xs-4">
                  <label for="client_id">{!! Lang::get('general.clients') !!}</label>
                  <select name="client_id" id="client_id" class="form-control" data-validation="required" data-validation-error-msg="{!! Lang::get('projects.error-clients') !!}" required>
                    <option value="">{!! Lang::get('general.select') !!}</option>
                    @foreach ($data['clients'] as $client)
                    <option value="{!! $client->id !!}" {!! (isset($data['project']) ? ($project->client()->id == $client->id ? 'selected="selected"' : "") : "") !!}>{!! $client->name !!}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="form-group col-xs-5">
                  <label for="description">{!! Lang::get('projects.label-description') . ' (<span id="description-maxlength">100</span>) ' . Lang::get('projects.char_left') !!}</label>
                  <textarea class="form-control" name="description" id="description" placeholder="{!! Lang::get('projects.ph-description') !!}" data-validation="length" data-validation-length="10-100" data-validation-error-msg="{!! Lang::get('projects.error-description') !!}">{!! (isset($data['project']) ? $data['project']->description : (Request::old('description') ? Request::old('description') : '')) !!}</textarea>
                </div>
                <div class="form-group col-xs-7">
                  <label for="long_description">{!! Lang::get('projects.label-long_description') . ' (<span id="long_description-maxlength">255</span>) ' . Lang::get('projects.char_left') !!}</label>
                  <textarea class="form-control" name="long_description" id="long_description" placeholder="{!! Lang::get('projects.ph-long_description') !!}" data-validation="length" data-validation-length="10-255" data-validation-error-msg="{!! Lang::get('projects.error-long_description') !!}">{!! (isset($data['project']) ? $data['project']->long_description : (Request::old('long_description') ? Request::old('long_description') : '')) !!}</textarea>
                </div>
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="col-xs-10" id="project-time">
                  <table class="table table-bordered table-striped project-time">
                    <thead>
                      <tr>
                        <th>{!! Lang::get('projects.cycle'); !!}</th>
                        <th>{!! Lang::get('projects.time'); !!}</th>
                        <th>{!! Lang::get('projects.budget'); !!}</th>
                        <th>{!! Lang::get('general.action'); !!}</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input type="hidden" name="project_time[{!! (isset($data['project']) ? $data['project']->projects_time()->first()->id : (Request::old('project_time[project_time_id][]') ? Request::old('project_time[project_time_id][]') : '1')) !!}][]" id="project_time_id" value="{!! (isset($data['project']) ? $data['project']->projects_time()->first()->id : (Request::old('project_time[project_time_id][]') ? Request::old('project_time[project_time_id][]') : '1')) !!}"><input type="text" class="form-control" name="project_time[{!! (isset($data['project']) ? $data['project']->projects_time()->first()->id : (Request::old('project_time[project_time_id][]') ? Request::old('project_time[project_time_id][]') : '1')) !!}][cycle][]" class="cycle" placeholder="{!! Lang::get('projects.ph-cycle') !!}" value="{!! (isset($data['project']) ? $data['project']->cycle : (Request::old('cycle') ? Request::old('cycle') : '')) !!}"></td>
                        <td><input type="text" class="form-control" name="project_time[{!! (isset($data['project']) ? $data['project']->projects_time()->first()->id : (Request::old('project_time[project_time_id][]') ? Request::old('project_time[project_time_id][]') : '1')) !!}][schedule_time][]" class="schedule_time" placeholder="{!! Lang::get('projects.ph-schedule_time') !!}" value="{!! (isset($data['project']) ? $data['project']->schedule_time : (Request::old('schedule_time') ? Request::old('schedule_time') : '')) !!}"></td>
                        <td><input type="text" class="form-control" name="project_time[{!! (isset($data['project']) ? $data['project']->projects_time()->first()->id : (Request::old('project_time[project_time_id][]') ? Request::old('project_time[project_time_id][]') : '1')) !!}][budget][]" class="budget" placeholder="{!! Lang::get('projects.ph-budget') !!}" value="{!! (isset($data['project']) ? $data['project']->budget : (Request::old('budget') ? Request::old('budget') : '')) !!}"></td>
                        <td></td>
                        {{-- @foreach ($controllers as $controller) --}}
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr><td colspan="4"><a id="add-row" class="btn btn-primary"><i class="fa fa-plus"></i> {!! Lang::get('projects.add-row') !!}</a></td></tr>
                    </tfoot>
                  </table>
                </div>
                <div class="form-group col-xs-2">
                  <label for="budget">{!! Lang::get('projects.label-budget') !!}</label>
                  <input type="text" class="form-control" name="budget" id="budget" placeholder="{!! Lang::get('projects.ph-budget') !!}" value="{!! (isset($data['project']) ? $data['project']->budget : (Request::old('budget') ? Request::old('budget') : '')) !!}" disabled="disabled">
                </div>
                <div class="form-group col-xs-2">
                  <label for="schedule_time">{!! Lang::get('projects.label-schedule_time') !!}</label>
                  <input type="text" class="form-control" name="schedule_time" id="schedule_time" placeholder="{!! Lang::get('projects.ph-schedule_time') !!}" value="{!! (isset($data['project']) ? $data['project']->schedule_time : (Request::old('schedule_time') ? Request::old('schedule_time') : '')) !!}" disabled="disabled">
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.save') !!}</button>
                <a href="{!! URL::to('projects') !!}" class="btn btn-danger">{!! Lang::get('general.back') !!}</a>
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
    <!-- jQuery-Form-Validator -->
    {!! Html::script("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/jquery.form-validator.min.js") !!}

    <script>
      $.validate();
      
      $('#description').restrictLength($('#description-maxlength'));
      
      $('#long_description').restrictLength($('#long_description-maxlength'));

      $('form').submit(function(e) {
        if ($(this).find('.has-error').length > 0) {
          e.preventDefault();
          var data = {class:'danger', faicon:'ban', status:"{!! Lang::get('general.failed') !!}", message:"{!! html_entity_decode(Lang::get('general.failed-fields')) !!}"};
            $('#messages').html(throwMessage(data));
        }else {
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

      $('#add-row').click(function() {
        var row = parseInt($('.project-time').find('tbody tr td input[type=hidden]:last').val()) + 1;

        var html = '';
        
        html += '<tr>';
        html += '<td><input type="hidden" name="project_time[' + row + '][]" id="project_time_id" value="' + row + '"><input type="text" class="form-control" name="project_time[' + row + '][cycle][]" class="cycle" placeholder="{!! Lang::get('projects.ph-cycle') !!}" value=""></td>';
        html += '<td><input type="text" class="form-control" name="project_time[' + row + '][schedule_time][]" class="schedule_time" placeholder="{!! Lang::get('projects.ph-time') !!}" value=""></td>';
        html += '<td><input type="text" class="form-control" name="project_time[' + row + '][budget][]" class="budget" placeholder="{!! Lang::get('projects.ph-budget') !!}" value=""></td>';
        html += '<td><a class="btn btn-danger remove"><i class="fa fa-remove"></i> {!! Lang::get('general.remove') !!}</a></td>';
        html += '</tr>';
        $('.project-time').find('tbody').append(html);
      })
    </script>
@endsection