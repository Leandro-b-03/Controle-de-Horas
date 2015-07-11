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
        <table id="user-list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    {{-- <th><input type="checkbox" class="select-all" /></th> --}}
                    <th>{!! Lang::get('users.title-user-info') !!}</th>
                    <th>{!! Lang::get('users.title-projects') !!}</th>
                    <th>{!! Lang::get('users.title-teams') !!}</th>
                    <th>{!! Lang::get('general.action') !!}</th>
                </tr>
            </thead>
            @if($data['users']->count())
            <tbody>
                @foreach($data['users'] as $user)
                <tr>
                    {{-- <td><input type="checkbox" class="delete" data-value="{!! $user->id !!}" /></td> --}}
                    <td>
                        <img class="img-circle img-table" src="{!! $user->photo !!}" />
                        <div class="table-user-info">
                            <h4 title="{!! Lang::get('users.table-username') !!}"><i class="fa fa-user"></i> {!! $user->username !!}</h4>
                            <div class="block">
                                <p title="{!! Lang::get('users.table-name') !!}"><i class="fa fa-user"></i> <span>{!! $user->first_name . ' ' . $user->last_name !!}</span></p>
                                <p title="{!! Lang::get('users.table-email') !!}" class="email"><i class="fa fa-envelope"></i><span>{!! $user->email !!}</span></p>
                                <p title="{!! Lang::get('users.table-phone') !!}"><i class="fa fa-phone"></i> <span>{!! $user->phone !!}</span></p>
                            </div>
                            <div class="block">
                                <p title="{!! Lang::get('users.table-user_since') !!}"><i class="fa fa-calendar"></i> <span>{!! date('d/m/Y', strtotime($user->created_at)) !!}</span></p>
                                <p title="{!! Lang::get('users.table-group-permission') !!}"><i class="fa fa-group"></i><span>{!! $user->roles()->first()->display_name !!}</span></p>
                            </div>
                        </div>
                    </td>
                    <td></td>
                    <td></td>
                    <td><a href="{!! URL::to('users/' . $user->id . '/edit') !!}" class="btn btn-primary">{!! Lang::get('general.edit') !!}</a></td>
                </tr>
                @endforeach
            </tbody>
            @endif
        </table>
        {!! Form::open(array('route' => 'users.destroy', 'method' => 'DELETE', 'id' => 'delete-form')) !!}
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
