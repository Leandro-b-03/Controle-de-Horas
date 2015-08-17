@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.tasks')]) !!}
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
            {!! Lang::get('general.tasks') !!}
            @if (Request::is('tasks/create'))
            <small>{!! Lang::get('tasks.create') !!}</small>
            @else
            <small>{!! Lang::get('tasks.edit') !!}</small>
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
            @if (Request::is('tasks/create'))
            {!! Form::open(array('route' => 'tasks.store')) !!}
            @else
            {!! Form::open(array('route' => [ 'tasks.update', $data['task']->id ], 'method' => 'PUT')) !!}
            @endif
              <div class="box-body">
                <div class="form-group col-xs-4">
                  <label for="name">{!! Lang::get('tasks.label-name') !!}</label>
                  <input type="text" class="form-control" name="name" id="name"  value="{!! (isset($data['task']) ? $data['task']->name : (Request::old('name') ? Request::old('name') : '')) !!}" placeholder="{!! Lang::get('tasks.ph-name') !!}" data-validation="length" data-validation-length="3-40" data-validation-error-msg="{!! Lang::get('tasks.error-name') !!}" required>
                </div>
                <div class="form-group col-xs-4">
                  <label for="project_id">{!! Lang::get('general.projects') !!}</label>
                  <select name="project_id" id="project_id" class="form-control" data-validation="required" data-validation-error-msg="{!! Lang::get('projects.error-projects') !!}" required>
                    <option value="">{!! Lang::get('general.select') !!}</option>
                    @foreach ($data['projects'] as $project)
                    <option value="{!! $project->id !!}" {!! (isset($data['project']) ? ($data['project']->project()->getResults()->id == $project->id ? 'selected="selected"' : "") : "") !!}>{!! $project->name !!}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-xs-4">
                  <label for="project_time_id">{!! Lang::get('projects.cycle') !!}</label>
                  <select name="project_time_id" id="project_time_id" class="form-control" data-validation="required" data-validation-error-msg="{!! Lang::get('projects.error-projects') !!}" required disabled="disabled">
                    <option value="">{!! Lang::get('general.select') !!}</option>
                    @if (Request::is('group-permissions/edit'))
                    @foreach ($data['projects_times'] as $project_time)
                    <option value="{!! $project_time->id !!}" {!! (isset($data['project_time']) ? ($data['project_time']->project()->getResults()->id == $project->id ? 'selected="selected"' : "") : "") !!}>{!! $project->name !!}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="form-group col-xs-5">
                  <label for="teams">{!! Lang::get('general.teams') !!}</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="teams-autocomplete" placeholder="{!! Lang::get('tasks.search-team-name') !!}" />
                    <span class="input-group-btn">
                      <a id="search-team" class="btn btn-default"><i class="fa fa-search-plus"></i> {!! Lang::get('general.btn-search') !!}</a>
                    </span>
                  </div>
                </div>
                <div id="teams" class="form-group col-xs-12">
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.save') !!}</button>
                <a href="{!! URL::to('tasks') !!}" class="btn btn-danger">{!! Lang::get('general.back') !!}</a>
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
      $('#project_id').on('change', function() {
        $.ajax({
          url: '/general/getProjectTimes',
          data: {id: $(this).val()},
          type: "GET",
          success: function(data) {
            var project_times = JSON.parse(data);

            console.log(project_times);

            if (project_times.length > 0) {
              $('#project_time_id').prop( "disabled", false );
              $('#project_time_id').find('option[value!=""]').remove();

              var options = [];

              $.each(project_times, function(i, project_time) {

                options.push('<option value="' + project_time.id + '">' + project_time.cycle + '</select>');
                return;
              });

              $('#project_time_id').append(options);
            } else {
              $('#project_time_id').prop( "disabled", true ).val($("#target option:first").val());
              $('#project_time_id').find('option[value!=""]').remove();
            }
          }
        });
      });

      $('#teams-autocomplete').autocomplete({
          serviceUrl: '/autocomplete/team',
          onSelect: function (suggestion) {
            if($('#teams :input[value="' + suggestion.data.id + '"]').length === 0) {
              var html = '';

              html += '<span class="label label-success" style="background-color: ' + suggestion.data.color + ' !important">' + suggestion.data.name + '</span>&nbsp;';
              html += '<input type="hidden" name="teams[]" value="' + suggestion.data.id + '" />'

              $('#teams').append(html);
            }
          }
      });

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