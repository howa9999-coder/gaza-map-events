<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up(): void {
    Schema::create('buycuts', function (Blueprint $table) {
      $table->id();
      $table->string("title");
      $table->text("reason")->nullable();
      $table->text("details")->nullable();
      $table->string("video")->nullable();
      $table->string("logo")->nullable();
      $table->string("images")->nullable();
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('buycuts');
  }
};
