@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.group-permissions')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.group-permissions') !!}
            <small>{!! Lang::get('group-permissions.list') !!}</small>
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
          <h3 class="box-title">{!! Lang::get('general.group-permissions') !!}</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="pull-right">
            <a href="{!! URL::to('group-permissions/create') !!}" class="btn btn-primary">{!! Lang::get('group-permissions.new') !!}</a>
            <a id="delete" data-name="Cliente" class="btn btn-danger">{!! Lang::get('group-permissions.delete') !!}</a>
        </div>
        <hr class="clearfix" />
        {!! Form::open(['method' => 'GET', 'url' => 'group-permissions', 'id' => 'search-form', 'class' => 'navbar-form navbar-left pull-right col-xs-12', 'role' => 'search'])  !!}
            <div class="input-group input-group-sm">
                <input id="search" type="text" class="form-control" name="search" placeholder="{{ Lang::get('general.search') }}">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        {!! Form::close() !!}
        <table id="group-list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="select-tr"><input type="checkbox" class="select-all" /></th>
                    <th>{!! Lang::get('group-permissions.title-name') !!}</th>
                    <th>{!! Lang::get('group-permissions.title-display_name') !!}</th>
                    <th>{!! Lang::get('group-permissions.title-created_at') !!}</th>
                    <th class="action-tr">{!! Lang::get('general.action') !!}</th>
                </tr>
            </thead>
            @if($data['groups']->count())
            <tbody>
                @foreach($data['groups'] as $group)
                <tr>
                    <td><input type="checkbox" class="delete" data-value="{!! $group->id !!}" /></td>
                    <td>{!! $group->name !!}</td>
                    <td>{!! $group->display_name !!}</td>
                    <td>{!! date('d/m/Y', strtotime($group->created_at)) !!}</td>
                    <td><a href="{!! URL::to('group-permissions/' . $group->id . '/edit') !!}" class="btn btn-primary">{!! Lang::get('general.edit') !!}</a></td>
                </tr>
                @endforeach
            </tbody>
            @endif
        </table>
        {!! Form::open(array('route' => 'group-permissions.destroy', 'method' => 'DELETE', 'id' => 'delete-form')) !!}
            <input type="hidden" name="id" id="delete-id" name="delete_id" value="">
        {!! Form::close() !!}
    </div><!-- /.box-body -->
    <div class="box-footer">
      Footer
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
