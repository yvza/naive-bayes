<?php
require 'vendor/autoload.php';

use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Extractors\CSV;
use Rubix\ML\Classifiers;
use League\Csv as LeagueCsv;

$dataset = Labeled::fromIterator(new CSV('./dataset.csv', true));
$testPath = './test.csv';
$test = Labeled::fromIterator(new CSV($testPath, true));

$estimator = new Classifiers\NaiveBayes();
$estimator->train($dataset);

var_dump(collect($dataset->labels())->unique()->values()->toArray(), $estimator->proba($test));
$predictions = $estimator->predict($test);

$csv = LeagueCsv\Reader::createFromPath($testPath, 'r');
$csv->setHeaderOffset(0);

$subject = collect($csv->getHeader())->last();

var_dump($csv->getHeader(), collect($csv->getRecords()));

echo "Keputusan Membeli Laptop: ";
$res = $estimator->proba($test);
if ($res[0]['no'] > $res[0]['yes']) {
    echo "NO \n";
} else {
    echo "YES \n";
}
?>