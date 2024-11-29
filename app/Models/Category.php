<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
// use Astrotomic\Translatable\Translatable;

// this line to declare a multilingual model
// class Category extends Model implements TranslatableContract {
class Category extends Model {
  // use Translatable;
  use HasFactory;

  // public $translatedAttributes = ['title', 'description'];
  protected $fillable = [
    'title',
    'description',
    'is_buycut_category'
  ];

  public function articles() {
    return $this->hasMany(Article::class);
  }

  public function buycuts() {
    return $this->hasMany(Buycut::class);
  }

  public function show_date() {
    if ($this->created_at != null) {
      return $this->created_at->format('Y-m-d');
    } else {
      return $this->created_at;
    }
  }

  public function scopeOrdered(Builder $query): void {
    $query->orderBy("order")->orderBy("created_at", "DESC");
  }

  public function scopeMostUsed(Builder $query): void {
    $query->withCount("articles")->orderBy("articles_count");
  }

  public function scopeIsArticleCategory(Builder $query): void {
    $query->where("is_buycut_category", "0");
  }

  public function isArticleCategory() {
    return $this->is_buycut_category == 0;
  }

  public function scopeIsBuycutCategory(Builder $query): void {
    $query->where("is_buycut_category", "1");
  }

  public function get_link() {
    return route("category_show", $this->id);
  }

  public function image_url() {
    if ($this->image) {
      return url("images/categories/$this->image");
    } else {
      return url("images/categories/default-category.svg");
    }
  }
}
