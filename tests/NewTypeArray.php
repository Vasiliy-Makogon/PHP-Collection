<?php

declare(strict_types=1);

namespace Krugozor\Cover\Tests;
use Krugozor\Cover\CoverArray;

/**
 * A new data type inheriting from class CoverArray
 *
 * Это пример класса, расширяющего CoverArray. Он не обязателен, но используется как пример,
 * демонстрирующий, что все элементы типа array, переданные в объектный массив посредством конструктора или set-методов,
 * будут становиться объектами текущего типа, т.е. NewTypeArray extends CoverArray
 */
class NewTypeArray extends CoverArray
{

}