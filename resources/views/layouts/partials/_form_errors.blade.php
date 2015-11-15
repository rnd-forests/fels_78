@if(count($errors) > 0)
    <div class="alert alert-danger">
        Something went wrong!<br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
