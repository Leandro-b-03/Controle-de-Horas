@extends('app')

@section('content')
          <h1>
            Mensagens
            <small>entre em contato.</small>
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
              <h3 class="box-title">Painel Geral</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
                <h1>Create a new message</h1>
                {!! Form::open(['route' => 'messages.store']) !!}
                <div class="col-md-6">
                    <!-- Subject Form Input -->
                    <div class="form-group">
                        {!! Form::label('subject', 'Subject', ['class' => 'control-label']) !!}
                        {!! Form::text('subject', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Message Form Input -->
                    <div class="form-group">
                        {!! Form::label('message', 'Message', ['class' => 'control-label']) !!}
                        {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
                    </div>

                    @if($users->count() > 0)
                    <div class="checkbox">
                        @foreach($users as $user)
                            <label title="{!!$user->name!!}"><input type="checkbox" name="recipients[]" value="{!!$user->id!!}">{!!$user->name!!}</label>
                        @endforeach
                    </div>
                    @endif
                    
                    <!-- Submit Form Input -->
                    <div class="form-group">
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div><!-- /.box-body -->
            <div class="box-footer">
              Footer
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
@stop
