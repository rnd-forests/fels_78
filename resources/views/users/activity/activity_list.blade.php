@inject('parser', 'FELS\Services\ActivityParser')
@foreach($activityList as $activity)
    <li class="list-group-item activity item">
        @include("users.activity.types.{$activity->action}")
    </li>
@endforeach
