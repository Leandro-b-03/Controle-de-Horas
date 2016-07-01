@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.users')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
    <!-- Datepicker -->
    {!! Html::style("library/adminLTE/plugins/datepicker/datepicker3.css") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::style("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/theme-default.min.css") !!}
    <!-- Cropper -->
    {!! Html::style("library/adminLTE/plugins/cropper/dist/cropper.min.css") !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.users') !!}
            @if (Request::is('users/create'))
            <small>{!! Lang::get('users.create') !!}</small>
            @else
            <small>{!! Lang::get('users.edit') !!}</small>
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
            @if (Request::is('users/create'))
            {!! Form::open(array('route' => 'users.store', 'name' => 'user-form')) !!}
            @else
            {!! Form::open(array('route' => [ 'users.update', $data['user']->id ], 'method' => 'PUT', 'name' => 'user-form', 'id' => 'edit')) !!}
            @endif
              <div class="box-body">
                <div class="form-group col-xs-12">
                  <label for="username">{!! Lang::get('users.label-username') !!}</label>
                  <input type="text" class="form-control" name="username" id="username"  value="{!! (isset($data['user']) ? $data['user']->username : (Request::old('username') ? Request::old('username') : '')) !!}" placeholder="{!! Lang::get('users.ph-username') !!}" data-validation="length alphanumeric" data-validation-length="3-12" data-validation-allowing="-_ " data-validation-error-msg="{!! Lang::get('users.error-username') !!}" required>
                </div>
                <div class="form-group col-xs-5">
                  <label for="first_name">{!! Lang::get('users.label-first_name') !!}</label>
                  <input type="first_name" class="form-control" name="first_name" id="first_name"  value="{!! (isset($data['user']) ? $data['user']->first_name : (Request::old('first_name') ? Request::old('first_name') : '')) !!}" placeholder="{!! Lang::get('users.ph-first_name') !!}" data-validation="length alphanumeric" data-validation-length="3-40" data-validation-allowing="-_ " data-validation-error-msg="{!! Lang::get('users.error-first_name') !!}" required>
                </div>
                <div class="form-group col-xs-5">
                  <label for="last_name">{!! Lang::get('users.label-last_name') !!}</label>
                  <input type="text" class="form-control" name="last_name" id="last_name"  value="{!! (isset($data['user']) ? $data['user']->last_name : (Request::old('last_name') ? Request::old('last_name') : '')) !!}" placeholder="{!! Lang::get('users.ph-last_name') !!}" data-validation="length alphanumeric" data-validation-length="3-40" data-validation-allowing="-_ " data-validation-error-msg="{!! Lang::get('users.error-last_name') !!}" required>
                </div>
                <div class="form-group col-xs-2">
                  <label for="gender">{!! Lang::get('users.label-gender') !!}</label>
                  <div class="radio">
                    <label><input name="gender" id="gender" value="F" type="radio" data-validation-qty="min1" data-validation-error-msg="{!! Lang::get('users.error-gender_female') !!}" {!! (isset($data['user']) ? ($data['user']->gender == 'F') ? 'checked="checked"' : ((Request::old('gender')) ? ((Request::old('gender') == 'F') ? 'checked="checked"' : '') : '') : '' ) !!} required> {!! Lang::get('users.ph-gender_female') !!}</label>
                  <div class="radio">
                  </div>
                    <label><input name="gender" id="gender" value="M" type="radio" {!! (isset($data['user']) ? ($data['user']->gender == 'M') ? 'checked="checked"' : ((Request::old('gender')) ? ((Request::old('gender') == 'M') ? 'checked="checked"' : '') : '') : '' ) !!}> {!! Lang::get('users.ph-gender_male') !!}</label>
                  </div>
                </div>
                <div class="form-group col-xs-8{!! Request::is('users/create') ? '' : ' has-success' !!}">
                  <label for="email">{!! Lang::get('users.label-email') !!}</label>
                  <input type="email" class="form-control{!! Request::is('users/create') ? '' : ' valid' !!}" name="email" id="email"  value="{!! (isset($data['user']) ? $data['user']->email : (Request::old('email') ? Request::old('email') : '')) !!}" placeholder="{!! Lang::get('users.ph-email') !!}" data-validation="email server" data-validation-url="/general/verifyEmailJSON" data-validation-error-msg="{!! Lang::get('users.error-email') !!}" {!! (Request::is('users/create') ? 'required' : 'disabled') !!}>
                </div>
                <div class="form-group col-xs-4">
                  <label for="phone">{!! Lang::get('users.label-phone') !!}</label>
                  <input type="text" class="form-control input-mask" data-mask="(99) *****-****" name="phone" id="phone"  value="{!! (isset($data['user']) ? $data['user']->phone : (Request::old('phone') ? Request::old('phone') : '')) !!}" placeholder="{!! Lang::get('users.ph-phone') !!}" data-validation="custom" data-validation-regexp="^\([1-9]{2}\)\ [2-9][0-9]{3,4}\-[0-9_]{3,4}$" data-validation-error-msg="{!! Lang::get('users.error-phone') !!}" required>
                </div>
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="form-group col-xs-4">
                  <label for="rg">{!! Lang::get('users.label-rg') !!}</label>
                  <input type="rg" class="form-control input-mask" data-mask="99999999?**" name="rg" id="rg"  value="{!! (isset($data['user']) ? $data['user']->rg : (Request::old('rg') ? Request::old('rg') : '')) !!}" placeholder="{!! Lang::get('users.ph-rg') !!}" data-validation="custom" data-validation-error-msg="{!! Lang::get('users.error-rg') !!}" required>
                </div>
                <div class="form-group col-xs-4{!! Request::is('users/create') ? '' : ' has-success' !!}">
                  <label for="cpf">{!! Lang::get('users.label-cpf') !!}</label>
                  <input type="text" class="form-control input-mask{!! Request::is('users/create') ? '' : ' valid' !!}" data-mask="999.999.999-99" name="cpf" id="cpf"  value="{!! (isset($data['user']) ? $data['user']->cpf : (Request::old('cpf') ? Request::old('cpf') : '')) !!}" placeholder="{!! Lang::get('users.ph-cpf') !!}" data-validation="custom server" data-validation-url="/general/verifyCPFJSON" data-validation-regexp="^[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}$" data-validation-error-msg="{!! Lang::get('users.error-cpf') !!}" {!! (Request::is('users/create') ? 'required' : 'disabled') !!}>
                </div>
                <div class="form-group col-xs-4">
                  <label for="role">{!! Lang::get('general.group-permissions') !!}</label>
                  <select name="role" class="form-control" data-validation="required" required>
                    <option value="">{!! Lang::get('general.select') !!}</option>
                    @foreach ($data['roles'] as $role)
                    <option value="{!! $role->id !!}" {!! (isset($data['user']) && ($data['user']->roles()->get()->count()) ? (($data['user']->roles()->first()->id == $role->id) == 1 ? 'selected="selected"' : "") : "") !!}>{!! $role->display_name !!}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="form-group col-xs-6">
                  <label>{!! Lang::get('users.label-photo') !!}</label>
                  <br />
                  <ul class="ch-grid">
                    <li>
                      <div class="ch-item"> 
                        <div class="ch-info">
                          <h3>{!! Lang::get('users.h3-change_photo') !!}</h3>
                          <p><a href="#filemanager" role="button" class="" data-toggle="modal">{!! Lang::get('users.a-open_filemanager') !!}</a></p>
                        </div>
                        <div class="ch-thumb ch-img-1">
                          <img id="image" src="{{ URL::to('/') }}/{{ (isset($data['user']) ? $data['user']->photo : "uploads/img-not-found.jpg") }}">
                        </div>
                      </div>
                    </li>
                  </ul>
                  <input type='hidden' class="form-control" id='photo' name='photo' value='{!! (isset($data['user']) ? $data['user']->photo : "source/img-not-found.jpg") !!}' />
                </div>
                <div class="form-group col-xs-6">
                  <label for="birthday">{!! Lang::get('users.label-birthday') !!}</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control date input-mask" data-mask="99/99/9999" name="birthday" id="birthday"  value="{!! (isset($data['user']) ? date('d/m/Y', strtotime($data['user']->birthday)) : (Request::old('birthday') ? Request::old('birthday') : '')) !!}" placeholder="{!! Lang::get('users.ph-birthday') !!}" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-error-msg="{!! Lang::get('users.error-birthday') !!}" required>
                  </div>
                </div>
                <div class="form-group col-xs-6">
                  <hr />
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.save') !!}</button>
                <a href="{!! URL::to('users') !!}" class="btn btn-danger">{!! Lang::get('general.back') !!}</a>
              </div>
            {!! Form::close() !!}
          </div><!-- /.box -->
        </div>
      </div>
    </section>
    <!-- Cropping modal -->
    <div class="modal fade" id="md-crop" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
          </div>
          <div class="modal-body">
            <div class="avatar-body">

            <input type="hidden" class="avatar-input" name="" value="">
              <!-- Upload image and data -->
              <!-- <div class="avatar-upload">
                <input type="hidden" class="avatar-src" name="avatar_src">
                <input type="hidden" class="avatar-data" name="avatar_data">
                <label for="avatarInput">Local upload</label>
                <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
              </div> -->

              <!-- Crop and preview -->
              <div class="row">
                <div class="col-md-9">
                  <div class="avatar-wrapper">
                    <img id="" src="" alt="">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="avatar-preview preview-lg"></div>
                  <div class="avatar-preview preview-md"></div>
                  <div class="avatar-preview preview-sm"></div>
                </div>
              </div>

              <div class="row avatar-btns">
                <div class="col-md-9">
                  <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
                      <span data-original-title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)" class="docs-tooltip" data-toggle="tooltip" title="">
                        <span class="fa fa-arrows"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
                      <span data-original-title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)" class="docs-tooltip" data-toggle="tooltip" title="">
                        <span class="fa fa-crop"></span>
                      </span>
                    </button>
                  </div>

                  <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                      <span data-original-title="$().cropper(&quot;zoom&quot;, 0.1)" class="docs-tooltip" data-toggle="tooltip" title="">
                        <span class="fa fa-search-plus"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                      <span data-original-title="$().cropper(&quot;zoom&quot;, -0.1)" class="docs-tooltip" data-toggle="tooltip" title="">
                        <span class="fa fa-search-minus"></span>
                      </span>
                    </button>
                  </div>

                  <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
                      <span data-original-title="$().cropper(&quot;rotate&quot;, -45)" class="docs-tooltip" data-toggle="tooltip" title="">
                        <span class="fa fa-rotate-left"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
                      <span data-original-title="$().cropper(&quot;rotate&quot;, 45)" class="docs-tooltip" data-toggle="tooltip" title="">
                        <span class="fa fa-rotate-right"></span>
                      </span>
                    </button>
                  </div>

                  <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                      <span data-original-title="$().cropper(&quot;scaleX&quot;, -1)" class="docs-tooltip" data-toggle="tooltip" title="">
                        <span class="fa fa-arrows-h"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                      <span data-original-title="$().cropper(&quot;scaleY&quot;, -1)" class="docs-tooltip" data-toggle="tooltip" title="">
                        <span class="fa fa-arrows-v"></span>
                      </span>
                    </button>
                  </div>

                  <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
                      <span data-original-title="$().cropper(&quot;crop&quot;)" class="docs-tooltip" data-toggle="tooltip" title="">
                        <span class="fa fa-check"></span>
                      </span>
                    </button>
                    <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
                      <span data-original-title="$().cropper(&quot;clear&quot;)" class="docs-tooltip" data-toggle="tooltip" title="">
                        <span class="fa fa-remove"></span>
                      </span>
                    </button>
                  </div>
                </div>
                <div class="col-md-3">
                  <a type="submit" class="btn btn-primary btn-block avatar-save">Done</a>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
        </div>
      </div>
    </div><!-- /.modal -->
