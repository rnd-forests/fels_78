<div class="pull-right">
    <span class="activity--time">
        {{ $parser->timeAgo($activity) }}
    </span>
</div>
<i class="fa fa-2x fa-check-circle text-success"></i>
<a href="{{ route('users.show', $parser->owner($activity)) }}">
    <strong>{{ $parser->owner($activity)->name }}</strong>
</a>
finished
<a href="{{ $parser->url($activity) }}">
    <strong>a lesson</strong>
</a>
on category
<a href="{{ route('categories.show', $parser->target($activity)->category) }}">
    <strong>{{ $parser->target($activity)->category->name }}</strong>
</a>
