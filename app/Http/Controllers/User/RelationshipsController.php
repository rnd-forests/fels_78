<?php

namespace FELS\Http\Controllers\User;

use Illuminate\Http\Request;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class RelationshipsController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
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
        $this->users->createRelationship($request->get('followed_id'), auth()->user());
    }

    /**
     * Unfollow a user.
     *
     * @param $id
     */
    public function destroy($id)
    {
        $this->users->destroyRelationship($id, auth()->user());
    }
}
