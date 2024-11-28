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
    return view("dashboard.single-buycut");
  }

  public function store(Request $request) {
  }

  public function show(Buycut $buycut) {
    $categories = Category::isBuycutCategory()->get();
    return view("single-buycut", compact("buycut", "categories"));
  }

  public function edit(Buycut $buycut) {
  }

  public function update(Request $request, Buycut $buycut) {
  }

  public function destroy(Buycut $buycut) {
  }
}
