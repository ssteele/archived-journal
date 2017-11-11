{!! Form::open([
    'action' => 'EntryController@bulk_store',
    'files'  => true,
]) !!}

    <fieldset data-tabs="false">

        <div class="form-group">

            {!! Form::label('csv', 'CSV Upload', ['class' => 'control-label']) !!}
            {!! Form::file('csv'); !!}

        </div>

        <div class="form-group">

            {!! Form::submit('Import', ['class' => 'btn btn-primary form-control']) !!}

        </div>

        @if ($errors->any())

            <ul class="alert alert-danger">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        @endif


    </fieldset>

{!! Form::close() !!}
