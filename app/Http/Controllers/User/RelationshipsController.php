<?php

namespace FELS\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class RelationshipsController extends Controller
{
    protected $auth;
    protected $users;

    public function __construct(Guard $auth, UserRepository $users)
    {
        $this->auth = $auth;
        $this->users = $users;
        $this->middleware('auth');
    }

    /**
     * Follow a user.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->users->createRelationship(
            $request->get('followed_id'),
            $this->auth->user()
        );
    }

    /**
     * Unfollow a user.
     *
     * @param $id
     */
    public function destroy($id)
    {
        $this->users->destroyRelationship(
            $id, $this->auth->user()
        );
    }

    /**
     * Get the list of users that current user are following.
     *
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function following($slug)
    {
        $user = $this->users->findBySlug($slug);
        $followings = $user->following()->paginate(20);

        return view('users.follows.following', compact('user', 'followings'));
    }

    /**
     * Get the list of users that are following current user.
     *
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function followers($slug)
    {
        $user = $this->users->findBySlug($slug);
        $followers = $user->followers()->paginate(20);

        return view('users.follows.followers', compact('user', 'followers'));
    }
}
