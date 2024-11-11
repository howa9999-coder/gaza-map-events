<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  private $multilingual = false;

  public function up() {
    Schema::create('categories', function (Blueprint $table) {
      $table->id();
      if (!$this->multilingual) {
        $table->string('title');
        $table->string('description')->nullable();
      }
      $table->tinyInteger("order")->nullable();
      // $table->string("slug")->nullable();
      $table->boolean("is_product_category")->default(false);
      $table->string("image")->nullable();
      $table->timestamps();
    });
    if ($this->multilingual) {
      $this->translation_fields();
    }
  }

  public function down() {
    Schema::dropIfExists('categories');
    if ($this->multilingual) {
      $this->translation_down();
    }
  }

  public function translation_fields() {
    Schema::create('category_translations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('category_id');
      $table->string('locale')->index();
      $table->string('title');
      $table->string('description')->nullable();

      $table->unique(['category_id', 'locale']);
      $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
    });
  }

  public function translation_down() {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    Schema::dropIfExists('category_translations');
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
  }
};
