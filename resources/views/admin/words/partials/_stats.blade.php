<div class="well-w">
    <div class="panel panel-default">
        <div class="panel-body">
            <strong class="text-info">
                {{ plural('WORD', counting($words)) }}
            </strong>
            <div class="pull-right">
                <a href="{{ route('admin.words.create') }}"
                   class="btn btn-primary btn-xs"
                   data-toggle="tooltip"
                   data-placement="bottom"
                   title="Add new word">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
    </div>
    @inject('counter', 'FELS\Services\WordCounter')
    <div class="progress">
        <div class="progress-bar progress-bar-danger progress-bar-striped"
             style="width: {{ $counter->percentageOfHardWords() }}%">
            <span>{{ $counter->percentageOfHardWords() }}%</span>
        </div>
        <div class="progress-bar progress-bar-warning progress-bar-striped"
             style="width: {{ $counter->percentageOfMediumWords() }}%">
            <span>{{ $counter->percentageOfMediumWords() }}%</span>
        </div>
        <div class="progress-bar progress-bar-success progress-bar-striped"
             style="width: {{ $counter->percentageOfEasyWords() }}%">
            <span>{{ $counter->percentageOfEasyWords() }}%</span>
        </div>
    </div>
    <h4 class="text-danger">{{ plural2('Word', 'Hard', $counter->countHardWords()) }}</h4>
    <h4 class="text-warning">{{ plural2('Word', 'Medium', $counter->countMediumWords()) }}</h4>
    <h4 class="text-success">{{ plural2('Word', 'Easy', $counter->countEasyWords()) }}</h4>
</div>
