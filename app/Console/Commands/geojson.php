<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class geojson extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'import:geojson';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'extracts the json files of the URLs in config/geoserver.php';

  /**
   * Execute the console command.
   */
  public function handle() {
    if (config("geoserver.URLs") && count(config("geoserver.URLs")) > 0) {
      foreach (config("geoserver.URLs") as $i => $url) {
        $json = Http::get($url);
        file_put_contents('public/geo-data/' . $i + 1 . '.json', $json->body());
      }
    }
  }
}
