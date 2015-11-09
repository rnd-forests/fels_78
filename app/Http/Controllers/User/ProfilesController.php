<?php

namespace FELS\Http\Controllers\User;

use Illuminate\Http\Request;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class ProfilesController extends Controller
{
    protected $users;

    protected static $nameRules = [
        'old_name' => 'required',
        'new_name' => 'required|different:old_name|alpha_spaces|max:255',
    ];

    protected static $passwordRules = [
        'old_pass' => 'required',
        'new_pass' => 'required|confirmed|min:6',
    ];

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
        $user = $this->users->findBySlugWithRelations($slug);
        $activityList = $user->activities()->latest()->paginate(20);

        return view('users.profile.show', compact('user', 'activityList'));
    }

    /**
     * Load form to edit user's profile.
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
     * Cancel account.
     *
     * @param $userSlug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($userSlug)
    {
        $this->users->softDelete($userSlug);
        flash()->success(trans('user.account.canceled'));

        return redirect()->home();
    }

    /**
     * Perform the process of changing user name.
     *
     * @param $userSlug
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeName(Request $request, $userSlug)
    {
        $this->validate($request, self::$nameRules);
        list($oldName, $newName) = [$request->get('old_name'), $request->get('new_name')];
        $user = $this->users->findBySlug($userSlug);
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
     * @param $userSlug
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request, $userSlug)
    {
        $this->validate($request, self::$passwordRules);
        list($oldPassword, $newPassword) = [$request->get('old_pass'), $request->get('new_pass')];
        $user = $this->users->findBySlug($userSlug);
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
}
