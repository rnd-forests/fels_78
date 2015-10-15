<h6 class="text-muted">{{ $parser->timeAgo($activity) }}</h6>
<strong>
    <a href="{{ route('user.profile.show', $parser->owner($activity)) }}">
        {{ $parser->owner($activity)->name }}
    </a>
</strong>
<span class="text-muted">unfollowed</span>
<strong>
    <a href="{{ route('user.profile.show', $parser->target($activity)) }}">
        {{ $parser->target($activity)->name }}
    </a>
</strong>
