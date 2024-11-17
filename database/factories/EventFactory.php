<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory {

  public function definition(): array {
    $no_event_articles = Article::doesntHave("events")->pluck("id")->toArray();
    // leftJoin("events", "article_id", "=", "articles.id")->whereNull('events.article_id')->select('articles.id')->get();
    return [
      "title" => rtrim($this->faker->sentence(2), '.'),
      "shapes" => '{
        "id": 1,
        "type": "polygon",
        "wfsFile": "2.json",
        "className": "customPop",
        "color": "red",
        "weight": "2",
        "minWidth": "500px",
        "maxWidth": "600px",
        "width": "500px"
      }',
      "type" => $this->faker->randomElement([1, 2]),
      "article_id" => $this->faker->randomElement($no_event_articles),
      "date" => now(),
    ];
  }
}
