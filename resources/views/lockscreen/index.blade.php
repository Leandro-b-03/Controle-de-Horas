<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.lockscreen')]) !!}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    {!! Html::style("library/adminLTE/bootstrap/css/bootstrap.min.css") !!}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    {!! Html::style("library/adminLTE/dist/css/AdminLTE.min.css") !!}
    <!-- Custom style -->
    {!! Html::style("library/adminLTE/custom/custom.css") !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition lockscreen">
    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper">
      <div class="lockscreen-logo">
        <a href="../../index2.html"><b>SV</b>Labs</a>
      </div>
      <!-- User name -->
      <div class="lockscreen-name">{!! Auth::user()->getEloquent()->first_name !!} {!! Auth::user()->getEloquent()->last_name !!}</div>

      <!-- START LOCK SCREEN ITEM -->
      <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
          <img src="{!! (Auth::user()->getEloquent() ? URL::to(Auth::user()->getEloquent()->photo) : '') !!}" alt="{!! Auth::user()->getEloquent()->first_name !!} {!! Auth::user()->getEloquent()->last_name !!}">
        </div>
        <!-- /.lockscreen-image -->

        <!-- lockscreen credentials (contains the form) -->
        <form class="lockscreen-credentials">
          <div class="input-group lockscreen-center">
            <p id="timer" class="form-control">00:00:00</p>
            <!-- <input type="password" class="form-control" placeholder="password"> -->
            <div class="input-group-btn">
              <!-- <button class="btn"><i class="fa fa-arrow-right text-muted"></i></button> -->
            </div>
          </div>
        </form><!-- /.lockscreen credentials -->

      </div><!-- /.lockscreen-item -->
      <div class="help-block text-center">
        {!! Lang::get('lockscreen.lunch') !!}
      </div>
      <div class="text-center">
        <a>{!! Lang::get('lockscreen.wait') !!}</a>
      </div>
      <div class="lockscreen-footer text-center">
        {!! Lang::get('general.copyright') !!}
      </div>
    </div><!-- /.center -->

    <!-- jQuery 2.1.4 -->
    {!! Html::script("library/adminLTE/plugins/jQuery/jQuery-2.1.4.min.js") !!}
    <!-- Bootstrap 3.3.5 -->
    {!! Html::script("library/adminLTE/bootstrap/js/bootstrap.min.js") !!}
    <!-- Jquery Countdown -->
    {!! Html::script("library/adminLTE/plugins/jQuery.Countdown/dist/jquery.countdown.js") !!}

    <script>
      $('#timer').countdown('{!! str_replace('-', '/', $data['lunch_time']->toDateTimeString()) !!}', function(event) {
        $(this).html(event.strftime('%H:%M:%S'));
      }).on('finish.countdown', function() {
        window.location = "http://timesheet.localhost.com/timesheets";
      });;
    </script>
  </body>
</html>