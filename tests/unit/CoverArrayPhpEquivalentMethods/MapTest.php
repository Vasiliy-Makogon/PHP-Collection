<?php

declare(strict_types=1);

namespace Krugozor\Cover\Tests;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\TestCase;

/**
 * Tests the map() method (array_map equivalent).
 *
 * This test verifies that the map() method correctly applies a callback function
 * to the elements of arrays, returning a new array with the results, mirroring
 * PHP's array_map() function behavior with support for both single and multiple
 * input arrays.
 *
 *
 * Тестирование метода map() (эквивалент array_map).
 *
 * Этот тест проверяет, что метод map() корректно применяет callback-функцию
 * к элементам массивов, возвращая новый массив с результатами, отражая
 * поведение функции array_map() PHP с поддержкой как одного, так и нескольких
 * входных массивов.
 *
 * @see CoverArray::map()
 * @see array_map()
 */
class MapTest extends TestCase
{
    /**
     * Test with simple transformation of one array.
     * Тест с простым преобразованием одного массива.
     */
    public function testMapSimpleTransformation(): void
    {
        $data = [1, 2, 3, 4, 5];
        $callback = fn($x) => $x * 2;

        $expected = array_map($callback, $data);

        $cover = new CoverArray($data);
        $result = $cover->map($callback);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Test with multiple arrays and callback.
     * Тест с несколькими массивами и callback.
     */
    public function testMapWithMultipleArrays(): void
    {
        $data1 = [1, 2, 3];
        $data2 = [4, 5, 6];
        $callback = fn($a, $b) => $a + $b;

        $expected = array_map($callback, $data1, $data2);

        $cover = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->map($callback, $data2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->map($callback, new CoverArray($data2))->getDataAsArray()
        );
    }

    /**
     * Test with three arrays.
     * Тест с тремя массивами.
     */
    public function testMapWithThreeArrays(): void
    {
        $data1 = [1, 2, 3];
        $data2 = [4, 5, 6];
        $data3 = [7, 8, 9];
        $callback = fn($a, $b, $c) => $a + $b + $c;

        $expected = array_map($callback, $data1, $data2, $data3);

        $cover = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->map($callback, $data2, $data3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->map($callback, new CoverArray($data2), new CoverArray($data3))->getDataAsArray()
        );
    }

    /**
     * Test with null callback (creates array of arrays/tuples).
     * Тест с null callback (создает массив массивов/кортежей).
     */
    public function testMapWithNullCallback(): void
    {
        $data1 = [1, 2, 3];
        $data2 = ['a', 'b', 'c'];

        $expected = array_map(null, $data1, $data2);

        $cover = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->map(null, $data2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->map(null, new CoverArray($data2))->getDataAsArray()
        );
    }

    /**
     * Test with string function name as callback.
     * Тест с именем функции как callback.
     */
    public function testMapWithStringCallback(): void
    {
        $data = [1, 2, 3, 4];
        $callback = 'strval';

        $expected = array_map($callback, $data);

        $cover = new CoverArray($data);
        $result = $cover->map($callback);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Test with static method as callback.
     * Тест со статическим методом как callback.
     */
    public function testMapWithStaticMethodCallback(): void
    {
        $data = ['hello', 'world'];

        // Define test class with static method
        // Определяем тестовый класс со статическим методом
        $testClass = new class {
            public static function testMethod(string $str): string {
                return strtoupper($str);
            }
        };

        $callback = [$testClass::class, 'testMethod'];
        $expected = array_map($callback, $data);

        $cover = new CoverArray($data);
        $result = $cover->map($callback);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Test with object method as callback.
     * Тест с методом объекта как callback.
     */
    public function testMapWithObjectMethodCallback(): void
    {
        $data = ['hello', 'world'];

        // Create test object with method
        // Создаем тестовый объект с методом
        $testObject = new class {
            public function process(string $str): string {
                return $str . '!';
            }
        };

        $callback = [$testObject, 'process'];
        $expected = array_map($callback, $data);

        $cover = new CoverArray($data);
        $result = $cover->map($callback);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Test with associative array (single array).
     * Тест с ассоциативным массивом (один массив).
     */
    public function testMapWithAssociativeArraySingle(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $callback = fn($x) => $x * 2;

        $expected = array_map($callback, $data);

        $cover = new CoverArray($data);
        $result = $cover->map($callback);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Test with associative arrays (multiple arrays).
     * Тест с ассоциативными массивами (несколько массивов).
     */
    public function testMapWithAssociativeArraysMultiple(): void
    {
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3];
        $data2 = ['x' => 4, 'y' => 5, 'z' => 6];
        $callback = fn($a, $b) => $a + $b;

        $expected = array_map($callback, $data1, $data2);

        $cover = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->map($callback, $data2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->map($callback, new CoverArray($data2))->getDataAsArray()
        );
    }

    /**
     * Test with mixed argument types (array and CoverArray).
     * Тест со смешанными типами аргументов (массив и CoverArray).
     */
    public function testMapWithMixedArgumentTypes(): void
    {
        $data1 = [1, 2, 3];
        $data2 = [4, 5, 6];
        $data3 = [7, 8, 9];
        $callback = fn($a, $b, $c) => $a + $b + $c;

        $expected = array_map($callback, $data1, $data2, $data3);

        $cover = new CoverArray($data1);

        // Mix of array and CoverArray arguments
        // Смесь аргументов массив и CoverArray
        $result = $cover->map($callback, $data2, new CoverArray($data3));

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Test with arrays of different lengths.
     * Тест с массивами разной длины.
     */
    public function testMapWithArraysOfDifferentLengths(): void
    {
        $data1 = [1, 2, 3, 4];
        $data2 = [5, 6];
        $callback = fn($a, $b) => $a + $b;

        $expected = array_map($callback, $data1, $data2);

        $cover = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->map($callback, $data2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->map($callback, new CoverArray($data2))->getDataAsArray()
        );
    }

    /**
     * Test with empty arrays.
     * Тест с пустыми массивами.
     */
    public function testMapWithEmptyArrays(): void
    {
        $data1 = [];
        $data2 = [];
        $callback = fn($a, $b) => $a + $b;

        $expected = array_map($callback, $data1, $data2);

        $cover = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->map($callback, $data2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->map($callback, new CoverArray($data2))->getDataAsArray()
        );
    }

    /**
     * Test with null callback and multiple arrays (creates array of arrays/tuples).
     * Тест с null callback и несколькими массивами (создает массив массивов/кортежей).
     */
    public function testMapWithNullCallbackAndMultipleArrays(): void
    {
        $data1 = [1, 2, 3];
        $data2 = ['a', 'b', 'c'];
        $data3 = [true, false, true];

        $expected = array_map(null, $data1, $data2, $data3);

        $cover = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->map(null, $data2, $data3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->map(null, new CoverArray($data2), new CoverArray($data3))->getDataAsArray()
        );
    }

    /**
     * Test with arrow function using external variables.
     * Тест со стрелочной функцией, использующей внешние переменные.
     */
    public function testMapWithClosureUsingExternalVariables(): void
    {
        $data = [1, 2, 3];
        $multiplier = 3;
        $callback = fn($x) => $x * $multiplier;

        $expected = array_map($callback, $data);

        $cover = new CoverArray($data);
        $result = $cover->map($callback);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Test with callback that returns different types.
     * Тест с callback, который возвращает разные типы.
     */
    public function testMapWithCallbackReturningDifferentTypes(): void
    {
        $data = [1, 2, 3];
        $callback = fn($x) => $x % 2 === 0 ? 'even' : 'odd';

        $expected = array_map($callback, $data);

        $cover = new CoverArray($data);
        $result = $cover->map($callback);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Test with callback that modifies keys (keys should be preserved).
     * Тест с callback, который изменяет ключи (ключи должны сохраняться).
     */
    public function testMapPreservesKeys(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $callback = fn($x) => $x * 10;

        $expected = array_map($callback, $data);

        $cover = new CoverArray($data);
        $result = $cover->map($callback);

        $this->assertSame($expected, $result->getDataAsArray());
        $this->assertSame(['a', 'b', 'c'], array_keys($result->getDataAsArray()));
    }

    /**
     * Test with nested arrays.
     * Тест с вложенными массивами.
     */
    public function testMapWithNestedArrays(): void
    {
        $data = [
            [1, 2],
            [3, 4],
            [5, 6]
        ];

        $callback = function($arr) {
            return array_sum(is_array($arr) ? $arr : $arr->getDataAsArray());
        };

        $expected = array_map($callback, $data);

        $cover = new CoverArray($data);
        $result = $cover->map($callback);

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Test with callback that takes no arguments (should work with single array).
     * Тест с callback, который не принимает аргументов (должен работать с одним массивом).
     */
    public function testMapWithCallbackTakingNoArguments(): void
    {
        $data = [1, 2, 3];

        // Callback that ignores its argument - unusual but valid
        // Callback, игнорирующий свой аргумент - необычно, но допустимо
        $callback = fn() => 42;

        $expected = array_map($callback, $data);

        $cover = new CoverArray($data);
        $result = $cover->map($callback);

        $this->assertSame($expected, $result->getDataAsArray());
    }
}