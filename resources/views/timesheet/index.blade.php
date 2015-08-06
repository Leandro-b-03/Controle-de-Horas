@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.timesheets')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.timesheets') !!}
            <small>{!! Lang::get('timesheets.list') !!}</small>
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
          <h3 class="box-title">{!! Lang::get('general.timesheets') !!}</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="pull-right">
            <a href="{!! URL::to('timesheets/create') !!}" class="btn btn-primary">{!! Lang::get('timesheets.new') !!}</a>
            <a id="delete" data-name="Cliente" class="btn btn-danger">{!! Lang::get('timesheets.delete') !!}</a>
        </div>
        <hr class="clearfix" />
        <table class="">
            <thead>
                <tr>
                    <th>{!! Lang::get('timesheets.weekend') !!}</th>
                    <th>{!! $data['firstday']->format('F') !!}</th>
                </tr>
            </thead>
            <tbody>
                @for($day = $data['firstday']->day; $day <= $data['lastday']->day; $day++)
                <tr>
                    @if($day == 1)
                    <td>{!! $data['firstday']->format('j') !!}</td>
                    <td>{!! $data['firstday']->format('l') !!}</td>
                    @else
                    <td>{!! $data['firstday']->addDay(1)->format('j') !!}</td>
                    <td>{!! $data['firstday']->format('l') !!}</td>
                    @endif
                </tr>
                @endfor
            </tbody>
            <tfoot>
                <tr></tr>
            </tfoot>
        </table>
        {{-- <table id="timesheet-list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="select-tr"><input type="checkbox" class="select-all" /></th>
                    <th>{!! Lang::get('timesheets.title-name') !!}</th>
                    <th>{!! Lang::get('timesheets.title-responsible') !!}</th>
                    <th>{!! Lang::get('timesheets.title-email') !!}</th>
                    <th>{!! Lang::get('timesheets.title-phone') !!}</th>
                    <th>{!! Lang::get('timesheets.title-created_at') !!}</th>
                    <th class="action-tr">{!! Lang::get('general.action') !!}</th>
                </tr>
            </thead>
            @if($data['timesheets']->count())
            <tbody>
                @foreach($data['timesheets'] as $timesheet)
                <tr>
                    <td><input type="checkbox" class="delete" data-value="{!! $timesheet->id !!}" /></td>
                    <td>{!! $timesheet->name !!}</td>
                    <td>{!! $timesheet->responsible !!}</td>
                    <td>{!! $timesheet->email !!}</td>
                    <td>{!! $timesheet->phone !!}</td>
                    <td>{!! date('d/m/Y', strtotime($timesheet->created_at)) !!}</td>
                    <td><a href="{!! URL::to('timesheets/' . $timesheet->id . '/edit') !!}" class="btn btn-primary">Editar</a></td>
                </tr>
                @endforeach
            </tbody>
            @endif
        </table> --}}
        {!! Form::open(array('route' => 'timesheets.destroy', 'method' => 'DELETE', 'id' => 'delete-form')) !!}
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
