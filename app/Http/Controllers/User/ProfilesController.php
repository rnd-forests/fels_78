<?php

namespace FELS\Http\Controllers\User;

use FELS\Entities\User;
use Illuminate\Http\Request;
use FELS\Core\Uploader\Avatar\Avatar;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class ProfilesController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;

        $this->middleware('auth.user', ['except' => ['show']]);
    }

    /**
     * Show profile of a user.
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $user = $this->users->loadRelations($user);
        $activityList = $this->users->fetchActivitiesFor($user);

        return view('users.profile.show', compact('user', 'activityList'));
    }

    /**
     * Load form to edit user's profile.
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('users.profile.edit', compact('user'));
    }

    /**
     * Cancel user's account.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->users->softDelete($user);
        flash()->success(trans('user.account.canceled'));

        return redirect()->home();
    }

    /**
     * Perform the process of changing user name.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeName(Request $request, User $user)
    {
        $this->validate($request, config('rules.name'));
        list($oldName, $newName) = [$request->get('old_name'), $request->get('new_name')];
        if ($this->isCorrectNames($oldName, $newName, $user)) {
            return $this->handleUpdateName($user, $newName);
        }
        session()->flash('invalid.name', trans('user.name.invalid'));

        return back();
    }

    /**
     * Check the validity of names. Old name must be the same
     * as current name, and new name must be different from
     * old name.
     *
     * @param $old
     * @param $new
     * @param $user
     * @return bool
     */
    protected function isCorrectNames($old, $new, $user)
    {
        return strcasecmp($old, $user->name) === 0 && strcasecmp($old, $new) !== 0;
    }

    /**
     * Handle the process of updating user name.
     *
     * @param $user
     * @param $newName
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleUpdateName($user, $newName)
    {
        $user->update(['name' => $newName]);
        flash()->success(trans('user.name.valid'));

        return redirect()->route('users.edit', $user);
    }

    /**
     * Perform the process of changing user password.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request, User $user)
    {
        $this->validate($request, config('rules.password'));
        list($oldPassword, $newPassword) = [$request->get('old_pass'), $request->get('new_pass')];
        if ($this->isValidPassword($oldPassword, $user)) {
            return $this->handleUpdatePassword($user, $newPassword);
        }
        session()->flash('invalid.password', trans('user.password.invalid'));

        return back();
    }

    /**
     * Validate the password of a user.
     *
     * @param $password
     * @param $user
     * @return mixed
     */
    protected function isValidPassword($password, $user)
    {
        return app('hash')->check($password, $user->password);
    }

    /**
     * Handle the process of updating user password.
     *
     * @param $user
     * @param $newPassword
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleUpdatePassword($user, $newPassword)
    {
        $user->update(['password' => $newPassword]);
        session()->flash('valid.password', trans('user.password.valid'));

        return back();
    }

    /**
     * Handle the process of updating user avatar.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeAvatar(Request $request, User $user)
    {
        $this->validate($request, config('rules.avatar'));
        (new Avatar($user, $request->file('avatar')))->make();
        flash()->success(trans('user.avatar.updated'));

        return back();
    }
}
