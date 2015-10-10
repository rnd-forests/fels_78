@if($currentUser->isFollowing($user))
    @include('users.profile.partials._unfollow_form')
    <div class="hidden">
        @include('users.profile.partials._follow_form')
    </div>
@else
    @include('users.profile.partials._follow_form')
    <div class="hidden">
        @include('users.profile.partials._unfollow_form')
    </div>
@endif
