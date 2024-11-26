<?php

namespace App\Http\Controllers;

use App\Models\Buycut;
use App\Models\Category;
use Illuminate\Http\Request;

class BuycutController extends Controller {

  public function index() {
    $buycuts = Buycut::all();
    $categories = Category::isBuycutCategory()->get();
    return view("buycut", compact("categories", "buycuts"));
  }

  public function create() {
    //
  }

  public function store(Request $request) {
    //
  }

  public function show(buycut $buycut) {
    $categories = Category::isBuycutCategory()->get();
    return view("single-buycut", compact("buycut", "categories"));
  }

  public function edit(buycut $buycut) {
    //
  }

  public function update(Request $request, buycut $buycut) {
    //
  }

  public function destroy(buycut $buycut) {
    //
  }
}
