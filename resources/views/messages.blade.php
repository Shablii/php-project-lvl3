@if($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach($errors->all() as $error)
            <li> {{ $error }} </li>
        @endforeach
        </ul>
    </div>
@endif


@if(Session::has('flash_message'))
    <div class="alert alert-{{ session('flash_message')['class'] }}">
        {{ session('flash_message')['message'] }}
    </div>
@endif
