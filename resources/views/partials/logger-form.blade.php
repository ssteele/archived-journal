{!! Form::open( ['action' => 'LoggerController@store'] ) !!}

    <fieldset data-tabs="false">

        <div class="form-group">

            {!! Form::label( 'date', 'Date' ) !!}

            <div class="dropdown-group">

                <select name="date" class="form-control">
                    {!! $dates !!}
                </select>

            </div>

        </div>

        <div class="form-group">

            {!! Form::label( 'tempo', 'Tempo', ['class' => 'control-label'] ) !!}

            <div class="input-group">

                {!! Form::input( 'number', 'tempo', null, ['class' => 'form-control', 'min' => 0, 'step' => 1] ) !!}
                <span class="input-group-addon">Standard Units</span>

            </div>

        </div>

        <div class="form-group">

            {!! Form::label( 'entry', 'Entry', ['class' => 'control-label'] ) !!}
            {!! Form::textarea( 'entry', null, ['class' => 'form-control'] ) !!}

        </div>

        <div class="form-group">

            {!! Form::submit( 'Log', ['class' => 'btn btn-primary form-control'] ) !!}

        </div>

        @if ( $errors->any() )

            <ul class="alert alert-danger">

                @foreach ( $errors->all() as $error )
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        @endif


    </fieldset>

{!! Form::close() !!}
