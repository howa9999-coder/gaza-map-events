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
    $request->validate([]);
    return redirect()->route("categories_manage");
  }

  public function edit(Request $request, Category $category) {
    return view("dashboard.categories.single", compact("category"));
  }

  public function update(Request $request, Category $category) {
    $request->validate([]);
    return redirect()->route("categories_manage");
  }

  public function destroy(Request $request, Category $category) {
    $category->delete();
    return redirect()->route("categories_manage");
  }
}
