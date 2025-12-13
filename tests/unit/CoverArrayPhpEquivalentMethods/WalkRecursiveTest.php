<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class WalkRecursiveTest extends TestCase
{
    /**
     * Tests the walkRecursive() method with flat array.
     *
     * This test verifies that the walkRecursive() method correctly applies
     * a callback to all leaf nodes in a flat array, modifying values in place.
     *
     *
     * Тестирование метода walkRecursive() с плоским массивом.
     *
     * Этот тест проверяет, что метод walkRecursive() корректно применяет
     * callback ко всем конечным узлам в плоском массиве, изменяя значения на месте.
     *
     * @see CoverArray::walkRecursive()
     */
    public function testWalkRecursiveWithFlatArray(): void
    {
        $data = [1, 2, 3, 4, 5];

        $cover = new CoverArray($data);
        $result = $cover->walkRecursive(function (&$value, $key) {
            $value *= 2;
        });

        // Check that values were modified
        // Проверяем, что значения были изменены
        $expected = [2, 4, 6, 8, 10];
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns the same instance for method chaining
        // Проверяем, что метод возвращает тот же экземпляр для цепочек вызовов
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the walkRecursive() method with nested arrays.
     *
     * This test verifies that the walkRecursive() method correctly applies
     * a callback to all leaf nodes in nested arrays and converts nested
     * arrays to CoverArray instances.
     *
     *
     * Тестирование метода walkRecursive() с вложенными массивами.
     *
     * Этот тест проверяет, что метод walkRecursive() корректно применяет
     * callback ко всем конечным узлам во вложенных массивах и преобразует
     * вложенные массивы в экземпляры CoverArray.
     *
     * @see CoverArray::walkRecursive()
     */
    public function testWalkRecursiveWithNestedArrays(): void
    {
        $data = [
            'a' => 1,
            'b' => [2, 3],
            'c' => [
                'd' => 4,
                'e' => [5, 6]
            ]
        ];

        $cover = new CoverArray($data);
        $cover->walkRecursive(function (&$value, $key) {
            if (is_int($value)) {
                $value *= 10;
            }
        });

        // Check that values were modified
        // Проверяем, что значения были изменены
        $expected = [
            'a' => 10,
            'b' => [20, 30],
            'c' => [
                'd' => 40,
                'e' => [50, 60]
            ]
        ];

        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that nested arrays are now CoverArray instances
        // Проверяем, что вложенные массивы теперь экземпляры CoverArray
        $this->assertInstanceOf(CoverArray::class, $cover['b']);
        $this->assertInstanceOf(CoverArray::class, $cover['c']);
        $this->assertInstanceOf(CoverArray::class, $cover['c']['e']);
    }

    /**
     * Tests the walkRecursive() method with associative keys.
     *
     * This test verifies that the walkRecursive() method correctly passes
     * keys to the callback function for both associative and indexed arrays.
     *
     *
     * Тестирование метода walkRecursive() с ассоциативными ключами.
     *
     * Этот тест проверяет, что метод walkRecursive() корректно передает
     * ключи в callback-функцию для как ассоциативных, так и индексированных массивов.
     *
     * @see CoverArray::walkRecursive()
     */
    public function testWalkRecursiveWithAssociativeKeys(): void
    {
        $data = [
            'name' => 'John',
            'details' => [
                'age' => 30,
                'city' => 'New York'
            ],
            'scores' => [95, 88, 92]
        ];

        $collectedKeys = [];
        $collectedValues = [];

        $cover = new CoverArray($data);
        $cover->walkRecursive(function (&$value, $key) use (&$collectedKeys, &$collectedValues) {
            $collectedKeys[] = $key;
            $collectedValues[] = $value;

            if (is_int($value)) {
                $value++;
            } elseif (is_string($value)) {
                $value = strtoupper($value);
            }
        });

        // Check that all keys were collected
        // Проверяем, что все ключи были собраны
        $expectedKeys = ['name', 'age', 'city', 0, 1, 2];
        $this->assertSame($expectedKeys, $collectedKeys);

        // Check that values were modified
        // Проверяем, что значения были изменены
        $this->assertSame('JOHN', $cover['name']);
        $this->assertSame(31, $cover['details']['age']);
        $this->assertSame('NEW YORK', $cover['details']['city']);
        $this->assertSame([96, 89, 93], $cover['scores']->getDataAsArray());
    }

    /**
     * Tests the walkRecursive() method with mixed data types.
     *
     * This test verifies that the walkRecursive() method correctly handles
     * different data types including strings, integers, floats, booleans,
     * null, and objects.
     *
     *
     * Тестирование метода walkRecursive() со смешанными типами данных.
     *
     * Этот тест проверяет, что метод walkRecursive() корректно обрабатывает
     * различные типы данных включая строки, целые числа, числа с плавающей точкой,
     * булевы значения, null и объекты.
     *
     * @see CoverArray::walkRecursive()
     */
    public function testWalkRecursiveWithMixedDataTypes(): void
    {
        $stdClass = new \stdClass();
        $stdClass->property = 'value';

        $data = [
            'string' => 'hello',
            'int' => 42,
            'float' => 3.14,
            'bool' => true,
            'null' => null,
            'object' => $stdClass,
            'array' => [1, 'two', false]
        ];

        $cover = new CoverArray($data);

        $cover->walkRecursive(function (&$value, $key) {
            if (is_string($value)) {
                $value .= '_modified';
            } elseif (is_int($value) || is_float($value)) {
                $value *= 2;
            } elseif (is_bool($value)) {
                $value = !$value;
            }
        });

        // Check that appropriate values were modified
        // Проверяем, что соответствующие значения были изменены
        $this->assertSame('hello_modified', $cover['string']);
        $this->assertSame(84, $cover['int']);
        $this->assertSame(6.28, $cover['float']);
        $this->assertSame(false, $cover['bool']);
        $this->assertNull($cover['null']);
        $this->assertSame($stdClass, $cover['object']); // Object should remain unchanged
        $this->assertSame([2, 'two_modified', true], $cover['array']->getDataAsArray());
    }

    /**
     * Tests the walkRecursive() method with deep nesting.
     *
     * This test verifies that the walkRecursive() method correctly handles
     * deeply nested arrays and converts all of them to CoverArray instances.
     *
     *
     * Тестирование метода walkRecursive() с глубокой вложенностью.
     *
     * Этот тест проверяет, что метод walkRecursive() корректно обрабатывает
     * глубоко вложенные массивы и преобразует их все в экземпляры CoverArray.
     *
     * @see CoverArray::walkRecursive()
     */
    public function testWalkRecursiveWithDeepNesting(): void
    {
        $data = [
            'level1' => [
                'level2' => [
                    'level3' => [
                        'level4' => [
                            'value' => 42
                        ]
                    ]
                ]
            ]
        ];

        $cover = new CoverArray($data);

        $cover->walkRecursive(function (&$value, $key) {
            if (is_int($value)) {
                $value = 'processed_' . $value;
            }
        });

        // Check that value was processed
        // Проверяем, что значение было обработано
        $this->assertSame('processed_42', $cover['level1']['level2']['level3']['level4']['value']);

        // Check that all nested arrays are now CoverArray instances
        // Проверяем, что все вложенные массивы теперь экземпляры CoverArray
        $this->assertInstanceOf(CoverArray::class, $cover['level1']);
        $this->assertInstanceOf(CoverArray::class, $cover['level1']['level2']);
        $this->assertInstanceOf(CoverArray::class, $cover['level1']['level2']['level3']);
        $this->assertInstanceOf(CoverArray::class, $cover['level1']['level2']['level3']['level4']);
    }

    /**
     * Tests the walkRecursive() method with empty arrays.
     *
     * This test verifies that the walkRecursive() method correctly handles
     * empty arrays at various nesting levels.
     *
     *
     * Тестирование метода walkRecursive() с пустыми массивами.
     *
     * Этот тест проверяет, что метод walkRecursive() корректно обрабатывает
     * пустые массивы на различных уровнях вложенности.
     *
     * @see CoverArray::walkRecursive()
     */
    public function testWalkRecursiveWithEmptyArrays(): void
    {
        $data = [
            'empty' => [],
            'nested' => [
                'inner_empty' => [],
                'values' => [1, 2]
            ]
        ];

        $cover = new CoverArray($data);

        $callbackCalled = false;
        $cover->walkRecursive(function (&$value, $key) use (&$callbackCalled) {
            $callbackCalled = true;
            $value *= 2;
        });

        // Callback should only be called for the integer values (1, 2)
        // Callback должен вызываться только для целых чисел (1, 2)
        $this->assertTrue($callbackCalled);

        // Check that empty arrays are now CoverArray instances
        // Проверяем, что пустые массивы теперь экземпляры CoverArray
        $this->assertInstanceOf(CoverArray::class, $cover['empty']);
        $this->assertInstanceOf(CoverArray::class, $cover['nested']['inner_empty']);
        $this->assertInstanceOf(CoverArray::class, $cover['nested']['values']);

        // Check that values were modified
        // Проверяем, что значения были изменены
        $this->assertSame([], $cover['empty']->getDataAsArray());
        $this->assertSame([], $cover['nested']['inner_empty']->getDataAsArray());
        $this->assertSame([2, 4], $cover['nested']['values']->getDataAsArray());
    }

    /**
     * Tests the walkRecursive() method with existing CoverArray instances.
     *
     * This test verifies that the walkRecursive() method correctly handles
     * already existing CoverArray instances within the data structure,
     * calling walkRecursive() on them recursively.
     *
     *
     * Тестирование метода walkRecursive() с существующими экземплярами CoverArray.
     *
     * Этот тест проверяет, что метод walkRecursive() корректно обрабатывает
     * уже существующие экземпляры CoverArray внутри структуры данных,
     * вызывая walkRecursive() на них рекурсивно.
     *
     * @see CoverArray::walkRecursive()
     */
    public function testWalkRecursiveWithExistingCoverArrayInstances(): void
    {
        $innerCover = new CoverArray(['x' => 1, 'y' => 2]);
        $data = [
            'a' => 10,
            'b' => $innerCover,
            'c' => [20, 30]
        ];

        $cover = new CoverArray($data);

        $modificationCount = 0;
        $cover->walkRecursive(function (&$value, $key) use (&$modificationCount) {
            if (is_int($value)) {
                $value += 100;
                $modificationCount++;
            }
        });

        // Check modifications count (should be 5: 10, 1, 2, 20, 30)
        // Проверяем количество изменений (должно быть 5: 10, 1, 2, 20, 30)
        $this->assertSame(5, $modificationCount);

        // Check that values were modified
        // Проверяем, что значения были изменены
        $this->assertSame(110, $cover['a']);
        $this->assertSame(101, $cover['b']['x']);
        $this->assertSame(102, $cover['b']['y']);
        $this->assertSame([120, 130], $cover['c']->getDataAsArray());

        // Check that array 'c' was converted to CoverArray
        // Проверяем, что массив 'c' был преобразован в CoverArray
        $this->assertInstanceOf(CoverArray::class, $cover['c']);
    }

    /**
     * Tests the walkRecursive() method with callable arrays.
     *
     * This test verifies that the walkRecursive() method correctly skips
     * callable arrays (arrays that are valid callables) and does not
     * convert them to CoverArray instances.
     *
     *
     * Тестирование метода walkRecursive() с callable массивами.
     *
     * Этот тест проверяет, что метод walkRecursive() корректно пропускает
     * callable массивы (массивы, которые являются валидными callable) и не
     * преобразует их в экземпляры CoverArray.
     *
     * @see CoverArray::walkRecursive()
     */
    public function testWalkRecursiveWithCallableArrays(): void
    {
        // Create a callable array
        // Создаем callable массив
        $callableArray = [$this, 'dummyTestMethod'];

        $data = [
            'a' => 1,
            'b' => $callableArray, // This should remain as array, not become CoverArray
            'c' => [2, 3]
        ];

        $cover = new CoverArray($data);

        $cover->walkRecursive(function (&$value, $key) {
            if (is_int($value)) {
                $value *= 2;
            }
        });

        // Check that callable array is still an array and callable
        // Проверяем, что callable массив остался массивом и является callable
        $this->assertIsArray($cover['b']);
        $this->assertIsCallable($cover['b']);
        $this->assertSame($callableArray, $cover['b']);

        // Check that non-callable array was converted to CoverArray
        // Проверяем, что не-callable массив был преобразован в CoverArray
        $this->assertInstanceOf(CoverArray::class, $cover['c']);

        // Check values were modified
        // Проверяем, что значения были изменены
        $this->assertSame(2, $cover['a']);
        $this->assertSame([4, 6], $cover['c']->getDataAsArray());
    }

    /**
     * Tests the walkRecursive() method with arrays containing both callable and non-callable arrays.
     *
     * This test specifically covers the code path where arrays are recursively processed
     * and converted to CoverArray instances.
     *
     *
     * Тестирование метода walkRecursive() с массивами, содержащими как callable, так и не-callable массивы.
     *
     * Этот тест специально покрывает путь выполнения кода, где массивы рекурсивно обрабатываются
     * и преобразуются в экземпляры CoverArray.
     *
     * @see CoverArray::walkRecursive()
     */
    public function testWalkRecursiveRecursiveProcessingAndConversion(): void
    {
        // Create a complex structure with nested arrays that should be converted to CoverArray
        // Создаем сложную структуру с вложенными массивами, которые должны быть преобразованы в CoverArray
        $data = [
            'level1' => [
                'array1' => [1, 2, 3], // Should become CoverArray
                'mixed' => [
                    'nested' => [4, 5], // Should become CoverArray
                    'value' => 6
                ]
            ],
            'level2' => [
                'empty' => [] // Empty array should also become CoverArray
            ]
        ];

        $cover = new CoverArray($data);

        $modificationCount = 0;
        $cover->walkRecursive(function (&$value, $key) use (&$modificationCount) {
            if (is_int($value)) {
                $value += 100;
                $modificationCount++;
            }
        });

        // Check that all integer values were modified (1,2,3,4,5,6 = 6 values)
        // Проверяем, что все целочисленные значения были изменены (1,2,3,4,5,6 = 6 значений)
        $this->assertSame(6, $modificationCount);

        // Check that all nested arrays are now CoverArray instances
        // Проверяем, что все вложенные массивы теперь экземпляры CoverArray
        $this->assertInstanceOf(CoverArray::class, $cover['level1']);
        $this->assertInstanceOf(CoverArray::class, $cover['level1']['array1']);
        $this->assertInstanceOf(CoverArray::class, $cover['level1']['mixed']);
        $this->assertInstanceOf(CoverArray::class, $cover['level1']['mixed']['nested']);
        $this->assertInstanceOf(CoverArray::class, $cover['level2']);
        $this->assertInstanceOf(CoverArray::class, $cover['level2']['empty']);

        // Check the actual values
        // Проверяем фактические значения
        $this->assertSame([101, 102, 103], $cover['level1']['array1']->getDataAsArray());
        $this->assertSame([104, 105], $cover['level1']['mixed']['nested']->getDataAsArray());
        $this->assertSame(106, $cover['level1']['mixed']['value']);
        $this->assertSame([], $cover['level2']['empty']->getDataAsArray());
    }

    /**
     * Dummy test method for callable array test.
     *
     * This method is used to create a valid callable array for testing.
     *
     * Вспомогательный тестовый метод для теста callable массива.
     *
     * Этот метод используется для создания валидного callable массива для тестирования.
     *
     * @return string Always returns 'test'
     *                Всегда возвращает 'test'
     */
    public function dummyTestMethod(): string
    {
        return 'test';
    }
}