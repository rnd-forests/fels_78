<div class="thumbnail">
    <a href="{{ route('users.show', $user) }}">
        <img class="user--avatar" src="{{ $user->avatar }}" alt="{{ $user->name }}">
    </a>
    <div class="caption">
        <h3>{{ $user->name }}</h3>
        <ul>
            <li>{{ $user->email }}</li>
            <li>Joined on <strong>{{ short_time($user->created_at) }}</strong></li>
        </ul>
        <ul>
            <li>Learned <strong>{{ plural('word', counting($user->words)) }}</strong></li>
            <li>Completed <strong>{{ plural('lesson', $user->lessons()->finished()->count()) }}</strong></li>
            @unless(blank($user->words))
                <li>Ranking <strong>{{ $user->ranking }}</strong></li>
            @endunless
        </ul>
        <ul>
            <li>
                <a href="{{ route('users.following.index', $user) }}" class="btn btn-primary">
                    <i class="fa fa-heart"></i>
                    {{ plural('following', counting($user->following)) }}
                </a>
            </li>
            <li>
                <a href="{{ route('users.followers.index', $user) }}" id="followers" class="btn btn-primary">
                    <i class="fa fa-heart-o"></i>
                    {{ plural('follower', counting($user->followers)) }}
                </a>
            </li>
            <li>
                @unless($user->is($currentUser))
                    @include('users.profile.partials._relationship_form')
                @endunless
            </li>
        </ul>
        @unless(empty($user->google))
            <a href="{{ $user->present()->googleUrl }}" class="btn btn-social-icon btn-google">
                <i class="fa fa-google"></i>
            </a>
        @endunless
        @unless(empty($user->facebook))
            <a href="{{ $user->present()->facebookUrl }}" class="btn btn-social-icon btn-facebook">
                <i class="fa fa-facebook"></i>
            </a>
        @endunless
        @unless(empty($user->github))
            <a href="{{ $user->present()->githubUrl }}" class="btn btn-social-icon btn-github">
                <i class="fa fa-github"></i>
            </a>
        @endunless
    </div>
</div>
