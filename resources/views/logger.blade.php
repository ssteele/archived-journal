@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-heading">Log</div>

                <div class="panel-body">

                    @include('partials.logger-form')
                    @include( 'partials.flash' )

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
