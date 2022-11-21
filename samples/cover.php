<?php
// Пример работы оболочки CoverArray
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
