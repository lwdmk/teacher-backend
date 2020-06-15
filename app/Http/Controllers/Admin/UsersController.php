<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Test\TestAttempt;
use App\Entity\User\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\CreateRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $register;

    public function __construct()
    {
        $this->middleware('can:admin-panel');
    }

    public function index(Request $request)
    {
        $query = User::orderByDesc('id');

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('email'))) {
            $query->where('email', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        if (!empty($value = $request->get('role'))) {
            $query->where('role', $value);
        }

        $users = $query->paginate(20);

        $statuses = [
            User::STATUS_WAIT => 'Waiting',
            User::STATUS_ACTIVE => 'Active',
        ];

        $roles = User::rolesList();
        $grades = User::gradeList();
        $gradeLetters = User::gradeLetterList();

        return view(
            'admin.users.index',
            compact(
                'users',
                'statuses',
                'roles',
                'grades',
                'gradeLetters'
            )
        );
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(CreateRequest $request)
    {
        if ($request->get('role') === User::ROLE_ADMIN) {
            $user = User::new(
                $request['name'],
                $request['email'],
                $request['password']
            );
        } else {
            $user = User::newStudent(
                $request['name'],
                $request['access_code'],
                $request['grade'],
                $request['grade_letter']
            );
        }

        return redirect()->route('admin.users.show', $user);
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * @param UpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->except(['password']));
        if ($request['password'] && $request['password'] !== '') {
            $user->update(['password' => bcrypt($request['password'])]);
        }

        return redirect()->route('admin.users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    public function tests(User $user)
    {
        $attempts = TestAttempt::byUser($user)->paginate(20);

        return view(
            'admin.users.tests',
            compact(
                'attempts'
            )
        );
    }
}
