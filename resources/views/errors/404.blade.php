@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('errors.404')]) !!}
@stop

@section('style')
@stop

@section('content')
          <h1>
            {!! Lang::get('errors.404') !!}
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="error-page">
            <h2 class="headline text-orange">{!! Lang::get('errors.404-g') !!}</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-orange"></i> {!! Lang::get('errors.description') !!}</h3>
              <p>
                {!! Lang::get('errors.info') !!}
              </p>
              <form action="{!! URL::to('search') !!}" class='search-form'>
                <div class='input-group'>
                  <input type="text" name="search" class='form-control' placeholder="Search"/>
                  <div class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                  </div>
                </div><!-- /.input-group -->
              </form>
            </div>
          </div><!-- /.error-page -->

        </section><!-- /.content -->
@endsection

@section('scripts')
@endsection