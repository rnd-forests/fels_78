@if(count($errors) > 0)
    <div class="alert alert-danger">
        Please correct the errors in order to submit your form.<br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
