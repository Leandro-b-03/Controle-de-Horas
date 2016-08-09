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
        <div class="col-md-12">
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
                @if (!isset($data['tasks_permissions'][0]))
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> {!! Lang::get('general.alert') !!}!</h4>
                    Você precisa ter ao menos uma ativadade cadastrada!
                  </div>
                @endif
                <div class="col-md-3">
                  <div class="col-md-12">
                    <div id="tasks" class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title">{!! Lang::get('timesheets.tasks') !!}</h3>
                      </div><!-- /.box-header -->
                      <div class="box-body">
                        <ul id="0" class="sortable-list">
                        @if (isset($data['tasks_permissions'][0]))
                        @foreach ($data['tasks_permissions'][0] as $task)
                          <li class="badge bg-green" id="{!! $task->id !!}">{!! $task->subject !!}</li>
                        @endforeach
                        @endif
                          <hr class="clear">
                        </ul>
                      </div><!-- /.box-body -->
                    </div><!-- /.box -->
                  </div>
                </div>
                <div class="col-md-9">
                  @foreach($data['activities'] as $activity)
                  <div class="col-md-6">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title">{!! $activity->name !!}</h3>
                      </div><!-- /.box-header -->
                      <div class="box-body">
                        <ul class="sortable-list" id="{!! $activity->id !!}">
                        @if (isset($data['tasks_permissions'][$activity->id]))
                        @foreach ($data['tasks_permissions'][$activity->id] as $task)
                          <li class="badge bg-green" id="{!! $task->id !!}">{!! $task->subject !!}</li>
                        @endforeach
                        @endif
                          <hr class="clear">
                        </ul>
                      </div><!-- /.box-body -->
                    </div><!-- /.box -->
                  </div>
                  @endforeach
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
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
    <!-- jQueryUI -->
    {!! Html::script("library/adminLTE/plugins/jQueryUI/jquery-ui.min.js") !!}

    <script>
      $('#tasks .box-body').slimScroll({
          height: '450px'
      });
      $('.slimScrollDiv').css('overflow', '');
      
      $('.sortable-list').sortable({
        connectWith: '.sortable-list',
        items: "> li",
        over: function( event, ui ) {
          $('.sortable-list').each(function() {
            var hr = $(this).find('hr');
            $(this).append(hr);
          });
        },
        receive: function( event, ui ) {
          var columns = [];
          $('ul.sortable-list').each(function() {
            var data = [$(this).attr('id'), $(this).sortable('toArray')];
            columns.push(data);
          });

          $.ajax({
            url: '/projects',
            data: { columns: columns },
            type: "POST",
            success: function(data) {
              if (data.error) {
                data = { class: 'danger', faicon: 'ban', status: "{!! Lang::get('general.failed') !!}", message: data.error };
                throwMessage(data);
              }
            }
          });
        }
      });
      function throwMessage(data) {
        html = '<div class="alert alert-' + data.class + ' alert-dismissable">';
        html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        html += '<h4>    <i class="icon fa fa-' + data.faicon + '"></i> ' + data.status + '</h4>';
        html += data.message;
        html += '</div>';

        return html;
      };
    </script>
@endsection