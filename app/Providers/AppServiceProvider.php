<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider {
  /**
   * Register any application services.
   */
  public function register(): void {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void {

    // setting up paginagion type
    Paginator::defaultView('pagination.bootstrap-5');

    // loading data for floating buycut component
    view()->composer("layout.draggable-buycut", function ($view) {
      $view->with("buycuts", \App\Models\Buycut::inRandomOrder()->select(["title", "logo", "id"])->limit(8)->get());
    });
  }
}
