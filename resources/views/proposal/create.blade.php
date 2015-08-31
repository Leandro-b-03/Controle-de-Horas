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
        <div class="col-md-10">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header">
              @if (Request::is('proposals/create'))
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
                <div class="form-group col-xs-2">
                  <label for="name">{!! Lang::get('proposals.label-name') !!}</label>
                  <input type="text" class="form-control" name="name" id="name"  value="{!! (isset($data['proposal']) ? $data['proposal']->name : (Request::old('name') ? Request::old('name') : '')) !!}" placeholder="{!! Lang::get('proposals.ph-name') !!}" data-validation="length" data-validation-length="3-40" data-validation-error-msg="{!! Lang::get('proposals.error-name') !!}" required>
                </div>
                <div class="form-group col-xs-6">
                  <label for="description">{!! Lang::get('proposals.label-description') !!}</label>
                  <input type="text" class="form-control" name="description" id="description"  value="{!! (isset($data['proposal']) ? $data['proposal']->description : (Request::old('description') ? Request::old('description') : '')) !!}" placeholder="{!! Lang::get('proposals.ph-description') !!}" data-validation="length" data-validation-length="3-40" data-validation-error-msg="{!! Lang::get('proposals.error-description') !!}" required>
                </div>
                <div class="form-group col-xs-4">
                  <label for="client_id">{!! Lang::get('general.clients') !!}</label>
                  <select id="client_id" name="client_id" class="form-control" data-validation="required" data-validation-error-msg="{!! Lang::get('proposals.error-clients') !!}" required>
                    <option value="">{!! Lang::get('general.select') !!}</option>
                    @if(isset($data['clients']))
                    @foreach ($data['clients'] as $client)
                    <option value="{!! $client->id !!}" {!! (isset($data['proposal']) ? ($data['proposal']->client_id == $client->id ? 'selected="selected"' : "") : "") !!}>{!! $client->name !!}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="form-group col-xs-3">
                  <label for="client_group_id">{!! Lang::get('proposals.label-client_group') !!}</label>
                  <select id="client_group_id" name="client_group_id" class="form-control select2" style="width: 100%;" data-validation="required" data-validation-error-msg="{!! Lang::get('proposals.error-clients_group') !!}" {!! (Request::is('proposals/create') ? 'disabled="disabled"' : '') !!} required>
                    <option value="">{!! Lang::get('general.select') !!}</option>
                    @if(isset($data['client_groups']))
                    @foreach ($data['client_groups'] as $client_group)
                    <option value="{!! $client_group->id !!}" {!! (isset($data['proposal']) ? ($data['proposal']->client_group_id == $client_group->id ? 'selected="selected"' : "") : "") !!}>{!! $client_group->name !!}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group col-xs-3">
                  <label for="proposal_type_id">{!! Lang::get('proposals.label-type') !!}</label>
                  <select name="proposal_type_id" class="form-control select2" style="width: 100%;" data-validation="required" data-validation-error-msg="{!! Lang::get('proposals.error-clients') !!}" required>
                    <option value="">{!! Lang::get('general.select') !!}</option>
                    @if(isset($data['types']))
                    @foreach ($data['types'] as $type)
                    <option value="{!! $type->id !!}" {!! (isset($data['proposal']) ? ($data['proposal']->type()->getResults()->id == $type->id ? 'selected="selected"' : "") : "") !!}>{!! $type->name !!}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group col-xs-2">
                  <label for="version_id">{!! Lang::get('proposals.label-version') !!}</label>
                  <select id="version_id" name="version_id" class="form-control" data-validation="required" data-validation-error-msg="{!! Lang::get('proposals.error-clients') !!}" required>
                    <option value="new">{!! Lang::get('proposals.ph-new_version') !!}</option>
                    @if(isset($data['versions']))
                    @foreach ($data['versions'] as $version)
                    <option value="{!! $version->id !!}" {!! ($version->active ? 'selected="selected"' : "") !!}>{!! $version->version !!}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group col-xs-4">
                  <label>{!! Lang::get('proposals.label-status') !!}</label>
                  <div class="checkbox">
                    <label class="label-checkbox-fix"><input type="checkbox" disabled="disabled"> {!! Lang::get('proposals.label-send') !!}</label>
                    <label class="label-checkbox-fix"><input type="checkbox" disabled="disabled"> {!! Lang::get('proposals.label-approved') !!}</label>
                    <label class="label-checkbox-fix"><input type="checkbox" name="status"> {!! Lang::get('proposals.label-cancelled') !!}</label>
                  </div>
                </div>
                {{-- <div class="form-group col-xs-3">
                  <label for="version_id">{!! Lang::get('proposals.label-') !!}</label>
                </div> --}}
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="form-group col-xs-12">
                  <label for="proposal">{!! Lang::get('proposals.label-proposal') !!}</label>
                  <textarea name="proposal" id="proposal" rows="10" placeholder="{!! Lang::get('proposals.ph-proposal') !!}" data-validation-error-msg="{!! Lang::get('proposals.error-proposal') !!}" required>{!! (isset($data['versions']) ? $data['versions']->where('active', 1)->first()->proposal : (Request::old('proposal') ? Request::old('proposal') : '')) !!}</textarea>
                </div>
                <input type="hidden" name="user_id" id="user_id" value="{!! (isset($data['proposal']) ? $data['proposal']->user_id : (Request::old('user_id') ? Request::old('user_id') : Auth::user()->id)) !!}">
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.save') !!}</button>
                <a href="{!! URL::to('proposals') !!}" class="btn btn-danger">{!! Lang::get('general.back') !!}</a>
              </div>
            {!! Form::close() !!}
            @if(isset($data['versions']))
            @foreach ($data['versions'] as $version)
            <input type="hidden" id="{!! $version->version !!}" value="{!! htmlspecialchars($version->proposal) !!}" />
            @endforeach
            @endif
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

      $('#version_id').change(function() {
        ckeditor.setData($('#' + $('#version_id option:selected').text()).val());
      });

      if ($('#client_id').val() != '') {
        getClientGroup($('#client_id').val());
      }

      $("#client_id").on('select2:select', function() {
        getClientGroup($(this).val())
      });

      function getClientGroup(id) {
        $.ajax({
          url: '/general/getClientGroup',
          data: {id: id},
          type: "GET",
          success: function(data) {
            var client_groups = JSON.parse(data);

            if (client_groups.length > 0) {
              $('#client_group_id').prop( "disabled", false );
              $('#client_group_id').find('option[value!=""]').remove();

              var options = [];

              $.each(client_groups, function(i, client_group) {
                options.push('<option value="' + client_group.id + '">' + client_group.name + '</select>');
                return;
              });

              $('#client_group_id').append(options);
            } else {
              $('#client_group_id').prop( "disabled", true ).val($("#target option:first").val());
              $('#client_group_id').find('option[value!=""]').remove();
            }
          }
        });
      }

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