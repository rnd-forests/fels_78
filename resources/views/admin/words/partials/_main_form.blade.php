<div class="form-group">
    <div class="form-group">
        {!! Form::label('word', 'Word Content', ['class' => 'control-label']) !!}
        {!! Form::text('word[content]', null, ['class' => 'form-control', 'required']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('category', 'Category', ['class' => 'control-label']) !!}
    {!! Form::select('category', $categories, null, [
        'class' => 'form-control select2-selection']) !!}
</div>
<div class="alert alert-info form-helper" role="alert">
    {{ trans('word.word_form') }}
</div>
<div class="word-answers">
    <div class="form-group">
        <button class="btn btn-primary add-button" type="button">
            <i class="fa fa-plus"></i>
        </button>
    </div>
    @include('admin.words.partials._answer')
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">
        Add <i class="fa fa-arrow-right"></i>
    </button>
</div>
