<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up(): void {
    Schema::create('events', function (Blueprint $table) {
      $table->id();
      $table->string("title");
      $table->json("shapes"); // the json file of shapes
      // $table->tinyInteger("type");
      $table->timestamp("date");
      $table->foreignId("source_id")->nullable(); // references sourcs like (aljazera) from sources table
      $table->foreignId("article_id")->nullable()->references("id")->on("articles")->onDelete("cascade");
      $table->timestamps();
    });
  }

  public function down(): void {
    Schema::dropIfExists('events');
  }
};
