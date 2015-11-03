<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="list-group">
            <div class="list-group-item text-success">
                <strong>{{ $lesson->name }}</strong>
            </div>
            <div class="list-group-item">
                Learned <strong>{{ plural('word', $lesson->learnedWords()->count()) }}</strong>
            </div>
            @foreach($lesson->words->load('answers') as $word)
                <div class="list-group-item">
                    @if($word->isLearned($lesson))
                        <strong class="text-uppercase">
                            {{ $word->content }} <span class="text-success">(LEARNED)</span>
                        </strong>
                    @else
                        <strong class="text-uppercase">{{ $word->content }}</strong>
                    @endif
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
