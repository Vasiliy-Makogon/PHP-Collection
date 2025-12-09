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
     * Tests the eachRecursive() method.
     *
     * This test verifies that the eachRecursive() method correctly applies
     * a callback function to all elements of a multidimensional CoverArray,
     * returning a new instance with transformed values at all nesting levels.
     * The method should not modify the original CoverArray instance.
     *
     *
     * Тестирование метода eachRecursive().
     *
     * Этот тест проверяет, что метод eachRecursive() корректно применяет
     * callback-функцию ко всем элементам многомерного CoverArray,
     * возвращая новый экземпляр с преобразованными значениями на всех уровнях вложенности.
     * Метод не должен изменять исходный экземпляр CoverArray.
     *
     * @see CoverArray::eachRecursive()
     */
    public function testEachRecursiveMethod(): void
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

        // Test 1: Basic recursive transformation with key-value concatenation
        // Тест 1: Базовая рекурсивная трансформация с конкатенацией ключа и значения
        $expected1 = [
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

        $result1 = $cover->eachRecursive(
            fn(mixed $value, mixed $key): string => "$key: $value"
        );

        $this->assertSame(
            $expected1,
            $result1->getDataAsArray()
        );

        // Test 2: Verify original object is not modified
        // Тест 2: Проверяем, что исходный объект не изменен
        $this->assertSame(
            $testData,
            $cover->getDataAsArray(),
            'Original CoverArray should not be modified by eachRecursive()'
        );

        // Test 3: Numeric transformation - multiply all numeric values by 2
        // Тест 3: Числовая трансформация - умножение всех числовых значений на 2
        $numericData = [
            'a' => 5,
            'b' => [10, 20],
            'c' => [
                'inner' => [1, 2, 3]
            ]
        ];

        $numericCover = new CoverArray($numericData);

        $expected3 = [
            'a' => 10,
            'b' => [20, 40],
            'c' => [
                'inner' => [2, 4, 6]
            ]
        ];

        $result3 = $numericCover->eachRecursive(
            function (mixed $value, mixed $key) {
                return is_numeric($value) ? $value * 2 : $value;
            }
        );

        $this->assertSame(
            $expected3,
            $result3->getDataAsArray()
        );

        // Test 4: Type checking - only transform strings
        // Тест 4: Проверка типов - преобразовываем только строки
        $mixedData = [
            'str' => 'hello',
            'int' => 42,
            'bool' => true,
            'null' => null,
            'array' => ['nested' => 'world']
        ];

        $mixedCover = new CoverArray($mixedData);

        $expected4 = [
            'str' => 'HELLO',
            'int' => 42,
            'bool' => true,
            'null' => null,
            'array' => ['nested' => 'WORLD']
        ];

        $result4 = $mixedCover->eachRecursive(
            function (mixed $value, mixed $key) {
                return is_string($value) ? strtoupper($value) : $value;
            }
        );

        $this->assertSame(
            $expected4,
            $result4->getDataAsArray()
        );

        // Test 5: Empty array and edge cases
        // Тест 5: Пустой массив и граничные случаи
        $emptyCover = new CoverArray([]);
        $emptyResult = $emptyCover->eachRecursive(
            fn(mixed $value, mixed $key): string => "$key: $value"
        );

        $this->assertSame(
            [],
            $emptyResult->getDataAsArray()
        );

        // Test 6: Single level array (non-recursive case)
        // Тест 6: Одномерный массив (нерекурсивный случай)
        $singleLevel = new CoverArray(['a' => 1, 'b' => 2, 'c' => 3]);
        $singleResult = $singleLevel->eachRecursive(
            fn(mixed $value, mixed $key): int => $value * 10
        );

        $this->assertSame(
            ['a' => 10, 'b' => 20, 'c' => 30],
            $singleResult->getDataAsArray()
        );

        // Test 7: Verify the method returns a new CoverArray instance, not a plain array
        // Тест 7: Проверяем, что метод возвращает новый экземпляр CoverArray, а не обычный массив
        $this->assertInstanceOf(
            CoverArray::class,
            $cover->eachRecursive(fn($v) => $v),
            'eachRecursive() should return a CoverArray instance'
        );
    }
}