@endsection

@section('scripts')
    <!-- Jasny-bootstrap -->
    {!! Html::script("library/adminLTE/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js") !!}
    <!-- Datepicker -->
    {!! Html::script("library/adminLTE/plugins/datepicker/bootstrap-datepicker.js") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::script("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/jquery.form-validator.min.js") !!}
    <!-- Cropper -->
    {!! Html::script("library/adminLTE/plugins/cropper/dist/cropper.min.js") !!}
    <!-- Cropper custom class to events -->
    {!! Html::script("library/adminLTE/custom/custom-cropper.js") !!}

    <script>
      $.validate({
        modules : 'security',
        onModulesLoaded : function() {
          var optionalConfig = {
            fontSize: '8pt',
            padding: '4px',
            bad : '{!! Lang::get('users.password-bad') !!}',
            weak : '{!! Lang::get('users.password-weak') !!}',
            good : '{!! html_entity_decode(Lang::get('users.password-good')) !!}',
            strong : '{!! Lang::get('users.password-strong') !!}'
          };

          $('input[name="password_confirmation"]').displayPasswordStrength(optionalConfig);
        }
      });

      $('form').submit(function(e) {
        if ($(this).find('.has-error').length > 0) {
          e.preventDefault();
          var data = {class:'danger', faicon:'ban', status:"{!! Lang::get('general.failed') !!}", message:"{!! html_entity_decode(Lang::get('general.failed-fields')) !!}"};
            $('#messages').html(throwMessage(data));
        }
        if ($('#password').val() != ""){
          if ($('#password').val() != $('#password_confirmation').val()) {
            var data = {class:'danger', faicon:'ban', status:"{!! Lang::get('general.failed') !!}", message:"{!! Lang::get('general.failed-password') !!}"};
            $('#messages').html(throwMessage(data));

            scrollToAnchor('messages');
            e.preventDefault();
          } else {
            return;
          }
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