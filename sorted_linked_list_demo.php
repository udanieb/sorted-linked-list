<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\SortedLinkedList;

$list = new SortedLinkedList('int');

$list->insert(5);
$list->insert(1);
$list->insert(3);

echo "List after inserts: " . implode(", ", $list->toArray()) . PHP_EOL;

$list->remove(1);
echo "List after removing 1: " . implode(", ", $list->toArray()) . PHP_EOL;

echo "Contains 5? " . ($list->contains(5) ? "yes" : "no") . PHP_EOL;
echo "Contains 10? " . ($list->contains(10) ? "yes" : "no") . PHP_EOL;

echo "Count: " . count($list) . PHP_EOL;

echo "Iterating: ";
foreach ($list as $val) {
    echo $val . " ";
}
echo PHP_EOL;
