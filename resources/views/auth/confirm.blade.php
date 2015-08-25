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
    <div class="login-box" style="width: 500px">
      <div class="login-logo">
        <a target="_blank" href="http://www.svlabs.com.br/"><b>SVL</b>abs</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
      @if (isset($status))
        <h1>Conta ativada com sucesso!</h1>
        <p>Você será redirecionado(a) para a tela de login em alguns instantes.<br />
           <a href="{!! URL::to('/') !!}">Clique aqui se não for redirecionado(a).</a>
        </p><br />
      @endif
      @if (isset($token))
        <h1>Houve um erro ao verificar o token!</h1>
        <p>O token de verificação não existe ou já foi validade por favor entre em contato com o <a href="mailto:admin@svlabs.com?subject=Validação de Email" "Validação de Email">administrador</a>.<br />
           <a href="{!! URL::to('/') !!}">Clique aqui para ir a tela de login.</a>
        </p><br />
      @endif
      @if (isset($dbase))
        <h1>Houve um erro ao ativar a conta!</h1>
        <p>Não foi possivel ativar a conta por problemas técnicos por favor entre em contato com o <a href="mailto:admin@svlabs.com?subject=Validação de Email" "Validação de Email">administrador</a>.<br />
           <a href="{!! URL::to('/') !!}">Clique aqui para ir a tela de login.</a>
        </p><br />
      @endif
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    {!! Html::script("library/adminLTE/plugins/jQuery/jQuery-2.1.4.min.js") !!}
    <!-- Bootstrap 3.3.2 JS -->
    {!! Html::script("library/adminLTE/bootstrap/js/bootstrap.min.js") !!}
    <!-- iCheck -->
    {!! Html::script("library/adminLTE/plugins/iCheck/icheck.min.js") !!}
    <script>
    @if (isset($status))
      window.setTimeout(function() {
        window.location.href = "{!! URL::to('/') !!}";
      }, 5000);
    </script>
    @endif
  </body>
</html>