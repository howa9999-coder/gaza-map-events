<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
  public function index() {
    $users = User::paginate(10);
    return view("dashboard.users.index", compact("users"));
  }

  public function create() {
    return view('dashboard.users.single');
  }

  public function store(Request $request) {
    $request->validate([
      "name" => "nullable|string|max:30",
      "email" => "required|email|unique:users,email",
      "password" => "required|string|min:3|max:30",
      "image" => "nullable|image|mimes:png,jpg,jpeg|max:2048", // max = 2 mega byte
    ]);

    $info = [
      "email" => request('email'),
      "name" => request('name'),
      "password" => \Hash::make(request('password')),
    ];

    if ($request->hasFile('image')) {
      // upload image
      $info["image"] = date('mdYHis') . uniqid() . substr($request->file('image')->getClientOriginalName(), -10);
      $request->image->move(public_path('images/users'), $info["image"]);
    }

    // save session trigger
    $res = User::create($info);
    $request->session()->flash('user-saved', $res);
    return redirect()->route("users_manage");
  }

  public function edit(User $user) {

    return view('dashboard.users.single', compact(["user"]));
  }

  public function update(Request $request, User $user) {
    $request->validate([
      "name" => "nullable|string|max:30",
      "email" => "required|email|unique:users,email," . $user->id,
      "password" => "nullable|string|min:3|max:30",
      "image" => "nullable|image|mimes:png,jpg,jpeg|max:2048", // max = 2 mega byte
    ]);

    $user->email = request('email');

    if (request("name") != null) {
      $user->name = request('name');
    }
    if (request("password") != null) {
      $user->password = \Hash::make(request('password'));
    }

    if ($request->hasFile('image')) {
      // delete old image
      if ($user->image != NULL && File::exists(public_path("images/users/$user->image"))) {
        File::delete(public_path("images/users/$user->image"));
      }
      // upload new image
      $user->image = date('mdYHis') . uniqid() . substr($request->file('image')->getClientOriginalName(), -10);
      $request->image->move(public_path('images/users'), $user->image);
    }

    // save session trigger
    $res = $user->save();
    $request->session()->flash('user-saved', $res);
    return redirect()->route("users_manage");
  }

  public function destroy(Request $request, User $user) {
    $res = $user->delete();
    $request->session()->flash('user-deleted', $res);
    return redirect()->route("users_manage");
  }
}
