<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buycut>
 */
class BuycutFactory extends Factory {

  public function definition(): array {

    $title = $this->faker->sentence(2);

    return [
      "title" => rtrim($title, '.'),
      "reason" => $this->faker->paragraph(),
      "details" => $this->faker->paragraph(3),
    ];
  }
}
