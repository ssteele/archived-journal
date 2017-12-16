@extends('app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Upload</div>

                <div class="panel-body">
                    @include('partials.entry-upload-form')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
