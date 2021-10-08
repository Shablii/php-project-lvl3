@if(Session::has('flash_message'))
    <div class="alert alert-{{ session('flash_message')['class'] }}">
        {{ session('flash_message')['message'] }}
    </div>
@endif

@if(Session::has('errors'))
    <div class="alert alert-danger">
        {{ session('errors') }}
    </div>
@endif

