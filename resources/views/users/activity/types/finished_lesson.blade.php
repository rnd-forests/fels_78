<i class="fa fa-2x fa-check-circle activity--icon"></i>
<div class="activity--body">
    <a href="{{ route('users.show', $activity->user) }}" class="activity--user">
        {{ $activity->user->name }}
    </a>
    completed
    <a href="{{ $activity->targetable->url }}" class="activity--target">
        <span class="activity--target__emphasized">{{ $activity->targetable->type }}</span> lesson
    </a>
    in category
    <a href="{{ route('categories.show', $activity->targetable->category) }}" class="activity--extra">
        {{ $activity->targetable->category->name }}
    </a>
</div>
<h5 class="activity--time">{{ humans_time($activity->created_at) }}</h5>
