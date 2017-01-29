<?php
ini_set('memory_limit','2048M');
require 'vendor/autoload.php';

// Open dict's info, index and data.
$start = time();
echo "{$start}\n";
$info = new skoro\stardict\Info('dict/en_vi.ifo');
var_dump($info);
$index = new skoro\stardict\Index($info);
// var_dump($index);
$dict = new skoro\stardict\Dict($index);
// var_dump($dict);

// Lookup word.
// print $dict->lookup('ведро');
$end = time();
echo "{$end}\n";
echo "Look up for \'text\'\n";
var_dump($dict->lookup('text'));
$end = time();
$gap = $end - $start;
echo "{$gap}\n";
die;