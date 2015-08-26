@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.client-groups')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::style("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/theme-default.min.css") !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.client-groups') !!}
            @if (Request::is('client-groups/create'))
            <small>{!! Lang::get('client-groups.create') !!}</small>
            @else
            <small>{!! Lang::get('client-groups.edit') !!}</small>
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
            @if (Request::is('client-groups/create'))
            {!! Form::open(array('route' => 'client-groups.store')) !!}
            @else
            {!! Form::open(array('route' => [ 'client-groups.update', $data['client']->id ], 'method' => 'PUT')) !!}
            @endif
              <div class="box-body">
                <div class="form-group col-xs-5">
                  <label for="name">{!! Lang::get('client-groups.label-name') !!}</label>
                  <input type="text" class="form-control" name="name" id="name"  value="{!! (isset($data['client']) ? $data['client']->name : (Request::old('name') ? Request::old('name') : '')) !!}" placeholder="{!! Lang::get('client-groups.ph-name') !!}" data-validation="length" data-validation-length="3-12" data-validation-error-msg="{!! Lang::get('client-groups.error-name') !!}" required>
                </div>
                <div class="form-group col-xs-4">
                  <label for="client_id">{!! Lang::get('general.clients') !!}</label>
                  <select name="client_id" class="form-control" data-validation="required" data-validation-error-msg="{!! Lang::get('proposals.error-clients') !!}" required>
                    <option value="">{!! Lang::get('general.select') !!}</option>
                    @if($data['clients'] != null)
                    @foreach ($data['clients'] as $client)
                    <option value="{!! $client->id !!}" {!! (isset($data['proposal']) ? ($data['proposal']->client()->getResults()->id == $client->id ? 'selected="selected"' : "") : "") !!}>{!! $client->name !!}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group col-xs-12">
                  <hr/ >
                </div>
                <div class="form-group col-xs-7">
                  <label for="description">{!! Lang::get('client-groups.label-description') . ' (<span id="description-maxlength">255</span>) ' . Lang::get('general.char_left') !!}</label>
                  <textarea class="form-control" name="description" id="description" placeholder="{!! Lang::get('client-groups.ph-description') !!}" data-validation="length" data-validation-length="10-255" data-validation-error-msg="{!! Lang::get('client-groups.error-description') !!}">{!! (isset($data['project']) ? $data['project']->description : (Request::old('description') ? Request::old('description') : '')) !!}</textarea>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.save') !!}</button>
                <a href="{!! URL::to('client-groups') !!}" class="btn btn-danger">{!! Lang::get('general.back') !!}</a>
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
      
      $('#description').restrictLength($('#description-maxlength'));

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