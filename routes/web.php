<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

// Debugbar::addMeasure("now", LARAVEL_START, microtime(true));
// Debugbar::measure("My long operation", function () {
//     // Do something…
// Route::view("/", "home");
// });

Route::view("/", "home");
Route::view("/article", "single-article");
Route::view("/articles", "articles");
Route::view("/associations", "associations");

Route::prefix("/dashboard")->middleware("auth")->group(function () {
  Route::view("/", "dashboard")->name("dashboard");
  Route::prefix("/users")->group(function () {
    Route::get("/", [UserController::class, "index"])->name("users_manage");
    Route::get("/create", [UserController::class, "create"])->name("user_create");
    Route::POST("/create", [UserController::class, "store"]);
    Route::get("/{user}", [UserController::class, "edit"])->name("user_edit");
    Route::POST("/{user}", [UserController::class, "update"]);
    Route::DELETE("/{user}", [UserController::class, "destroy"]);
  });
  Route::prefix("/articles")->group(function () {
    Route::get("/", [ArticleController::class, "index"])->name("articles_manage");
    Route::get("/create", [ArticleController::class, "create"])->name("article_create");
    Route::POST("/create", [ArticleController::class, "store"]);
    Route::get("/{article}", [ArticleController::class, "edit"])->name("article_edit");
    Route::POST("/{article}", [ArticleController::class, "update"]);
    Route::DELETE("/{article}", [ArticleController::class, "destroy"]);
    Route::POST('/upload-attachment', [ArticleController::class, 'upload_attachment'])->name("article_attachment");
  });
  Route::prefix("/categories")->group(function () {
    Route::get("/", [CategoryController::class, "index"])->name("categories_manage");
    Route::get("/create", [CategoryController::class, "create"])->name("category_create");
    Route::POST("/create", [CategoryController::class, "store"]);
    Route::get("/{category}", [CategoryController::class, "edit"])->name("category_edit");
    Route::POST("/{category}", [CategoryController::class, "update"]);
    Route::DELETE("/{category}", [CategoryController::class, "destroy"]);
  });
});

Route::middleware("auth")->group(function () {
  Route::get("/profile", [ProfileController::class, "edit"])->name("profile.edit");
  Route::patch("/profile", [ProfileController::class, "update"])->name("profile.update");
  Route::DELETE("/profile", [ProfileController::class, "destroy"])->name("profile.destroy");
});

require __DIR__ . "/auth.php";
