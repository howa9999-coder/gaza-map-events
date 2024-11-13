<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Rate;

class Comment extends Model {
  //

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function replys() {
    return $this->belongsTo(Comment::class, "reply_on");
  }

  public function likes() {
    return $this->hasMany(Rate::class)->where("up", true);
  }

  public function dislikes() {
    return $this->hasMany(Rate::class)->where("down", true);
  }
}
