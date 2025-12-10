<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class EachRecursiveTest extends TestCase
{
    /**
     * Tests the eachRecursive() method with multiple nesting levels.
     *
     * This test verifies that the eachRecursive() method correctly applies
     * a callback function to all elements of a multidimensional CoverArray,
     * including deeply nested elements, returning a new instance with
     * transformed values at all nesting levels.
     *
     *
     * Тестирование метода eachRecursive() с несколькими уровнями вложенности.
     *
     * Этот тест проверяет, что метод eachRecursive() корректно применяет
     * callback-функцию ко всем элементам многомерного CoverArray,
     * включая глубоко вложенные элементы, возвращая новый экземпляр с
     * преобразованными значениями на всех уровнях вложенности.
     *
     * @see CoverArray::eachRecursive()
     */
    public function testEachRecursiveWithMultipleNestingLevels(): void
    {
        // Create test data with multiple nesting levels
        // Создаем тестовые данные с несколькими уровнями вложенности
        $testData = [
            'backend' => ['PHP', 'MySql'],
            'frontend' => ['HTML', 'CSS', 'JavaScript'],
            'nested' => [
                'level1' => [
                    'level2' => ['deep1', 'deep2'],
                    'level2_simple' => 'simple_value'
                ],
                'numbers' => [1, 2, 3]
            ],
            'scalar' => 'plain_string'
        ];

        $cover = new CoverArray($testData);

        $expected = [
            'backend' => ['0: PHP', '1: MySql'],
            'frontend' => ['0: HTML', '1: CSS', '2: JavaScript'],
            'nested' => [
                'level1' => [
                    'level2' => ['0: deep1', '1: deep2'],
                    'level2_simple' => 'level2_simple: simple_value'
                ],
                'numbers' => ['0: 1', '1: 2', '2: 3']
            ],
            'scalar' => 'scalar: plain_string'
        ];

        $result = $cover->eachRecursive(
            fn(mixed $value, mixed $key): string => "$key: $value"
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests that eachRecursive() does not modify the original CoverArray.
     *
     * This test verifies that the eachRecursive() method returns a new
     * CoverArray instance without modifying the original object.
     *
     *
     * Тестирование, что eachRecursive() не изменяет исходный CoverArray.
     *
     * Этот тест проверяет, что метод eachRecursive() возвращает новый
     * экземпляр CoverArray без изменения исходного объекта.
     *
     * @see CoverArray::eachRecursive()
     */
    public function testEachRecursiveDoesNotModifyOriginal(): void
    {
        $testData = [
            'backend' => ['PHP', 'MySql'],
            'frontend' => ['HTML', 'CSS', 'JavaScript'],
            'scalar' => 'plain_string'
        ];

        $cover = new CoverArray($testData);

        $result = $cover->eachRecursive(
            fn(mixed $value, mixed $key): string => "$key: $value"
        );

        $this->assertSame($testData, $cover->getDataAsArray());
    }

    /**
     * Tests the eachRecursive() method with numeric transformation.
     *
     * This test verifies that the eachRecursive() method correctly applies
     * numeric transformations to all numeric values in a multidimensional array,
     * leaving non-numeric values unchanged.
     *
     *
     * Тестирование метода eachRecursive() с числовым преобразованием.
     *
     * Этот тест проверяет, что метод eachRecursive() корректно применяет
     * числовые преобразования ко всем числовым значениям в многомерном массиве,
     * оставляя нечисловые значения без изменений.
     *
     * @see CoverArray::eachRecursive()
     */
    public function testEachRecursiveWithNumericTransformation(): void
    {
        $numericData = [
            'a' => 5,
            'b' => [10, 20],
            'c' => [
                'inner' => [1, 2, 3]
            ]
        ];

        $numericCover = new CoverArray($numericData);

        $expected = [
            'a' => 10,
            'b' => [20, 40],
            'c' => [
                'inner' => [2, 4, 6]
            ]
        ];

        $result = $numericCover->eachRecursive(
            function (mixed $value, mixed $key) {
                return is_numeric($value) ? $value * 2 : $value;
            }
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the eachRecursive() method with type-based transformation.
     *
     * This test verifies that the eachRecursive() method correctly applies
     * transformations based on value types, transforming only specific types
     * while leaving others unchanged.
     *
     *
     * Тестирование метода eachRecursive() с преобразованием на основе типов.
     *
     * Этот тест проверяет, что метод eachRecursive() корректно применяет
     * преобразования на основе типов значений, преобразуя только определенные типы
     * и оставляя другие без изменений.
     *
     * @see CoverArray::eachRecursive()
     */
    public function testEachRecursiveWithTypeBasedTransformation(): void
    {
        $mixedData = [
            'str' => 'hello',
            'int' => 42,
            'bool' => true,
            'null' => null,
            'array' => ['nested' => 'world']
        ];

        $mixedCover = new CoverArray($mixedData);

        $expected = [
            'str' => 'HELLO',
            'int' => 42,
            'bool' => true,
            'null' => null,
            'array' => ['nested' => 'WORLD']
        ];

        $result = $mixedCover->eachRecursive(
            function (mixed $value, mixed $key) {
                return is_string($value) ? strtoupper($value) : $value;
            }
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the eachRecursive() method with empty array.
     *
     * This test verifies that the eachRecursive() method correctly handles
     * empty arrays, returning an empty array without errors.
     *
     *
     * Тестирование метода eachRecursive() с пустым массивом.
     *
     * Этот тест проверяет, что метод eachRecursive() корректно обрабатывает
     * пустые массивы, возвращая пустой массив без ошибок.
     *
     * @see CoverArray::eachRecursive()
     */
    public function testEachRecursiveWithEmptyArray(): void
    {
        $emptyCover = new CoverArray([]);

        $result = $emptyCover->eachRecursive(
            fn(mixed $value, mixed $key): string => "$key: $value"
        );

        $this->assertSame([], $result->getDataAsArray());
    }

    /**
     * Tests the eachRecursive() method with single level array.
     *
     * This test verifies that the eachRecursive() method correctly applies
     * transformations to a single level (non-recursive) array.
     *
     *
     * Тестирование метода eachRecursive() с одномерным массивом.
     *
     * Этот тест проверяет, что метод eachRecursive() корректно применяет
     * преобразования к одномерному (нерекурсивному) массиву.
     *
     * @see CoverArray::eachRecursive()
     */
    public function testEachRecursiveWithSingleLevelArray(): void
    {
        $singleLevel = new CoverArray(['a' => 1, 'b' => 2, 'c' => 3]);

        $expected = ['a' => 10, 'b' => 20, 'c' => 30];

        $result = $singleLevel->eachRecursive(
            fn(mixed $value, mixed $key): int => $value * 10
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests that eachRecursive() returns a CoverArray instance.
     *
     * This test verifies that the eachRecursive() method returns a new
     * CoverArray instance rather than a plain array.
     *
     *
     * Тестирование, что eachRecursive() возвращает экземпляр CoverArray.
     *
     * Этот тест проверяет, что метод eachRecursive() возвращает новый
     * экземпляр CoverArray, а не обычный массив.
     *
     * @see CoverArray::eachRecursive()
     */
    public function testEachRecursiveReturnsCoverArrayInstance(): void
    {
        $cover = new CoverArray(['test' => 'value']);

        $result = $cover->eachRecursive(fn($v) => $v);

        $this->assertInstanceOf(CoverArray::class, $result);
    }

    /**
     * Tests the eachRecursive() method with CoverArray as value.
     *
     * This test verifies that the eachRecursive() method correctly handles
     * CoverArray objects as values in the array, applying the callback
     * recursively to their contents as well.
     *
     *
     * Тестирование метода eachRecursive() со значением типа CoverArray.
     *
     * Этот тест проверяет, что метод eachRecursive() корректно обрабатывает
     * объекты CoverArray как значения в массиве, применяя callback
     * рекурсивно к их содержимому.
     *
     * @see CoverArray::eachRecursive()
     */
    public function testEachRecursiveWithCoverArrayValue(): void
    {
        $innerCover = new CoverArray(['x' => 1, 'y' => 2]);

        $data = [
            'outer' => 'test',
            'inner' => $innerCover,
            'another' => ['a' => 3, 'b' => 4]
        ];

        $cover = new CoverArray($data);

        $expected = [
            'outer' => 'outer: test',
            'inner' => ['x' => 'x: 1', 'y' => 'y: 2'],
            'another' => ['a' => 'a: 3', 'b' => 'b: 4']
        ];

        $result = $cover->eachRecursive(
            fn(mixed $value, mixed $key): string => "$key: $value"
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the eachRecursive() method with nested CoverArray objects.
     *
     * This test verifies that the eachRecursive() method correctly handles
     * deeply nested CoverArray objects, applying transformations at all levels.
     *
     *
     * Тестирование метода eachRecursive() с вложенными объектами CoverArray.
     *
     * Этот тест проверяет, что метод eachRecursive() корректно обрабатывает
     * глубоко вложенные объекты CoverArray, применяя преобразования на всех уровнях.
     *
     * @see CoverArray::eachRecursive()
     */
    public function testEachRecursiveWithNestedCoverArrays(): void
    {
        $deepInner = new CoverArray(['deep' => 'value']);
        $inner = new CoverArray(['inner' => $deepInner, 'number' => 5]);

        $data = [
            'top' => $inner,
            'scalar' => 'test'
        ];

        $cover = new CoverArray($data);

        $expected = [
            'top' => [
                'inner' => ['deep' => 'deep: value'],
                'number' => 'number: 5'
            ],
            'scalar' => 'scalar: test'
        ];

        $result = $cover->eachRecursive(
            fn(mixed $value, mixed $key): string => "$key: $value"
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }
}