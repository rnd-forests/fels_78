<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="list-group">
            <div class="list-group-item">
                Lesson name: <strong>{{ $lesson->present()->fullName }}</strong>
            </div>
            <div class="list-group-item">
                Lesson type: <strong>{{ $lesson->type }}</strong>
            </div>
            <div class="list-group-item">
                Lesson size: <strong>{{ plural('word', counting($lesson->words)) }}</strong>
            </div>
            <div class="list-group-item">
                Lesson duration: <strong>{{ plural('second', $lesson->duration / 1000) }}</strong>
            </div>
            <div class="list-group-item">
                Learned: <strong>{{ plural('word', counting($lesson->learnedWords)) }}</strong>
                ({{ percentage(counting($lesson->learnedWords), counting($lesson->words)) }})
            </div>
            <div class="list-group-item">
                Time until completion: <strong>{{ plural('second', $lesson->length) }}</strong>
            </div>
            @foreach($lesson->words->load('answers') as $word)
                <div class="list-group-item">
                    <strong class="text-uppercase">
                        {{ $word->content }}
                        @if($word->isLearned($lesson))
                            (LEARNED)
                        @endif
                    </strong>
                    <ul class="list-unstyled">
                        @foreach($word->answers as $answer)
                            @if($answer->correct)
                                <li class="text-success">
                                    <i class="fa fa-check"></i> {{ $answer->solution }}
                                </li>
                            @elseif($answer->isChosen($lesson, $word))
                                <li class="text-danger">
                                    <i class="fa fa-times"></i> {{ $answer->solution }}
                                    <i class="fa fa-arrow-left"></i> (your choice)
                                </li>
                            @else
                                <li class="text-danger">
                                    <i class="fa fa-times"></i> {{ $answer->solution }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</div>
