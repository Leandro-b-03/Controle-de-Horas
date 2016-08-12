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
    <!-- Bootstrap Tags Input -->
    {!! Html::style("library/adminLTE/plugins/bootstrap-tagsinput/src/bootstrap-tagsinput.css") !!}
@stop

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Perfil do Colaborador
          </h1>
          {{-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">User profile</li>
          </ol> --}}
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="{!! URL::to($data['user']->photo) !!}" alt="User profile picture">
                  <h3 class="profile-username text-center">{!! $data['user']->first_name . ' ' . $data['user']->last_name !!}</h3>
                  <p class="text-muted text-center">{!! $data['user']->roles()->first()->name !!}</p>

                  {{-- <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Followers</b> <a class="pull-right">1,322</a>
                    </li>
                    <li class="list-group-item">
                      <b>Following</b> <a class="pull-right">543</a>
                    </li>
                    <li class="list-group-item">
                      <b>Friends</b> <a class="pull-right">13,287</a>
                    </li>
                  </ul>

                  <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Sobre Mim</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <strong><i class="fa fa-book margin-r-5"></i>  {{ Lang::get('users.profile-education') }}</strong>
                  <p class="text-muted">
                    {{ $data['profile']->education or '---' }}
                  </p>

                  <hr>

                  <strong><i class="fa fa-map-marker margin-r-5"></i> {{ Lang::get('users.profile-location') }}</strong>
                  <p class="text-muted">{{ $data['location'] or '---' }}</p>

                  <hr>

                  <strong><i class="fa fa-pencil margin-r-5"></i> {{ Lang::get('users.profile-skills') }}</strong>
                  <p>
                  @if (isset($data['skills']))
                  @foreach ($data['skills'] as $skill)
                    <span class="label label-{{ $skill[0] }}">{{ $skill[1] }}</span>
                    {{-- <span class="label label-success">Coding</span>
                    <span class="label label-info">Javascript</span>
                    <span class="label label-warning">PHP</span>
                    <span class="label label-primary">Node.js</span> --}}
                  @endforeach
                  @else
                    <span>---</span>
                  @endif
                  </p>

                  <hr>

                  <strong><i class="fa fa-file-text-o margin-r-5"></i> {{ Lang::get('users.profile-description') }}</strong>
                    {{ $data['profile']->description or '---' }}
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#timeline" data-toggle="tab">Timeline</a></li>
                  @if ($data['user']->id == Auth::user()->id)
                  <li><a href="#settings" data-toggle="tab">Configurações</a></li>
                  @endif
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="timeline">
                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">
                      {{--*/ $project_id = null /*--}}
                      {{--*/ $change = 1 /*--}}
                      @if (isset($data['task']))
                      @foreach ($data['tasks'] as $task)
                      @if ($project_id != $task->project_id)
                      {{--*/ $project_id = $task->project_id /*--}}
                      {{--*/ $change = 1 /*--}}
                      @else
                      {{--*/ $change = 0 /*--}}
                      @endif
                      @if ($change == 1)
                      <!-- timeline time label -->
                      <li class="time-label">
                        <span class="{!! GeneralHelper::getBgStatus($task->getProject()->first()->status) !!}">
                          {!! $task->getProject()->first()->name !!}
                        </span>
                      </li>
                      <!-- /.timeline-label -->
                      @endif
                      <!-- timeline item -->
                      <li>
                        <i class="fa fa-tasks bg-blue"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> {!! GeneralHelper::withoutSeconds($task->start) . ' - ' . GeneralHelper::withoutSeconds($task->end) !!}</span>

                          <h3 class="timeline-header">{!! $task->getTask()->first()->subject !!}</h3>

                          <div class="timeline-body">
                            {!! $task->getTask()->first()->description !!}
                          </div>
                          {{-- <div class="timeline-footer">
                            <a class="btn btn-primary btn-xs">Read more</a>
                            <a class="btn btn-danger btn-xs">Delete</a>
                          </div> --}}
                        </div>
                      </li>
                      @endforeach
                      <!-- END timeline item -->
                      <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                      </li>
                      @endif
                    </ul>
                  </div><!-- /.tab-pane -->
                  @if ($data['user']->id == Auth::user()->id)
                  <div class="tab-pane" id="settings">
                    {!! Form::open(array('route' => [ 'users.update', $data['user']->id ], 'method' => 'PUT', 'name' => 'user-form', 'id' => 'edit')) !!}
                      <div class="box-body">
                        <div class="form-group col-xs-12">
                          <label for="username">{!! Lang::get('users.label-username') !!}</label>
                          <input type="text" class="form-control" name="username" id="username"  value="{!! (isset($data['user']) ? $data['user']->username : (Request::old('username') ? Request::old('username') : '')) !!}" placeholder="{!! Lang::get('users.ph-username') !!}" data-validation="length alphanumeric" data-validation-length="3-12" data-validation-allowing="-_ " data-validation-error-msg="{!! Lang::get('users.error-username') !!}" disabled>
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
                          <label for="birthday">{!! Lang::get('users.label-birthday') !!}</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control date input-mask" data-mask="99/99/9999" name="birthday" id="birthday"  value="{!! (isset($data['user']) ? date('d/m/Y', strtotime($data['user']->birthday)) : (Request::old('birthday') ? Request::old('birthday') : '')) !!}" placeholder="{!! Lang::get('users.ph-birthday') !!}" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-error-msg="{!! Lang::get('users.error-birthday') !!}" required>
                          </div>
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
                          <hr />
                        </div>
                        <div class="form-group col-xs-6">
                          <label for="education">{!! Lang::get('users.label-education') !!}</label>
                          <textarea class="form-control" name="education" id="education" placeholder="{!! Lang::get('users.ph-education') !!}" data-validation-error-msg="{!! Lang::get('users.error-education') !!}" data-validation="length" data-validation-length="10-1000">{!! (isset($data['profile']) ? $data['profile']->education : (Request::old('education') ? Request::old('education') : '')) !!}</textarea>
                        </div>
                        <div class="form-group col-xs-6">
                          <label for="skills">{!! Lang::get('users.label-skills') !!}</label>
                          <input type="text" class="form-control" name="skills" id="skills"  value="{!! (isset($data['profile']) ? $data['profile']->skills : (Request::old('skills') ? Request::old('skills') : '')) !!}" placeholder="{!! Lang::get('users.ph-skills') !!}" data-validation-error-msg="{!! Lang::get('users.error-skills') !!}" data-validation="length" data-validation-length="10-1000" data-role="tagsinput">
                        </div>
                        <div class="form-group col-xs-12">
                          <hr />
                        </div>
                        <div class="form-group col-xs-12">
                          <label for="description">{!! Lang::get('users.label-description') !!}</label>
                          <textarea class="form-control" name="description" id="description" data-validation="length" data-validation-length="10-1000" data-validation-error-msg="{!! Lang::get('users.error-description') !!}" placeholder="{!! Lang::get('users.ph-description') !!}">{!! (isset($data['profile']) ? $data['profile']->description : (Request::old('description') ? Request::old('description') : '')) !!}</textarea>
                        </div>
                      </div><!-- /.box-body -->
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary">{!! Lang::get('general.save') !!}</button>
                        <a href="{!! URL::to('users') !!}" class="btn btn-danger">{!! Lang::get('general.back') !!}</a>
                      </div>
                    {!! Form::close() !!}
                  </div><!-- /.tab-pane -->
                  @endif
                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->
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
    <!-- Bootstrap Tags Input -->
    {!! Html::script("library/adminLTE/plugins/bootstrap-tagsinput/src/bootstrap-tagsinput.js") !!}

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

      if (e.keyCode == 13) {
        e.preventDefault();
      }

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

      $('.bootstrap-tagsinput input').keypress(function(e) {
        if(e.which==46) {
          $(this).val($(this).val().replace(',', ''));
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