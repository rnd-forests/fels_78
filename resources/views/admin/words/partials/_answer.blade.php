<div class="answer">
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                <a class="remove-button">
                    <i class="fa fa-times text-danger"></i>
                </a>
            </div>
            {!! Form::text('word[answers][0][solution]', null, ['class' => 'form-control', 'required']) !!}
            <div class="input-group-addon correct">
                {!! Form::hidden('word[answers][0][correct]', 0) !!}
                {!! Form::checkbox('word[answers][0][correct]') !!}
            </div>
        </div>
    </div>
</div>
