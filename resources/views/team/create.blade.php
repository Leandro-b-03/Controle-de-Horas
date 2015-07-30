@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.teams')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
    <!-- Color Picker -->
    {!! Html::style("library/adminLTE/plugins/colorpicker/bootstrap-colorpicker.min.css") !!}
    <!-- Color Picker -->
    {!! Html::style("library/adminLTE/plugins/jQuery-Autocomplete/content/styles-custom.css") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::style("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/theme-default.min.css") !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.teams') !!}
            @if (Request::is('teams/create'))
            <small>{!! Lang::get('teams.create') !!}</small>
            @else
            <small>{!! Lang::get('teams.edit') !!}</small>
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
            @if (Request::is('teams/create'))
            {!! Form::open(array('route' => 'teams.store')) !!}
            @else
            {!! Form::open(array('route' => [ 'teams.update', $data['team']->id ], 'method' => 'PUT')) !!}
            @endif
              <div class="box-body">
                <div class="form-group col-xs-3">
                  <label for="name">{!! Lang::get('teams.label-name') !!}</label>
                  <input type="text" class="form-control" name="name" id="name"  value="{!! (isset($data['team']) ? $data['team']->name : (Request::old('name') ? Request::old('name') : '')) !!}" placeholder="{!! Lang::get('teams.ph-name') !!}" data-validation="length" data-validation-length="3-12" data-validation-error-msg="{!! Lang::get('teams.error-name') !!}" required>
                </div>
                <div class="form-group col-xs-4">
                  <label for="user_id">{!! Lang::get('teams.label-responsible') !!}</label>
                  <select id="user_id" name="user_id" class="form-control" data-validation="required" data-validation-error-msg="{!! Lang::get('teams.error-responsible') !!}" required>
                    <option value="">{!! Lang::get('general.select') !!}</option>
                    @foreach ($data['users'] as $user)
                    <option value="{!! $user->id !!}" {!! (isset($data['team']) ? ($data['team']->user()->getResults()->id == $user->id ? 'selected="selected"' : "") : "") !!}>{!! $user->username !!}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-xs-2">
                  <label for="color">{!! Lang::get('teams.label-color') !!}</label>
                  <div class="input-group my-colorpicker2 colorpicker-element">
                    <input type="text" class="form-control" name="color" id="color"  value="{!! (isset($data['team']) ? $data['team']->color : (Request::old('color') ? Request::old('color') : '')) !!}" placeholder="{!! Lang::get('teams.ph-color') !!}" data-validation="lengh" data-validation-length="7" data-validation-error-msg="{!! Lang::get('teams.error-color') !!}" required>
                    <div class="input-group-addon">
                      <i style="background-color: rgb(0, 0, 0);"></i>
                    </div>
                  </div><!-- /.input group -->
                </div>
                <div class="form-group col-xs-12">
                  <hr />
                </div>
                <div class="form-group col-xs-5">
                  <label for="users">{!! Lang::get('general.users') !!}</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="users-autocomplete" placeholder="{!! Lang::get('team.search-user-name') !!}" />
                    <span class="input-group-btn">
                      <a id="search-user" class="btn btn-default"><i class="fa fa-search-plus"></i> {!! Lang::get('team.search-user') !!}</a>
                    </span>
                  </div>
                </div>
                <div id="users" class="form-group col-xs-12">
                  @if (!Request::is('teams/create'))
                  @foreach ($data['users_team'] as $team)
                    <img data-id="{!! $team->user()->getResults()->id !!}" class="img-circle img-div" src="../{!! $team->user()->getResults()->photo !!}" />
                    <div data-id="{!! $team->user()->getResults()->id !!}" class="div-user-info">
                      <h4 title="{!! Lang::get('users.table-username') !!}"><i class="fa {!! ($team->user()->getResults()->id == $data['team']->user_id ? 'fa-star' : 'fa-user') !!}"></i> {!! $team->user()->getResults()->username !!}<a data-id="{!! $team->user()->getResults()->id !!}" class="btn btn-xs btn-danger user-remove pull-right"><i class="fa fa-remove"></i></a></h4>
                      <div class="block">
                          <p title="{!! Lang::get('users.table-name') !!}"><i class="fa fa-user"></i> <span>{!! $team->user()->getResults()->first_name . ' ' . $team->user()->getResults()->last_name !!}</span></p>
                          <p title="{!! Lang::get('users.table-email') !!}" class="email"><i class="fa fa-envelope"></i><span>{!! $team->user()->getResults()->email !!}</span></p>
                      </div>
                      <input type="hidden" name="users_id[]" value="{!! $team->user()->getResults()->id !!}" />
                    </div>
                  @endforeach
                  @endif
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{!! Lang::get('general.save') !!}</button>
                <a href="{!! URL::to('teams') !!}" class="btn btn-danger">{!! Lang::get('general.back') !!}</a>
              </div>
            {!! Form::close() !!}
          </div><!-- /.box -->
        </div>
      </div>
    </section>
@endsection

@section('scripts')
    <!-- JS-Cookie -->
    {!! Html::script("library/adminLTE/plugins/js-cookie/src/js.cookie.js") !!}
    <!-- Jasny-bootstrap -->
    {!! Html::script("library/adminLTE/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js") !!}
    <!-- Color Picker -->
    {!! Html::script("library/adminLTE/plugins/colorpicker/bootstrap-colorpicker.min.js") !!}
    <!-- jQuery-Autocomplete -->
    {!! Html::script("library/adminLTE/plugins/jQuery-Autocomplete/dist/jquery.autocomplete.js") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::script("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/jquery.form-validator.min.js") !!}

    <script>
      var leader = "{!! (isset($data['team']) ? $data['team']->user_id : '') !!}";

      var users_team = {!! (!Request::is('teams/create') ? 'getUsers()' : (Request::is('teams/create') ? '(Cookie.get("users_team") != undefined) ? Cookie.get("users_team") : [] ' : '[]')) !!};

      $(".my-colorpicker2").colorpicker();

      $('#user_id').change(function() {
        if ($(this).val() != "") {
          $.ajax({
            url: '/general/getUser',
            data: {id: $(this).val()},
            type: "GET",
            success: function(data) {
              data = JSON.parse(data);

              if($('#users :input[value="' + data.id + '"]').length === 0) {
                $('#users div[data-id="' + leader + '"] h4 i.fa').removeClass('fa-star').addClass('fa-user');

                var html = '';
                html += '<img data-id="' + data.id + '" class="img-circle img-div" src="../' + data.photo + '" />';
                html += '<div data-id="' + data.id + '" class="div-user-info">';
                html += '    <h4 title="{!! Lang::get('users.table-username') !!}"><i class="fa fa-star"></i> ' + data.username + '<a data-id="' + data.id + '" class="btn btn-xs btn-danger user-remove pull-right"><i class="fa fa-remove"></i></a></h4>';
                html += '    <div class="block">';
                html += '        <p title="{!! Lang::get('users.table-name') !!}"><i class="fa fa-user"></i> <span>' + data.first_name + ' ' + data.last_name + '</span></p>';
                html += '        <p title="{!! Lang::get('users.table-email') !!}" class="email"><i class="fa fa-envelope"></i><span>' + data.email + '</span></p>';
                html += '    </div>';
                html += '    <input type="hidden" name="users_id[]" value="' + data.id + '" />';
                html += '</div>';

                $('#users').append(html);

                leader = data.id;

                setCookie('users_team');
              } else {
                if (leader != data.id) {
                  $('#users div[data-id="' + leader + '"] h4 i.fa').removeClass('fa-star').addClass('fa-user');
                  $('#users div[data-id="' + data.id + '"] h4 i.fa').removeClass('fa-user').addClass('fa-star');

                  leader = data.id;
                }
              }
            }
          });
        }
      });

      @if (Request::is('teams/create'))
      if (users_team != "") {
        $.ajax({
          url: '/general/getUsers',
          data: {ids: users_team},
          type: "GET",
          success: function(data) {
            var users = JSON.parse(data);

            leader = $('#user_id').val();

            users.forEach(function(element, data) {
              if($('#users :input[value="' + data.id + '"]').length === 0) {
                var html = '';
                html += '<img data-id="' + data.id + '" class="img-circle img-div" src="../' + data.photo + '" />';
                html += '<div data-id="' + data.id + '" class="div-user-info">';
                html += '    <h4 title="{!! Lang::get('users.table-username') !!}"><i class="fa fa-user"></i> ' + data.username + '<a data-id="' + data.id + '" class="btn btn-xs btn-danger user-remove pull-right"><i class="fa fa-remove"></i></a></h4>';
                html += '    <div class="block">';
                html += '        <p title="{!! Lang::get('users.table-name') !!}"><i class="fa fa-user"></i> <span>' + data.first_name + ' ' + data.last_name + '</span></p>';
                html += '        <p title="{!! Lang::get('users.table-email') !!}" class="email"><i class="fa fa-envelope"></i><span>' + data.email + '</span></p>';
                html += '    </div>';
                html += '    <input type="hidden" name="users_id[]" value="' + data.id + '" />';
                html += '</div>';

                $('#users').append(html);

                setCookie('users_team');
              }
              
              $('#users div[data-id="' + leader + '"] h4 i.fa').removeClass('fa-user').addClass('fa-star');
            });
          }
        });
      }
      @endif

      $('#users-autocomplete').autocomplete({
          serviceUrl: '/autocomplete/users',
          onSelect: function (suggestion) {
            if($('#users :input[value="' + suggestion.data.id + '"]').length === 0) {
              var html = '';
              html += '<img data-id="' + suggestion.data.id + '" class="img-circle img-div" src="../' + suggestion.data.photo + '" />';
              html += '<div data-id="' + suggestion.data.id + '" class="div-user-info">';
              html += '    <h4 title="{!! Lang::get('users.table-username') !!}"><i class="fa fa-user"></i> ' + suggestion.data.username + '<a data-id="' + suggestion.data.id + '" class="btn btn-xs btn-danger user-remove pull-right"><i class="fa fa-remove"></i></a></h4>';
              html += '    <div class="block">';
              html += '        <p title="{!! Lang::get('users.table-name') !!}"><i class="fa fa-user"></i> <span>' + suggestion.data.name + '</span></p>';
              html += '        <p title="{!! Lang::get('users.table-email') !!}" class="email"><i class="fa fa-envelope"></i><span>' + suggestion.data.email + '</span></p>';
              html += '    </div>';
              html += '    <input type="hidden" name="users_id[]" value="' + suggestion.data.id + '" />';
              html += '</div>';

              $('#users').append(html);

              setCookie('users_team');
            }
          }
      });

      function getUsers() {
        var users_team = [];
        $('#users div[data-id]').each(function() {
          users_team.push($(this).data('id'));
        });

        return users_team;
      }

      function setCookie(type) {
        users_team = getUsers();
        Cookies.set("users_team", users_team, { expires: 7 });
      }

      $('.user-remove').click(function() {
        var id = $(this).data('id');
        if (id != leader) {
          $('img[data-id="' + id + '"]').remove();
          $('div[data-id="' + id + '"]').remove();
        }
      })

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