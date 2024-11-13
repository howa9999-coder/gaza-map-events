<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  private $multilingual = false;

  public function up(): void {
    Schema::create('articles', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id');
      if (!$this->multilingual) {
        $table->string('title');
        $table->text('description')->nullable();
        $table->text('content')->nullable();
      }
      $table->foreignId('category_id')->nullable();
      /* ====== article status table ======
        0 => private (only admins can see it)
        1 => unlisted (anyone has the link of the article can see it)
        2 => public (everybody)
        */
      $table->tinyInteger('status')->default(0);
      $table->string('slug');
      /* ====== comment status table ======
        0 => closed and hidden
        1 => closed but users can see the old comments
        2 => open
        */
      $table->tinyInteger('comment_status')->default(2);
      $table->tinyInteger('order')->nullable();
      $table->string('image')->nullable();
      $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
      $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
      $table->timestamps();
    });
    if ($this->multilingual) {
      $this->translation_fields();
    }
  }

  public function down(): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    Schema::dropIfExists('articles');
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    if ($this->multilingual) {
      $this->translation_down();
    }
  }

  public function translation_fields(): void {
    Schema::create('article_translations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('article_id');
      $table->string('locale')->index();
      $table->string('title');
      $table->string('description')->nullable();
      $table->text('content')->nullable();
      $table->unique(['article_id', 'locale']);
      $table->foreign('article_id')->references('id')->on("articles")->onUpdate('cascade')->onDelete('cascade');
    });
  }

  public function translation_down(): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    Schema::dropIfExists('article_translations');
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
  }
};
