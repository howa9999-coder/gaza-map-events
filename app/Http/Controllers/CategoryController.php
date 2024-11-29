<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller {

  public function index() {
    $categories = Category::paginate(10);
    return view("dashboard.categories.index", compact("categories"));
  }

  public function create(Request $request) {
    return view("dashboard.categories.single");
  }

  public function store(Request $request, Category $category) {
    $request->validate([
      "title" => "required|string|max:120",
      "description" => "nullable|string",
      "order" => "nullable|integer|min:0|max:5",
    ]);

    $category = Category::create([
      "title" => request("title"),
      "description" => request("description"),
      "order" => request("order"),
    ]);

    $request->session()->flash('category-saved', boolval($category->id));

    return redirect()->route("category_edit", $category->id);
  }

  public function edit(Request $request, Category $category) {
    return view("dashboard.categories.single", compact("category"));
  }

  public function update(Request $request, Category $category) {
    $request->validate([
      "title" => "required|string|max:120",
      "description" => "nullable|string",
      "order" => "nullable|integer|min:0|max:5",
    ]);

    $category->title = request("title");
    if (request("description") != null) {
      $category->description = request("description");
    }

    if (request("order") != null) {
      $category->order = request("order");
    }

    $category->save();
    $request->session()->flash('category-saved', true);
    return redirect()->route("category_edit", $category->id);
  }

  public function destroy(Request $request, Category $category) {
    $category->delete();
    return redirect()->route("categories_manage");
  }
}
