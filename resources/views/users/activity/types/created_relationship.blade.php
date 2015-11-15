<i class="fa fa-2x fa-user-plus activity--icon"></i>
<div class="activity--body">
    <a href="{{ route('users.show', $activity->user) }}" class="activity--user">
        {{ $activity->user->name }}
    </a>
    followed
    <a href="{{ route('users.show', $activity->targetable) }}" class="activity--target">
        {{ $activity->targetable->name }}
    </a>
</div>
<h5 class="activity--time">{{ humans_time($activity->created_at) }}</h5>
