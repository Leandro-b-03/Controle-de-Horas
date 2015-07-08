@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.clients')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::style("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/theme-default.min.css") !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.clients') !!}
            @if (Request::is('clients/create'))
            <small>{!! Lang::get('clients.create') !!}</small>
            @else
            <small>{!! Lang::get('clients.edit') !!}</small>
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
              @if (Request::is('group-permissions/create'))
              <h3 class="box-title">{!! Lang::get('general.create'); !!}</h3>
              @else
              <h3 class="box-title">{!! Lang::get('general.edit'); !!}</h3>
              @endif
            </div><!-- /.box-header -->
            <!-- form start -->
            @if (Request::is('clients/create'))
            {!! Form::open(array('route' => 'clients.store')) !!}
            @else
            {!! Form::open(array('route' => [ 'clients.update', $data['client']->id ], 'method' => 'PUT')) !!}
            @endif
              <div class="box-body">
                <div class="form-group col-xs-12">
                  <label for="name">{!! Lang::get('clients.label-name') !!}</label>
                  <input type="text" class="form-control" name="name" id="name"  value="{!! (isset($data['client']) ? $data['client']->name : "") !!}" placeholder="{!! Lang::get('clients.ph-name') !!}" data-validation="length" data-validation-length="3-12" data-validation-error-msg="{!! Lang::get('clients.error-name') !!}" required>
                </div>
                <div class="form-group col-xs-12">
                  <label for="responsible">{!! Lang::get('clients.label-responsible') !!}</label>
                  <input type="text" class="form-control" name="responsible" id="responsible"  value="{!! (isset($data['client']) ? $data['client']->responsible : "") !!}" placeholder="{!! Lang::get('clients.ph-responsible') !!}" data-validation="length" data-validation-length="3-80" data-validation-error-msg="{!! Lang::get('clients.error-responsible') !!}" required>
                </div>
                <div class="form-group col-xs-8">
                  <label for="email">{!! Lang::get('clients.label-email') !!}</label>
                  <input type="email" class="form-control" name="email" id="email"  value="{!! (isset($data['client']) ? $data['client']->email : "") !!}" placeholder="{!! Lang::get('clients.ph-email') !!}" data-validation="email" data-validation-error-msg="{!! Lang::get('clients.error-email') !!}" required>
                </div>
                <div class="form-group col-xs-4">
                  <label for="phone">{!! Lang::get('clients.label-phone') !!}</label>
                  <input type="text" class="form-control input-mask" data-mask="(99) *****-****" name="phone" id="phone"  value="{!! (isset($data['client']) ? $data['client']->phone : "") !!}" placeholder="{!! Lang::get('clients.ph-phone') !!}" data-validation="custom" data-validation-regexp="^\([1-9]{2}\)\ [2-9][0-9]{3,4}\-[0-9_]{3,4}$" data-validation-error-msg="{!! Lang::get('clients.error-phone') !!}" required>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.save') !!}</button>
                <a href="{!! URL::to('clients') !!}" class="btn btn-danger">{!! Lang::get('general.back') !!}</a>
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