<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function show() {
        return Inertia::render('Users/Edit', [
            "meta" => [
                "title" => "Editing settings"
            ],
            "user" => new UserResource(Auth::user()),
            "roles" => Role::all()
        ]);
    }

    public function update(Request $request) {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email," . Auth::id(),
            "current_password" => "required_with:password|password",
            "password" => "nullable|min:8|confirmed"
        ]);

        if (isset($data["password"])) {
            $data["password"] = bcrypt($data["password"]);
            unset($data["current_password"]);
        } else {
            unset($data["password"]);
        }

        Auth::user()->update($data);
        return back()->with('message', "Your settings have been updated!");
    }
}
