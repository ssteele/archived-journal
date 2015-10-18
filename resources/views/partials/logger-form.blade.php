{{-- {!! Form::model($data['dashboard'], ['class' => '', 'files' => true, 'method' => 'PATCH']) !!} --}}
{!! Form::open( ['url' => '/'] ) !!}

    <fieldset data-tabs="false">

        <div class="form-group">

            {!! Form::label( 'entry_date', 'Date' ) !!}
            {{-- {!! Form::input( 'date', 'entry_date', date( 'Y-m-d' ), ['class' => 'form-control'] ) !!} --}}
            {!! Form::select( 'entry_date', array('L' => 'Large', 'S' => 'Small'), ['class' => 'form-control'] ) !!}

        </div>

        <div class="form-group">

            {!! Form::label( 'display_speed', 'Tempo', ['class' => 'control-label'] ) !!}

            <div class="input-group">

                {!! Form::input( 'number', 'display_speed', null, ['class' => 'form-control', 'min' => 0, 'step' => 1] ) !!}
                <span class="input-group-addon">Standard Units</span>

            </div>

        </div>

        <div class="form-group">

            {!! Form::label( 'title', 'Entry', ['class' => 'control-label'] ) !!}
            {!! Form::textarea( 'title', null, ['class' => 'form-control'] ) !!}

        </div>

    </fieldset>

{!! Form::close() !!}
