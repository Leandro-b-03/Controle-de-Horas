<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.register')]) !!}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap 3.3.5 -->
    {!! Html::style("library/adminLTE/bootstrap/css/bootstrap.min.css") !!}
    <!-- Font Awesome -->
    {!! Html::style('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css') !!}
    <!-- Ionicons -->
    {!! Html::style('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') !!}
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
    <!-- Datepicker -->
    {!! Html::style("library/adminLTE/plugins/datepicker/datepicker3.css") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::style("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/theme-default.min.css") !!}
    <!-- iCheck -->
    {!! Html::style("library/adminLTE/plugins/iCheck/square/yellow.css") !!}
    {!! Html::style("library/adminLTE/plugins/iCheck/flat/yellow.css") !!}
    <!-- Theme style -->
    {!! Html::style("library/adminLTE/dist/css/AdminLTE.min.css") !!}
    <!-- Custom style -->
    {!! Html::style("library/adminLTE/custom/custom.css") !!}
    <!-- Cropper -->
    {!! Html::style("library/adminLTE/plugins/cropper/dist/cropper.min.css") !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition lockscreen">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper register">
      <div class="lockscreen-logo">
        <a href="../../index2.html"><b>SV</b>Labs</a>
      </div>
      <!-- User name -->
      <div class="lockscreen-name"> </div>

      <!-- START LOCK SCREEN ITEM -->
      <div class="row">
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">{!! Lang::get('general.create'); !!}</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(array('route' => 'users.store', 'name' => 'user-form')) !!}
              <div class="box-body">
                <div class="form-group col-xs-12">
                  <label for="username">{!! Lang::get('users.label-username') !!}</label>
                  <input type="hidden" name="username" id="username" value="{!! Auth::user()->getAuthIdentifier() !!}">
                  <input type="text" class="form-control" value="{!! Auth::user()->getAuthIdentifier() !!}" placeholder="{!! Lang::get('users.ph-username') !!}" data-validation="length alphanumeric" data-validation-length="3-12" data-validation-allowing="-_ " data-validation-error-msg="{!! Lang::get('users.error-username') !!}" disabled="disabled">
                </div>
                <div class="form-group col-xs-5">
                  <label for="first_name">{!! Lang::get('users.label-first_name') !!}</label>
                  <input type="first_name" class="form-control" name="first_name" id="first_name"  value="{!! Auth::user()->getFirstName() !!}" placeholder="{!! Lang::get('users.ph-first_name') !!}" data-validation="length alphanumeric" data-validation-length="3-40" data-validation-allowing="-_ " data-validation-error-msg="{!! Lang::get('users.error-first_name') !!}" required>
                </div>
                <div class="form-group col-xs-5">
                  <label for="last_name">{!! Lang::get('users.label-last_name') !!}</label>
                  <input type="text" class="form-control" name="last_name" id="last_name"  value="{!! Auth::user()->getLastName() !!}" placeholder="{!! Lang::get('users.ph-last_name') !!}" data-validation="length alphanumeric" data-validation-length="3-40" data-validation-allowing="-_ " data-validation-error-msg="{!! Lang::get('users.error-last_name') !!}" required>
                </div>
                <div class="form-group col-xs-2">
                  <label for="gender">{!! Lang::get('users.label-gender') !!}</label>
                  <div class="radio">
                    <label><input name="gender" id="gender" value="F" type="radio" data-validation-qty="min1" data-validation-error-msg="{!! Lang::get('users.error-gender_female') !!}"> {!! Lang::get('users.ph-gender_female') !!}</label>
                  <div class="radio">
                  </div>
                    <label><input name="gender" id="gender" value="M" type="radio"> {!! Lang::get('users.ph-gender_male') !!}</label>
                  </div>
                </div>
                <div class="form-group col-xs-8{!! Request::is('register') ? '' : ' has-success' !!}">
                  <label for="email">{!! Lang::get('users.label-email') !!}</label>
                  <input type="email" class="form-control{!! Request::is('register') ? '' : ' valid' !!}" name="email" id="email"  value="{!! Auth::user()->getEmail() !!}" placeholder="{!! Lang::get('users.ph-email') !!}" data-validation="email server" data-validation-url="/general/verifyEmailJSON" data-validation-error-msg="{!! Lang::get('users.error-email') !!}" {!! (Request::is('register') ? 'required' : 'disabled') !!}>
                </div>
                <div class="form-group col-xs-4">
                  <label for="phone">{!! Lang::get('users.label-phone') !!}</label>
                  <input type="text" class="form-control input-mask" data-mask="(99) *****-****" name="phone" id="phone"  value="" placeholder="{!! Lang::get('users.ph-phone') !!}" data-validation="custom" data-validation-regexp="^\([1-9]{2}\)\ [2-9][0-9]{3,4}\-[0-9_]{3,4}$" data-validation-error-msg="{!! Lang::get('users.error-phone') !!}" required>
                </div>
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="form-group col-xs-4">
                  <label for="rg">{!! Lang::get('users.label-rg') !!}</label>
                  <input type="rg" class="form-control" name="rg" id="rg"  value="" placeholder="{!! Lang::get('users.ph-rg') !!}" data-validation="custom" data-validation-error-msg="{!! Lang::get('users.error-rg') !!}" required>
                </div>
                <div class="form-group col-xs-4{!! Request::is('register') ? '' : ' has-success' !!}">
                  <label for="cpf">{!! Lang::get('users.label-cpf') !!}</label>
                  <input type="text" class="form-control input-mask{!! Request::is('register') ? '' : ' valid' !!}" data-mask="999.999.999-99" name="cpf" id="cpf"  value="" placeholder="{!! Lang::get('users.ph-cpf') !!}" data-validation="custom server" data-validation-url="/general/verifyCPFJSON" data-validation-regexp="^[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}$" data-validation-error-msg="{!! Lang::get('users.error-cpf') !!}" {!! (Request::is('register') ? 'required' : 'disabled') !!}>
                </div>
                <div class="form-group col-xs-4">
                  <!-- <label for="role">{!! Lang::get('general.group-permissions') !!}</label> -->
                  <!-- Roles -->
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
                          <img id="image" src="uploads/img-not-found.jpg">
                        </div>
                      </div>
                    </li>
                  </ul>
                  <input type='hidden' class="form-control" id='photo' name='photo' value='../source/img-not-found.jpg' />
                </div>
                <div class="form-group col-xs-6">
                  <label for="birthday">{!! Lang::get('users.label-birthday') !!}</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control date input-mask" data-mask="99/99/9999" name="birthday" id="birthday"  value="" placeholder="{!! Lang::get('users.ph-birthday') !!}" data-validation="date" data-validation-format="dd/mm/yyyy" data-validation-error-msg="{!! Lang::get('users.error-birthday') !!}" required>
                  </div>
                </div>
                <div class="form-group col-xs-6">
                  <hr />
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.save') !!}</button>
              </div>
            {!! Form::close() !!}
          </div><!-- /.box -->
        </div>
      </div><!-- /.lockscreen-item -->
      <div id="filemanager" class="modal">
	      <div class="modal-dialog">
	        <div class="modal-content">
	          <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	            <h4 class="modal-title">Gerenciador de arquivos</h4>
	          </div>
	          <div class="modal-body">
	            <iframe id="filemanager-iframe" src="{{ URL::to('/') }}/filemanager/dialog.php?type=1&field_id=photo"></iframe>
	          </div>
	        </div><!-- /.modal-content -->
	      </div><!-- /.modal-dialog -->
	    </div><!-- /.modal -->
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
      <div class="lockscreen-footer text-center">
        {!! Lang::get('general.copyright') !!}
      </div>
    </div><!-- /.center -->

    <!-- jQuery 2.1.4 -->
    {!! Html::script("library/adminLTE/plugins/jQuery/jQuery-2.1.4.min.js") !!}
    <!-- Bootstrap 3.3.5 -->
    {!! Html::script("library/adminLTE/bootstrap/js/bootstrap.min.js") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::script("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/jquery.form-validator.min.js") !!}
    <!-- Jasny-bootstrap -->
    {!! Html::script("library/adminLTE/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js") !!}
    <!-- Datepicker -->
    {!! Html::script("library/adminLTE/plugins/datepicker/bootstrap-datepicker.js") !!}
    <!-- SlimScroll -->
    {!! Html::script("library/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js") !!}
    <!-- iCheck -->
    {!! Html::script("library/adminLTE/plugins/iCheck/icheck.min.js") !!}
    <!-- Select2 -->
    {!! Html::script("library/adminLTE/plugins/select2/select2.full.min.js") !!}
    <!-- PNotify -->
    {!! Html::script("library/adminLTE/plugins/pnotify/src/pnotify.core.js") !!}
    <!-- Cropper -->
    {!! Html::script("library/adminLTE/plugins/cropper/dist/cropper.min.js") !!}
    <!-- Cropper custom class to events -->
    {!! Html::script("library/adminLTE/custom/custom-cropper.js") !!}

    <script type="text/javascript">
    	$.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    	});

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

		  $(':checkbox, :radio').iCheck({
		    checkboxClass: 'icheckbox_square-yellow',
		    radioClass: 'iradio_flat-yellow',
		        increaseArea: '20%' // optional
		  });

	    if ($('.date').length > 0) {
	      $('.date').datepicker({
	        format: 'dd/mm/yyyy'
	      });
	    }

      function responsive_filemanager_callback(field_id) {
        var url = $('#'+field_id).val();
        var url_web = location.origin;

        if ($('#file-name').length > 0) {
          $('#'+field_id).val(url.replace(url_web, ''));

          $('#file-name').val(url.replace(url_web, ''));
        }
        
        if (field_id == 'photo') {
          $('.avatar-wrapper img').remove();
          $('.avatar-wrapper .cropper-container').remove();
          $('.avatar-wrapper').append($('<img>').attr('src', url.replace('../', '/')));
          
          setTimeout(function() {
            cropStart($('.avatar-wrapper img'));
            $('#md-crop').modal('show');
          }, 1000);
          // $('#image').attr('src', url.replace('../', '/'));
        }
      }

      // function to start the crop
      function cropStart(image) {
        setTimeout(function() {
          image.cropper({
            aspectRatio: 1,
            preview: '.avatar-preview',
            crop: function (e) {
              var json = [
                '{"x":' + e.x,
                '"y":' + e.y,
                '"height":' + e.height,
                '"width":' + e.width,
                '"rotate":' + e.rotate + '}'
              ].join();
            },
            dragend: function(data) {
              originalData = image.cropper("getCroppedCanvas");
              console.log(originalData.toDataURL());
            }
          });
        }, 100);

        $('.avatar-btns button').each(function () {
          console.log($(this));
          $(this).click(function (e) {
              data = $(e.target).data();
              image.cropper(data.method, data.option);
          });
        }).tooltip({
          placement: 'bottom'
        });

        $('.avatar-save').one('click', function() {
          var data = {};
          originalData = image.cropper("getCroppedCanvas");
          data.image = originalData.toDataURL();

          console.log(data);

          $.ajax({
            url: '/general/saveImages',
            data: data,
            type: "POST",
            success: function(data) {
              console.log(data);
              if (!data.error) {
                $('#image').attr('src', data);
                $('#photo').val(data);
                $('#md-crop').modal('hide');
              } else {

              }
            }
          });
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
  </body>
</html>