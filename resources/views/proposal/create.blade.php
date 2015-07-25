@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.proposals')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
    <!-- CKEditor -->
    {!! Html::style("library/adminLTE/plugins/ckeditor/ckeditor.css") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::style("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/theme-default.min.css") !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.proposals') !!}
            @if (Request::is('proposals/create'))
            <small>{!! Lang::get('proposals.create') !!}</small>
            @else
            <small>{!! Lang::get('proposals.edit') !!}</small>
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
            @if (Request::is('proposals/create'))
            {!! Form::open(array('route' => 'proposals.store')) !!}
            @else
            {!! Form::open(array('route' => [ 'proposals.update', $data['proposal']->id ], 'method' => 'PUT')) !!}
            @endif
              <div class="box-body">
                <div class="form-group col-xs-8">
                  <label for="name">{!! Lang::get('proposals.label-name') !!}</label>
                  <input type="text" class="form-control" name="name" id="name"  value="{!! (isset($data['proposal']) ? $data['proposal']->name : (Request::old('name') ? Request::old('name') : '')) !!}" placeholder="{!! Lang::get('proposals.ph-name') !!}" data-validation="length" data-validation-length="3-12" data-validation-error-msg="{!! Lang::get('proposals.error-name') !!}" required>
                </div>
                <div class="form-group col-xs-4">
                  <label for="client_id">{!! Lang::get('general.clients') !!}</label>
                  <select name="client_id" class="form-control" data-validation="required" data-validation-error-msg="{!! Lang::get('proposals.error-clients') !!}" required>
                    <option value="">{!! Lang::get('general.select') !!}</option>
                    @foreach ($data['clients'] as $client)
                    <option value="{!! $client->id !!}" {!! (isset($data['proposal']) ? ($proposal->client()->getResults()->id == $client->id ? 'selected="selected"' : "") : "") !!}>{!! $client->name !!}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="form-group col-xs-12">
                  <label for="proposal">{!! Lang::get('proposals.label-proposal') !!}</label>
                  <textarea name="proposal" id="proposal" rows="10" placeholder="{!! Lang::get('proposals.ph-proposal') !!}" data-validation-error-msg="{!! Lang::get('proposals.error-proposal') !!}" required>{!! (isset($data['proposal']) ? $data['proposal']->proposal : (Request::old('proposal') ? Request::old('proposal') : '')) !!}</textarea>
                </div>
                <input type="hidden" name="user_id" id="user_id" value="{!! (isset($data['proposal']) ? $data['proposal']->user_id : (Request::old('user_id') ? Request::old('user_id') : Auth::user()->id)) !!}">
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.save') !!}</button>
                <a href="{!! URL::to('proposals') !!}" class="btn btn-danger">{!! Lang::get('general.back') !!}</a>
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
    <!-- CKEditor -->
    {!! Html::script("library/adminLTE/plugins/ckeditor/ckeditor.js") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::script("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/jquery.form-validator.min.js") !!}

    <script>
      var ckeditor = CKEDITOR.replace('proposal');
      // ckeditor.resize('100%', '450px');

      $.validate();

      $('form').submit(function(e) {
        var messageLength = CKEDITOR.instances['noticeMessage'].getData().replace(/<[^>]*>/gi, '').length;
        if ($(this).find('.has-error').length > 0 || !messageLength) {
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