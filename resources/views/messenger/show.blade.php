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
                <div class="col-md-6">
                    <h1>{!! $thread->subject !!}</h1>

                    @foreach($thread->messages as $message)
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img src="//www.gravatar.com/avatar/{!! md5($message->user->email) !!}?s=64" alt="{!! $message->user->name !!}" class="img-circle">
                            </a>
                            <div class="media-body">
                                <h5 class="media-heading">{!! $message->user->name !!}</h5>
                                <p>{!! $message->body !!}</p>
                                <div class="text-muted"><small>Posted {!! $message->created_at->diffForHumans() !!}</small></div>
                            </div>
                        </div>
                    @endforeach

                    <h2>Add a new message</h2>
                    {!! Form::open(['route' => ['messages.update', $thread->id], 'method' => 'PUT']) !!}
                    <!-- Message Form Input -->
                    <div class="form-group">
                        {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
                    </div>

                    @if($users->count() > 0)
                    <div class="checkbox">
                        @foreach($users as $user)
                            <label title="{!! $user->name !!}"><input type="checkbox" name="recipients[]" value="{!! $user->id !!}">{!! $user->name !!}</label>
                        @endforeach
                    </div>
                    @endif

                    <!-- Submit Form Input -->
                    <div class="form-group">
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              Footer
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
@stop
