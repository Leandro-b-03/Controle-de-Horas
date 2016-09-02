@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('errors.500')]) !!}
@stop

@section('style')
@stop

@section('content')
          <h1>
            {!! Lang::get('errors.500') !!}
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="error-page">
            <h2 class="headline text-orange">{!! Lang::get('errors.500-g') !!}</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-orange"></i> {!! Lang::get('errors.500-description') !!}</h3>
              <p>
                {!! Lang::get('errors.500-info') !!}
              </p>
            </div>
          </div><!-- /.error-page -->

        </section><!-- /.content -->
@endsection

@section('scripts')
@endsection