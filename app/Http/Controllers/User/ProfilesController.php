<?php

namespace FELS\Http\Controllers\User;

use FELS\Http\Controllers\Controller;
use FELS\Http\Requests\UpdateNameRequest;
use FELS\Http\Requests\UpdatePasswordRequest;
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
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $user = $this->users->findBySlug($slug);

        return view('users.profile.show', compact('user'));
    }

    /**
     * Load form to edit profile.
     *
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function edit($slug)
    {
        $user = $this->users->findBySlug($slug);

        return view('users.profile.edit', compact('user'));
    }

    /**
     * Perform the process of changing user name.
     *
     * @param $userSlug
     * @param UpdateNameRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeName(UpdateNameRequest $request, $userSlug)
    {
        $oldName = $request->get('old_name');
        $newName = $request->get('new_name');
        $user = $this->users->findBySlug($userSlug);

        if ($this->isCorrectName($oldName, $user) &&
            $this->areTheDifferentNames($oldName, $newName)
        ) {
            return $this->handleUpdateName($user, $newName);
        }
        session()->flash(
            'invalid.name',
            trans('user.invalid_name')
        );

        return back();
    }

    /**
     * Perform the process of changing user password.
     *
     * @param $userSlug
     * @param UpdatePasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(UpdatePasswordRequest $request, $userSlug)
    {
        $oldPassword = $request->get('old_pass');
        $newPassword = $request->get('new_pass');
        $user = $this->users->findBySlug($userSlug);

        if ($this->isValidPassword($oldPassword, $user)) {
            return $this->handleUpdatePassword($user, $newPassword);
        }
        session()->flash(
            'invalid.password',
            trans('user.invalid_password')
        );

        return back();
    }

    /**
     * Cancel account.
     *
     * @param $userSlug
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($userSlug)
    {
        $this->users->softDelete($userSlug);
        flash()->success(trans('user.account_canceled'));

        return redirect()->home();
    }

    /**
     * Validate the password of a user.
     *
     * @param $password
     * @param $user
     *
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
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleUpdatePassword($user, $newPassword)
    {
        $user->update(['password' => $newPassword]);
        session()->flash(
            'valid.password',
            trans('user.valid_password')
        );

        return back();
    }

    /**
     * Compare current name of a user with a new name.
     *
     * @param $name
     * @param $user
     *
     * @return bool
     */
    protected function isCorrectName($name, $user)
    {
        return strcasecmp($name, $user->name) === 0;
    }

    /**
     * Check the difference between two names.
     *
     * @param $old
     * @param $new
     *
     * @return bool
     */
    protected function areTheDifferentNames($old, $new)
    {
        return strcasecmp($old, $new) !== 0;
    }

    /**
     * Handle the process of updating user name.
     *
     * @param $user
     * @param $newName
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleUpdateName($user, $newName)
    {
        $user->update(['name' => $newName]);
        flash()->success(trans('user.valid_name'));

        return redirect()->route('user.profile.edit', $user);
    }
}
