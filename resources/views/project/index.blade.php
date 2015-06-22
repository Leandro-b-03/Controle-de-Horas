@extends('app')

@section('title')
    SVLabs | Projetos
@stop

@section('style')
    <!-- DATA TABLES -->
    {!! Html::style('library/adminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
@stop

@section('content')
        <h1>
            Projectos
            <small>lista de projetos</small>
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
          <h3 class="box-title">Projetos</h3>
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
                    <th>Cliente</th>
                    <th>Projeto criado em</th>
                    <th>Horas programadas</th>
                    <th></th>
                </tr>
            </thead>
            @if($data['projects']->count())
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            @endif
        </table>
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
    <script>
        $(function () {
            var table = $(".table").DataTable({
                language: {
                    processing:     "Carregando...",
                    search:         "Pesquisar&nbsp;:",
                    lengthMenu:     "Exibir _MENU_ registros",
                    info:           "Exibindo de _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty:      "Exibindo de 0 a 0 de 0 registros",
                    infoFiltered:   "(filtrado de _MAX_ registros no total)",
                    infoPostFix:    "",
                    loadingRecords: "Carregando...",
                    zeroRecords:    "Não foram encontrados resultados",
                    emptyTable:     "Não há dados disponíveis na tabela",
                    paginate: {
                        first:      "«« Primeiro",
                        previous:   "« Anterior",
                        next:       "Seguinte »",
                        last:       "Último »»"
                    }
                }
            });
        });
    </script>
@endsection
