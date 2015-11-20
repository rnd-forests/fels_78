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
    {{--*/
        $hard = $counter->percentageOfHardWords();
        $medium = $counter->percentageOfMediumWords();
        $easy = $counter->percentageOfEasyWords();
    /*--}}
    <h5 class="text-danger">HARD</h5>
    <div class="progress">
        <div class="progress-bar progress-bar-danger progress-bar-striped"
             style="width: {{ $hard[1] }}%">
            <span>{{ $hard[1] }}% ({{ $hard[0] }})</span>
        </div>
    </div>
    <h5 class="text-warning">MEDIUM</h5>
    <div class="progress">
        <div class="progress-bar progress-bar-warning progress-bar-striped"
             style="width: {{ $medium[1] }}%">
            <span>{{ $medium[1] }}% ({{ $medium[0] }})</span>
        </div>
    </div>
    <h5 class="text-success">EASY</h5>
    <div class="progress">
        <div class="progress-bar progress-bar-success progress-bar-striped"
             style="width: {{ $easy[1] }}%">
            <span>{{ $easy[1] }}% ({{ $easy[0] }})</span>
        </div>
    </div>
</div>
