@if (Session::has('flash_message'))

    <div class="alert alert-success center">
        <p class="average-tempo text-center">
            {{ Session::get( 'flash_message' ) }}
        </p>
    </div>

@endif
