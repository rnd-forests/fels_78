<div class="pull-right">
    <span class="activity--time">
        {{ $parser->timeAgo($activity) }}
    </span>
</div>
<i class="fa fa-2x fa-minus-square text-danger"></i>
<a href="{{ route('user.profile.show', $parser->owner($activity)) }}">
    <strong>{{ $parser->owner($activity)->name }}</strong>
</a>
unfollowed
<a href="{{ route('user.profile.show', $parser->target($activity)) }}">
    <strong>{{ $parser->target($activity)->name }}</strong>
</a>
