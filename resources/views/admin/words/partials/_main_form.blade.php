<div class="form-group">
    {!! Form::label('word[content]', 'Content', ['class' => 'control-label']) !!}
    {!! Form::text('word[content]', null, ['class' => 'form-control', 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('category', 'Category', ['class' => 'control-label']) !!}
    {!! Form::select('category', $categories, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('word[level]', 'Difficulty Level', ['class' => 'control-label']) !!}
    {!! Form::select('word[level]', \FELS\Entities\Word::getLevels(), null, ['class' => 'form-control']) !!}
</div>
<div class="alert alert-info form-helper">
    {{ trans('word.form.helper') }}
</div>
<div class="word-answers">
    <div class="form-group">
        <button type="button" class="btn btn-default answer--addition">
            <i class="fa fa-plus"></i>
        </button>
    </div>
    <div class="answer">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon">
                    <a class="answer--removal">
                        <i class="fa fa-times text-danger"></i>
                    </a>
                </div>
                {!! Form::text('word[answers][0][solution]', null, ['class' => 'form-control', 'required']) !!}
                <div class="input-group-addon answer--correctness">
                    {!! Form::hidden('word[answers][0][correct]', 0) !!}
                    {!! Form::checkbox('word[answers][0][correct]') !!}
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::submitBtn('Save') !!}
