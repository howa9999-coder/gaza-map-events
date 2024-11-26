<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Rate;

class Comment extends Model {
  //

  public $fillable = [
    "article_id",
    "user_id",
    "text",
    "reply_on",
  ];

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function replys() {
    return $this->hasMany(self::class, "reply_on", "id");
  }

  public function likes() {
    return $this->hasMany(Rate::class)->where("up", true);
  }

  public function dislikes() {
    return $this->hasMany(Rate::class)->where("down", true);
  }
}
