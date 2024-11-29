<?php

namespace App\Http\Controllers;

use App\Models\Buycut;
use App\Models\Category;
use Illuminate\Http\Request;

class BuycutController extends Controller {

  public function index() {
    $buycuts = Buycut::paginate(10);
    return view("dashboard.buycuts.index", compact("buycuts"));
  }

  public function create() {
    $categories = Category::isBuycutCategory()->get();
    return view("dashboard.buycuts.single", compact("categories"));
  }

  public function store(Request $request) {
    $request->validate([
      "title" => "required|string|max:120",
      "reason" => "nullable|string",
      "category" => "nullable|exists:categories,id",
      "image" => "required|image|mimes:png,jpg,jpeg|max:2048", // max = 2 mega byte
      "details" => "required",
    ]);

    $info = [];
    $info["user_id"] = auth()->user()->id;
    $info["category_id"] = request("category");
    $info["title"] = request("title");
    $info["reason"] = request("reason");
    $info["details"] = request("details");

    if ($request->hasFile('image')) {
      // upload image
      $info["logo"] = date('mdYHis') . uniqid() . substr($request->file('image')->getClientOriginalName(), -10);
      $request->image->move(public_path('images/buycuts'), $info["logo"]);
    }

    $buycut = Buycut::create($info);

    $request->session()->flash('buycut-saved', boolval($buycut->id));

    return redirect()->route("buycut_edit", $buycut->id);
  }

  public function show(Buycut $buycut) {
    $categories = Category::isBuycutCategory()->get();
    return view("single-buycut", compact("buycut", "categories"));
  }

  public function edit(Buycut $buycut) {
    $categories = Category::isBuycutCategory()->get();
    return view("dashboard.buycuts.single", compact("buycut", "categories"));
  }

  public function update(Request $request, Buycut $buycut) {
    $request->validate([
      "title" => "required|string|max:120",
      "reason" => "nullable|string",
      "details" => "required",
      "category" => "nullable|integer|exists:categories,id",
      "image" => "nullable|image|mimes:png,jpg,jpeg|max:2048", // max = 2 mega byte
    ]);

    $buycut->title = request("title");
    $buycut->details = request("details");

    if (request("reason") != null) {
      $buycut->reason = request("reason");
    }

    if (request("category") != null) {
      $buycut->category()->associate(request("category"));
    }

    if ($request->hasFile('image')) {
      // delete old image
      if ($buycut->image != NULL && File::exists(public_path("images/buycuts/$buycut->image"))) {
        File::delete(public_path("images/buycuts/$buycut->image"));
      }
      // upload new image
      $buycut->logo = date('mdYHis') . uniqid() . substr($request->file('image')->getClientOriginalName(), -10);
      $request->image->move(public_path('images/buycuts'), $buycut->logo);
    }

    $res = $buycut->save();

    $request->session()->flash('buycut-saved', $res);

    return redirect()->route("buycut_edit", $buycut->id);
  }

  public function destroy(Buycut $buycut) {
  }

  public function upload_attachment(Request $request) {
    $validator = Validator::make($request->all(), [
      "file" => "required|image|mimes:png,jpg,jpeg|max:2048", // max = 2 mega byte
    ]);

    if ($validator->fails()) {
      return $validator->errors();
    }

    // create image name
    $image_name = date('mdYHis') . uniqid() . substr($request->file('file')->getClientOriginalName(), -10);
    // upload new image
    $request->file('file')->move(public_path('images/buycuts'), $image_name);

    return url("images/buycuts/$image_name");
  }

}
