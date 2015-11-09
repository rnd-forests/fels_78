<div class="pull-right">
    <span class="activity--time">
        {{ $parser->timeAgo($activity) }}
    </span>
</div>
<i class="fa fa-2x fa-play-circle text-info"></i>
<a href="{{ route('user.profile.show', $parser->owner($activity)) }}">
    <strong>{{ $parser->owner($activity)->name }}</strong>
</a>
started
<a href="{{ $parser->url($activity) }}">
    <strong>new lesson</strong>
</a>
on category
<a href="{{ route('categories.show', $parser->target($activity)->category) }}">
    <strong>{{ $parser->target($activity)->category->name }}</strong>
</a>
