@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.projects')]) !!}
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
@stop

@section('content')
        <h1>
            {!! Lang::get('general.projects') !!}
            <small>{!! Lang::get('projects.list') !!}</small>
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
          <h3 class="box-title">{!! Lang::get('general.projects') !!}</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <table id="client-list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Projeto criado em</th>
                    <th class="action-tr">{!! Lang::get('general.action') !!}</th>
                </tr>
            </thead>
            @if($data['projects']->count())
            <tbody>
                @foreach($data['projects'] as $project)
                <tr>
                    <td rowspan="2">{!! $project->name . $project->name_complement !!}</td>
                    <td>{!! $project->description !!}</td>
                    <td>{!! date('d/m/Y', strtotime($project->created_on)) !!}</td>
                    <td><a href="{!! URL::to('projects/' . $project->id . '/edit') !!}" class="btn btn-primary">{!! Lang::get('general.edit') !!}</a></td>
                </tr>
                <tr>
                    <td colspan="5">
                        <strong>Horas programadas:</strong> {!! $project->custom_field()->where('custom_field_id', 33)->first()->value !!}
                        <strong>Horas Execultadas:</strong> {!! $project->custom_field()->where('custom_field_id', 36)->first()->value or '0' !!}
                        {!! d(($project->custom_field()->where('custom_field_id', 36)->first()->value or 1) / ($project->custom_field()->where('custom_field_id', 33)->first()->value or 1)) !!}
                        <div class="progress">
                            <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {!! ((int)$project->custom_field()->where('custom_field_id', 33)->first()->value / (int)($project->custom_field()->where('custom_field_id', 36)->first()->value or 1)) * 100 !!}%">
                                <span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            @endif
        </table>
    </div><!-- /.box-body -->
    <div class="box-footer">
      {!! $data['projects']->render() !!}
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
