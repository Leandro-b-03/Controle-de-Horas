@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.users')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.users') !!}
            <small>{!! Lang::get('users.list') !!}</small>
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
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{!! Lang::get('general.users') !!}</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="pull-right">
            <a href="{!! URL::to('users/create') !!}" class="btn btn-primary">{!! Lang::get('users.new') !!}</a>
            <a id="delete" data-name="Cliente" class="btn btn-danger">{!! Lang::get('users.delete') !!}</a>
        </div>
        <hr class="clearfix" />
        @if($data['users']->count())
        @foreach($data['users'] as $user)
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <div class="widget-user-image">
                <img class="img-circle" src="{!! URL::to($user->photo) !!}" alt="User Avatar">
              </div><!-- /.widget-user-image -->
              <h3 class="widget-user-username">{!! $user->first_name . ' ' . $user->last_name !!}</h3>
              <h5 class="widget-user-desc">{!! $user->roles()->first()->display_name !!}</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a>{!! Lang::get('general.hours') !!} <span class="pull-right badge bg-blue">{!! html_entity_decode(GeneralHelper::getOvertime($user->id)) !!}</span></a></li>
                <li><a href="{!! URL::to('users/' . $user->id . '/timesheet') !!}">{!! Lang::get('general.timesheets') !!} <span class="pull-right badge bg-aqua">{!! Lang::get('general.edit') !!}</span></a></li>
                <li><a href="{!! URL::to('users/' . $user->id . '/edit') !!}" class="btn">{!! Lang::get('general.edit') !!}</a></li>
              </ul>
            </div>
          </div><!-- /.widget-user -->
        </div>
        @endforeach
        @endif
        {!! Form::open(array('route' => 'users.destroy', 'method' => 'DELETE', 'id' => 'delete-form')) !!}
            <input type="hidden" name="id" id="delete-id" name="delete_id" value="">
        {!! Form::close() !!}
    </div><!-- /.box-body -->
    <div class="box-footer">
    {!! $data['users']->render() !!}
    </div><!-- /.box-footer-->
</div><!-- /.box -->
@endsection

@section('scripts')
    <!-- DATA TABES SCRIPT -->
    {!! Html::script("library/adminLTE/plugins/datatables/jquery.dataTables.min.js") !!}
    {!! Html::script("library/adminLTE/plugins/datatables/dataTables.bootstrap.min.js") !!}
    <!-- SlimScroll -->
    {!! Html::script("library/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js") !!}
    <!-- FastClick -->
    {!! Html::script("library/adminLTE/plugins/fastclick/fastclick.min.js") !!}
@endsection
