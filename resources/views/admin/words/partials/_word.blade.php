<div class="pull-right">
    {!! Form::delete('admin.words.destroy', $word, 'delete-word-form') !!}
</div>
<h3 class="word-info pull-left">
    <span class="word-content">{{ $word->content }}</span>
    <i class="fa fa-arrow-circle-down content-toggle"
       data-toggle="collapse"
       data-target="#{{ $word->id }}-word-answers"></i>
</h3>
<div class="clearfix"></div>
<h5><i class="fa fa-folder text-danger"></i> {{ $word->category->name }}</h5>
<h5><small>published at: </small> {{ humans_time($word->created_at) }}</h5>
<div class="collapse" id="{{ $word->id }}-word-answers">
    <div class="collapse-content">
        @include('admin.words.partials._update_word_form')
        <ul class="list-group">
            @foreach($word->answers as $answer)
                <div class="list-group-item">
                    <div class="pull-right">
                        <button class="btn btn-default btn-xs"
                                data-toggle="collapse"
                                data-target="#{{ $answer->id }}-answer-update">
                            <i class="fa fa-pencil"></i>
                        </button>
                        {!! Form::delete('admin.answers.destroy', $answer, 'delete-answer-form') !!}
                    </div>
                    @if($answer->correct)
                        <span class="text-success">
                            <i class="fa fa-check"></i>
                            <strong class="solution">{{ $answer->solution }}</strong>
                        </span>
                    @else
                        <span class="text-danger">
                            <i class="fa fa-times"></i>
                            <strong class="solution">{{ $answer->solution }}</strong>
                        </span>
                    @endif
                    <h6><small>last edited: </small>{{ humans_time($answer->updated_at) }}</h6>
                    @include('admin.words.answers._update_form')
                </div>
            @endforeach
        </ul>
    </div>
</div>
