<?php
// Пример работы методов трейта Simple
require_once dirname(dirname(__FILE__)) . '/src/Simple.php';
require_once dirname(dirname(__FILE__)) . '/src/CoverArray.php';

use Krugozor\Cover\CoverArray;

class NewType extends CoverArray
{}

$data = [
    'name' => 'Vasiliy',
    'age' => 35,
    'langs' => [
        'backend' => ['php'],
        'frontend' => ['js', 'html']
    ]
];

$cover = new NewType($data);
var_dump($cover);

$cover->address = 'Moscow, Russian Federation';
var_dump($cover->address);

if (isset($cover->address)) {
    unset($cover->address);
    var_dump($cover->address);
}

$cover->setData(['gender' => 'Male', 'height' => 180, 'weight' => 85]);
var_dump($cover);

var_dump($cover->langs->backend->item(0));

var_dump($cover->langs->frontend);

$cover->langs->frontend->clear();
var_dump($cover->langs->frontend);