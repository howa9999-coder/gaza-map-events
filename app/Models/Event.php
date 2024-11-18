<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Article;

class Event extends Model {
  use HasFactory;

  public $fillable = [
    "title",
    "shapes",
    "date",
    "type",
    "source_id",
    "article_id",
  ];

  protected $casts = [
    'date' => 'datetime'
  ];

  public function article() {
    return $this->belongsTo(Article::class, "article_id");
  }

  public function shapes_json() {
    return json_decode($this->shapes);
  }
}
