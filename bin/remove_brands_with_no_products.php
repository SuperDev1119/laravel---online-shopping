<?php

use App\Models\Brand;
use App\Libraries\ElasticsearchHelper;
use App\Models\ProductFromElasticsearch;

/*
$runtime = new \parallel\Runtime;
$future  = $runtime->run(function(){
  return "World";
});
printf("Hello %s\n", $future->value());

die();
*/

$temp_file = tempnam('storage/logs', 'STATS_');

file_put_contents($temp_file, "BRAND_ID, BRAND_NAME, BRAND_SLUG, TOTAL\n", FILE_APPEND);

$query = Brand::where('in_listing', true);

$max = $query->count();

$nb_removed = 0;
$i = -1;
foreach($query->get() as $brand) {
  $i++;
  echo "\r";
  echo str_pad("[$i/$max] ", 15);
  echo str_pad("ID: {$brand->id} | BRAND: {$brand->slug}", 60);
  echo "\t" . ' | IN_LISTING: ' . ($brand->in_listing ? 1 : 0) .' | IS_TOP: ' . ($brand->is_top ? 1 : 0) . ' | ';

  $query_params = ElasticsearchHelper::buildQuery([
    'brand' => $brand,
    'category' => null,
  ]);

  try {
    $products = ProductFromElasticsearch::all($query_params);
    echo "TOTAL: " . str_pad($products['response']['total']['value'], 5);

    file_put_contents($temp_file, implode(',', [
      $brand->id,
      $brand->name,
      $brand->slug,
      $products['response']['total']['value']
    ]) . "\n", FILE_APPEND);
  } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
    $nb_removed++;
    echo 'TOTAL: 0 | REMOVING: ' . ($brand->delete()) . "\tRemoved: #{$nb_removed} ($brand->name)\n";
  }
}

echo "\n[+] Temp_file is: $temp_file";
