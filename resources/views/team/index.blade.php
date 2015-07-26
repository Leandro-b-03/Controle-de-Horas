@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.teams')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.teams') !!}
            <small>{!! Lang::get('teams.list') !!}</small>
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
          <h3 class="box-title">{!! Lang::get('general.teams') !!}</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="pull-right">
            <a href="{!! URL::to('teams/create') !!}" class="btn btn-primary">{!! Lang::get('teams.new') !!}</a>
            <a id="delete" data-name="Cliente" class="btn btn-danger">{!! Lang::get('teams.delete') !!}</a>
        </div>
        <hr class="clearfix" />
        <table id="team-list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="select-tr"><input type="checkbox" class="select-all" /></th>
                    <th>{!! Lang::get('teams.title-name') !!}</th>
                    <th>{!! Lang::get('teams.title-responsible') !!}</th>
                    <th>{!! Lang::get('teams.title-color') !!}</th>
                    <th>{!! Lang::get('teams.title-preview') !!}</th>
                    <th>{!! Lang::get('teams.title-created_at') !!}</th>
                    <th class="action-tr">{!! Lang::get('general.action') !!}</th>
                </tr>
            </thead>
            @if($data['teams']->count())
            <tbody>
                @foreach($data['teams'] as $team)
                <tr>
                    <td><input type="checkbox" class="delete" data-value="{!! $team->id !!}" /></td>
                    <td>{!! $team->name !!}</td>
                    <td>{!! $team->user()->getResults()->username !!}</td>
                    <td>{!! $team->color !!} <span class="fa fa-square" style="color: {!! $team->color !!}"></span></td>
                    <td><span class="label label-success" style="background-color: {!! $team->color !!} !important">{!! $team->name !!}</span></td>
                    <td>{!! date('d/m/Y', strtotime($team->created_at)) !!}</td>
                    <td><a href="{!! URL::to('teams/' . $team->id . '/edit') !!}" class="btn btn-primary">Editar</a></td>
                </tr>
                @endforeach
            </tbody>
            @endif
        </table>
        {!! Form::open(array('route' => 'teams.destroy', 'method' => 'DELETE', 'id' => 'delete-form')) !!}
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
