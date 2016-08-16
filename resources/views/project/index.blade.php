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
        {!! Form::open(['method' => 'GET', 'url' => 'projects', 'id' => 'search-form', 'class' => 'navbar-form navbar-left pull-right col-xs-12', 'role' => 'search'])  !!}
            <div class="input-group input-group-sm">
                <input id="search" type="text" class="form-control" name="search" placeholder="{{ Lang::get('general.search') }}">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        {!! Form::close() !!}
        <table id="client-list" class="table table-responsive table-hover table-border table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Projeto criado em</th>
                    <th>Progresso</th>
                    <th class="action-tr">{!! Lang::get('general.action') !!}</th>
                </tr>
            </thead>
            <tbody>
                @if($data['projects']->count())
                @foreach($data['projects'] as $project)
                <tr>
                    <td>{!! $project->name . $project->name_complement !!}</td>
                    <td>{!! $project->description !!}</td>
                    <td>{!! date('d/m/Y', strtotime($project->created_on)) !!}</td>
                    <td>
                        <p><strong>Horas programadas:</strong> {!! isset($project->custom_field()->where('custom_field_id', 33)->first()->value) && $project->custom_field()->where('custom_field_id', 33)->first()->value != "" ? $project->custom_field()->where('custom_field_id', 33)->first()->value : '0' !!}</p>
                        <p><strong>Horas Execultadas:</strong> {!! isset($project->custom_field()->where('custom_field_id', 36)->first()->value) && $project->custom_field()->where('custom_field_id', 36)->first()->value != "" ? $project->custom_field()->where('custom_field_id', 36)->first()->value : '0' !!}</p>
                        <div class="progress progress-striped">
                            <div class="progress-bar" role="progressbar" data-transitiongoal="{!! isset($project->custom_field()->where('custom_field_id', 36)->first()->value) ? $project->custom_field()->where('custom_field_id', 36)->first()->value : 0 / (isset($project->custom_field()->where('custom_field_id', 33)->first()->value) && $project->custom_field()->where('custom_field_id', 33)->first()->value != 0 ? $project->custom_field()->where('custom_field_id', 33)->first()->value : 1) * 100 !!}"></div>
                        </div>
                    </td>
                    <td><a href="{!! URL::to('projects/' . $project->id . '/edit') !!}" class="btn btn-primary">{!! Lang::get('general.edit') !!}</a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td rowspan="5">Nenhum projeto foi encontrado</td>
                </tr>
                @endif
            </tbody>
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
    <!-- Bootstrap-Progressbar -->
    {!! Html::script("library/adminLTE/plugins/bootstrap-progressbar/bootstrap-progressbar.min.js") !!}

    <script type="text/javascript">
      $(document).ready(function() {
        $('.progress .progress-bar').progressbar({display_text: 'fill'});
      });
    </script>
@endsection
