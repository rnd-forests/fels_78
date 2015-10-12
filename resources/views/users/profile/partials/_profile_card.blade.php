<div class="thumbnail">
    @include('users.profile.partials._avatar')
    <div class="caption">
        <h3>{{ $user->name }}</h3>
        <ul>
            <li>{{ $user->email }}</li>
            <li>Joined at {{ short_time($user->created_at) }}</li>
        </ul>
        <ul>
            <li>
                <a href="{{ route('user.following.show', $user) }}"
                   class="btn btn-primary">
                    <i class="fa fa-heart"></i>
                    {{ plural('following', counting($user->following)) }}
                </a>
            </li>
            <li>
                <a href="{{ route('user.followers.show', $user) }}"
                   id="followers"
                   class="btn btn-info">
                    <i class="fa fa-heart-o"></i>
                    {{ plural('follower', counting($user->followers)) }}
                </a>
            </li>
        </ul>
    </div>
</div>
