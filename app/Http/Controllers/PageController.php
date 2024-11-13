<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class PageController extends Controller {
  public function articles() {
    $articles = Article::orderBy("articles.created_at", "desc")->with("category")->paginate(10);
    $categories = Category::all();
    return view("articles", compact("articles", "categories"));
  }
}
