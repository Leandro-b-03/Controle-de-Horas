@extends('app')

@section('title')
    SVLabs | Clientes
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
@stop

@section('content')
        <h1>
            Clientes
            <small>lista de clientes</small>
        </h1>
        <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
        </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Clientes</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="pull-right">
            <a href="{!! URL::to('clients/create') !!}" class="btn btn-primary">Novo usuário</a>
            <a data-href="{!! URL::to('clients/destroy') !!}" data-token="{!! csrf_token() !!}" id="delete" class="btn btn-danger">Deletar usuário(s)</a>
        </div>
        <hr class="clearfix" />
        <table id="client-list" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" class="select-all" /></th>
                    <th>Cliente</th>
                    <th>Responsável</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Cliente desde</th>
                    <th>Ação</th>
                </tr>
            </thead>
            @if($data['clients']->count())
            <tbody>
                @foreach($data['clients'] as $client)
                <tr>
                    <td><input type="checkbox" class="delete" data-value="{!! $client->id !!}" /></td>
                    <td>{!! $client->name !!}</td>
                    <td>{!! $client->responsible !!}</td>
                    <td>{!! $client->email !!}</td>
                    <td>{!! $client->telefone !!}</td>
                    <td>{!! date('d/m/Y', strtotime($client->created_at)) !!}</td>
                    <td><a href="{!! URL::to('clients/create') !!}" class="btn btn-primary">Editar</a></td>
                </tr>
                @endforeach
            </tbody>
            @endif
        </table>
        <input type="hidden" id="delete-id" name="delete_id" value="">
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
