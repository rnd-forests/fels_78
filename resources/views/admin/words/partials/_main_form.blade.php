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
        <button type="button" class="btn btn-default add-button">
            <i class="fa fa-plus"></i>
        </button>
    </div>
    @include('admin.words.partials._answer')
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">
        Save <i class="fa fa-arrow-right"></i>
    </button>
</div>
