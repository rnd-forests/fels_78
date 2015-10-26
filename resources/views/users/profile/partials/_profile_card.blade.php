<div class="thumbnail">
    @include('users.profile.partials._avatar')
    <div class="caption">
        <h3>{{ $user->name }}</h3>
        <ul>
            <li>{{ $user->email }}</li>
            <li>Joined on {{ short_time($user->created_at) }}</li>
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
        @unless(empty($user->google_name))
            <a href="{{ $user->present()->googleUrl($user) }}"
               class="btn btn-social-icon btn-google">
                <i class="fa fa-google"></i>
            </a>
        @endunless
        @unless(empty($user->facebook_name))
            <a href="{{ $user->present()->facebookUrl($user) }}"
               class="btn btn-social-icon btn-facebook">
                <i class="fa fa-facebook"></i>
            </a>
        @endunless
        @unless(empty($user->github_name))
            <a href="{{ $user->present()->githubUrl($user) }}"
               class="btn btn-social-icon btn-github">
                <i class="fa fa-github"></i>
            </a>
        @endunless
    </div>
</div>
