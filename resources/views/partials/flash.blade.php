@if (Session::has('flash_tempo'))
    <div class="alert alert-success center">
        <p class="flash-tempo text-center">
            {{ Session::get('flash_tempo') }}
        </p>
    </div>
@endif

@if (Session::has('flash_marker'))
    <div class="alert alert-danger center">
        <p class="flash-marker">
            The following markers were not parsed:<br />
            <ul class="unparsed-markers">
                @foreach (Session::get('flash_marker') as $marker)
                    <li>{{ $marker }}</li>
                @endforeach
            </ul>
        </p>
    </div>
@endif
