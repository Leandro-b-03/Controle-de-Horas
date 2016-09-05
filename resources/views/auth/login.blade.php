<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SVLabs - Controle de Horas | Entrar</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    {!! Html::style("library/adminLTE/bootstrap/css/bootstrap.min.css") !!}
    <!-- Font Awesome Icons -->
    {!! Html::style("https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css") !!}
    <!-- Theme style -->
    {!! Html::style("library/adminLTE/dist/css/AdminLTE.min.css") !!}
    {!! Html::style("library/adminLTE/dist/css/skins/skin-yellow-light.min.css") !!}
    <!-- iCheck -->
    {!! Html::style("library/adminLTE/plugins/iCheck/square/yellow.css") !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a target="_blank" href="http://www.svlabs.com.br/"><b>SVL</b>abs</a>
        @if ($errors->count() >= 1)
        <div class="callout callout-danger lead">Login inválido, tente novamente!</div>
        @endif
        @if (Session::get('return'))
        <div class="callout callout-danger lead">{!! Session::get('return')['message'] !!}</div>
        @endif
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Faça login para entrar no dashboard</p>
        <form method="POST" action="/auth/login">
		      {!! csrf_field() !!}
          <div class="form-group has-feedback">
            <input name="username" type="text" class="form-control" placeholder="Usuário"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input name="password" type="password" class="form-control" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Lembrar-me
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
            </div><!-- /.col -->
          </div>
        </form>

        <!-- <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a> x-->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    {!! Html::script("library/adminLTE/plugins/jQuery/jQuery-2.1.4.min.js") !!}
    <!-- Bootstrap 3.3.2 JS -->
    {!! Html::script("library/adminLTE/bootstrap/js/bootstrap.min.js") !!}
    <!-- iCheck -->
    {!! Html::script("library/adminLTE/plugins/iCheck/icheck.min.js") !!}
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-yellow',
          radioClass: 'iradio_square-yellow',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>