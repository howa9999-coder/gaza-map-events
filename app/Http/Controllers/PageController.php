<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\Event;

class PageController extends Controller {

  public function home() {
    $latest_articles = Article::orderBy("articles.created_at", "desc")->with("user")->limit(3)->get();
    return view("home", compact("latest_articles"));
  }

  public function articles() {
    $articles = Article::where("status", 2)->orderBy("articles.created_at", "desc")->with("category")->paginate(10);
    $categories = Category::all();
    return view("articles", compact("articles", "categories"));
  }

  public function buycut() {
    $articles = Article::orderBy("articles.created_at", "desc")->paginate(10);
    $categories = Category::all();
    return view("articles", compact("articles", "categories"));
  }

  public function map() {
    $events = Event::with("article")->get();
    // echo ($events->map(fn($event) => $event->shapes_json()));
    // echo ($events->pluck('shapes')->toJson());
    // dd();
    return view("map", compact("events"));
  }
}
