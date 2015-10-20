<div class="pull-right">
    <span class="activity-time text-muted">{{ $parser->timeAgo($activity) }}</span>
</div>
<strong>
    <i class="fa fa-2x fa-plus-square text-success"></i>
    <a href="{{ route('user.profile.show', $parser->owner($activity)) }}">
        {{ $parser->owner($activity)->name }}
    </a>
</strong>
<span class="text-muted">is following</span>
<strong>
    <a href="{{ route('user.profile.show', $parser->target($activity)) }}">
        {{ $parser->target($activity)->name }}
    </a>
</strong>
