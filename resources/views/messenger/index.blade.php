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
                @if (Session::has('error_message'))
                    <div class="alert alert-danger" role="alert">
                        {!! Session::get('error_message') !!}
                    </div>
                @endif
                @if($threads->count() > 0)
                    @foreach($threads as $thread)
                    <?php $class = $thread->isUnread($currentUserId) ? 'alert-info' : ''; ?>
                    <div class="alert {!! $class !!}">
                        <h4>{!! link_to('messages/' . $thread->id, $thread->subject) !!}</h4>
                        <p>{!! $thread->latestMessage->body !!}</p>
                        <p><small><strong>Criador:</strong> {!! $thread->creator()->username !!}</small></p>
                        <p><small><strong>Participants:</strong> @{!! $thread->participantsString(Auth::id()) !!}</small></p>
                    </div>
                    @endforeach
                @else
                    <p>Desculpe, no threads.</p>
                @endif
            </div><!-- /.box-body -->
            <div class="box-footer">
              Footer
            </div><!-- /.box-footer-->
          </div><!-- /.box -->
@stop
