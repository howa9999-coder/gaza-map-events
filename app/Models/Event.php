<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {


  public $fillable = [
    "title",
    "shapes",
    "type",
    "date",
    "source_id",
    "article_id",
    "title",
  ];
}
