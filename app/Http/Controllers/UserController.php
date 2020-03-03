<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $users = UserResource::collection(User::all());

        return Inertia::render('Users/Index', [
            "meta"    => [
                "title" => "Users"
            ],
            "users" => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $roles = Role::all();

        return Inertia::render('Users/Edit', [
            'meta' => [
                'title' => 'Creating new user'
            ],
            /*'user' => new UserResource($user),*/
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email",
            "role_id" => "required|integer|in:" . Role::pluck('id')->join(","),
            "password" => "required|min:8|confirmed"
        ]);

        $data["password"] = bcrypt($data["password"]);

        $user = User::create($data);
        return redirect()->route('users.edit', $user->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        return Inertia::render('Users/Edit', [
            'meta' => [
                'title' => 'Editing user ' . $user->name
            ],
            'user' => new UserResource($user),
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email," . $user->id,
            "role_id" => "required|integer|in:" . Role::pluck('id')->join(","),
            "password" => "nullable|min:8|confirmed"
        ]);

        if (isset($data["password"]))
            $data["password"] = bcrypt($data["password"]);

        $user->update($data);
        return back()->with('message', 'User has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('message', "{$user->name} has been deleted.");
    }
}
