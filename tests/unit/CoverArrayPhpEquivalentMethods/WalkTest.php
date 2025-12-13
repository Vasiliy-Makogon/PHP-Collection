<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class WalkTest extends TestCase
{
    /**
     * Tests the walk() method with associative array.
     *
     * This test verifies that the walk() method correctly applies
     * a callback function to each element of an associative array,
     * modifying the values in place and returning the same instance,
     * mirroring PHP's array_walk() function behavior.
     *
     *
     * Тестирование метода walk() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод walk() корректно применяет
     * callback-функцию к каждому элементу ассоциативного массива,
     * изменяя значения на месте и возвращая тот же экземпляр,
     * отражая поведение функции array_walk() PHP.
     *
     * @see CoverArray::walk()
     * @see array_walk()
     */
    public function testWalkWithAssociativeArray(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];

        $expected = $data;
        array_walk($expected, function (&$value, $key) {
            $value *= 2;
        });

        $cover = new CoverArray($data);
        $result = $cover->walk(
            function (&$value, $key) {
                $value *= 2;
            }
        );

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the walk() method with numeric indexed array.
     *
     * This test verifies that the walk() method correctly applies
     * a callback function to each element of a numeric indexed array,
     * modifying the values in place, mirroring PHP's array_walk() function.
     *
     *
     * Тестирование метода walk() с числовым индексным массивом.
     *
     * Этот тест проверяет, что метод walk() корректно применяет
     * callback-функцию к каждому элементу числового индексного массива,
     * изменяя значения на месте, отражая функцию array_walk() PHP.
     *
     * @see CoverArray::walk()
     * @see array_walk()
     */
    public function testWalkWithNumericIndexedArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];

        $expected = $data;
        array_walk($expected, function (&$value, $key) {
            $value .= '!';
        });

        $cover = new CoverArray($data);
        $result = $cover->walk(
            function (&$value, $key) {
                $value .= '!';
            }
        );

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the walk() method with callback using both value and key.
     *
     * This test verifies that the walk() method correctly passes
     * both value (by reference) and key to the callback function,
     * mirroring PHP's array_walk() function behavior.
     *
     *
     * Тестирование метода walk() с callback, использующим и значение, и ключ.
     *
     * Этот тест проверяет, что метод walk() корректно передает
     * и значение (по ссылке), и ключ в callback-функцию,
     * отражая поведение функции array_walk() PHP.
     *
     * @see CoverArray::walk()
     * @see array_walk()
     */
    public function testWalkWithCallbackUsingBothValueAndKey(): void
    {
        $data = ['apple' => 'red', 'banana' => 'yellow', 'grape' => 'purple'];

        $expected = $data;
        array_walk($expected, function (&$value, $key) {
            $value = "$key is $value";
        });

        $cover = new CoverArray($data);
        $cover->walk(
            function (&$value, $key) {
                $value = "$key is $value";
            }
        );

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the walk() method with different value types.
     *
     * This test verifies that the walk() method correctly handles
     * arrays containing different types of values, mirroring the
     * behavior of PHP's array_walk() function.
     *
     *
     * Тестирование метода walk() с разными типами значений.
     *
     * Этот тест проверяет, что метод walk() корректно обрабатывает
     * массивы, содержащие разные типы значений, отражая поведение
     * функции array_walk() PHP.
     *
     * @see CoverArray::walk()
     * @see array_walk()
     */
    public function testWalkWithDifferentValueTypes(): void
    {
        $data = [
            'string' => 'hello',
            'integer' => 42,
            'boolean' => true,
            'null' => null,
            'array' => [1, 2, 3]
        ];

        $expected = $data;
        array_walk($expected, function (&$value, $key) {
            if (is_string($value)) {
                $value = strtoupper($value);
            } elseif (is_int($value)) {
                $value = $value * 2;
            } elseif (is_bool($value)) {
                $value = !$value;
            }
            // Остальные типы не изменяем
        });

        $cover = new CoverArray($data);
        $cover->walk(
            function (&$value, $key) {
                if (is_string($value)) {
                    $value = strtoupper($value);
                } elseif (is_int($value)) {
                    $value = $value * 2;
                } elseif (is_bool($value)) {
                    $value = !$value;
                }
                // Остальные типы не изменяем
            }
        );

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the walk() method with object values.
     *
     * This test verifies that the walk() method correctly handles
     * object values, allowing modification of object properties
     * through the callback, mirroring PHP's array_walk() function behavior.
     *
     *
     * Тестирование метода walk() со значениями-объектами.
     *
     * Этот тест проверяет, что метод walk() корректно обрабатывает
     * значения-объекты, позволяя изменять свойства объектов
     * через callback, отражая поведение функции array_walk() PHP.
     *
     * @see CoverArray::walk()
     * @see array_walk()
     */
    public function testWalkWithObjectValues(): void
    {
        // Создаем отдельные объекты для $expected и $cover чтобы избежать двойной модификации
        $object1ForExpected = new \stdClass();
        $object1ForExpected->name = 'Object 1';
        $object1ForExpected->value = 10;

        $object2ForExpected = new \stdClass();
        $object2ForExpected->name = 'Object 2';
        $object2ForExpected->value = 20;

        $object1ForCover = new \stdClass();
        $object1ForCover->name = 'Object 1';
        $object1ForCover->value = 10;

        $object2ForCover = new \stdClass();
        $object2ForCover->name = 'Object 2';
        $object2ForCover->value = 20;

        $expectedData = [
            'obj1' => $object1ForExpected,
            'obj2' => $object2ForExpected,
            'string' => 'test'
        ];

        $coverData = [
            'obj1' => $object1ForCover,
            'obj2' => $object2ForCover,
            'string' => 'test'
        ];

        $expected = $expectedData;
        array_walk($expected, function (&$value, $key) {
            if ($value instanceof \stdClass) {
                $value->value *= 2;
                $value->name = "Modified: {$value->name}";
            } elseif (is_string($value)) {
                $value = strtoupper($value);
            }
        });

        $cover = new CoverArray($coverData);
        $cover->walk(
            function (&$value, $key) {
                if ($value instanceof \stdClass) {
                    $value->value *= 2;
                    $value->name = "Modified: {$value->name}";
                } elseif (is_string($value)) {
                    $value = strtoupper($value);
                }
            }
        );

        // Проверяем, что строки совпадают
        $this->assertSame($expected['string'], $cover->item('string'));

        // Проверяем объекты отдельно
        $this->assertSame($expected['obj1']->name, $cover->item('obj1')->name);
        $this->assertSame($expected['obj1']->value, $cover->item('obj1')->value);
        $this->assertSame($expected['obj2']->name, $cover->item('obj2')->name);
        $this->assertSame($expected['obj2']->value, $cover->item('obj2')->value);
    }

    /**
     * Tests the walk() method with empty array.
     *
     * This test verifies that the walk() method correctly handles
     * empty arrays, doing nothing and returning the same instance,
     * mirroring PHP's array_walk() function behavior.
     *
     *
     * Тестирование метода walk() с пустым массивом.
     *
     * Этот тест проверяет, что метод walk() корректно обрабатывает
     * пустые массивы, ничего не делая и возвращая тот же экземпляр,
     * отражая поведение функции array_walk() PHP.
     *
     * @see CoverArray::walk()
     * @see array_walk()
     */
    public function testWalkWithEmptyArray(): void
    {
        $data = [];

        $expected = $data;
        array_walk($expected, function (&$value, $key) {
            $value = 'modified';
        });

        $cover = new CoverArray($data);
        $original = $cover;

        $result = $cover->walk(
            function (&$value, $key) {
                $value = 'modified';
            }
        );

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame($original, $result);
    }

    /**
     * Tests the walk() method preserves keys.
     *
     * This test verifies that the walk() method preserves
     * the original keys of the array when modifying values,
     * mirroring PHP's array_walk() function behavior.
     *
     *
     * Тестирование метода walk() с сохранением ключей.
     *
     * Этот тест проверяет, что метод walk() сохраняет
     * исходные ключи массива при изменении значений,
     * отражая поведение функции array_walk() PHP.
     *
     * @see CoverArray::walk()
     * @see array_walk()
     */
    public function testWalkPreservesKeys(): void
    {
        $data = ['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3'];

        $expected = $data;
        array_walk($expected, function (&$value, $key) {
            $value = strtoupper($value);
        });

        $expectedKeys = array_keys($expected);

        $cover = new CoverArray($data);
        $cover->walk(
            function (&$value, $key) {
                $value = strtoupper($value);
            }
        );

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame($expectedKeys, array_keys($cover->getDataAsArray()));
    }

    /**
     * Tests the walk() method with chaining.
     *
     * This test verifies that the walk() method allows chaining
     * multiple calls together, as it returns the same instance.
     *
     *
     * Тестирование метода walk() с цепочкой вызовов.
     *
     * Этот тест проверяет, что метод walk() позволяет объединять
     * несколько вызовов в цепочку, так как возвращает тот же экземпляр.
     *
     * @see CoverArray::walk()
     */
    public function testWalkWithChaining(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];

        $expected = $data;
        array_walk($expected, function (&$value, $key) {
            $value *= 2;
        });
        array_walk($expected, function (&$value, $key) {
            $value *= 2;
        });
        array_walk($expected, function (&$value, $key) {
            $value *= 2;
        });

        $cover = new CoverArray($data);
        $cover->walk(
            function (&$value, $key) {
                $value *= 2;
            }
        )->walk(
            function (&$value, $key) {
                $value *= 2;
            }
        )->walk(
            function (&$value, $key) {
                $value *= 2;
            }
        );

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the walk() method with nested arrays (non-recursive).
     *
     * This test verifies that the walk() method only affects
     * the first level of the array, not recursively, mirroring
     * PHP's array_walk() function behavior.
     *
     *
     * Тестирование метода walk() с вложенными массивами (не рекурсивно).
     *
     * Этот тест проверяет, что метод walk() затрагивает только
     * первый уровень массива, а не работает рекурсивно, отражая
     * поведение функции array_walk() PHP.
     *
     * @see CoverArray::walk()
     * @see array_walk()
     */
    public function testWalkWithNestedArraysNonRecursive(): void
    {
        $data = [
            'level1' => ['a' => 1, 'b' => 2],
            'level1_scalar' => 10
        ];

        $expected = $data;
        array_walk($expected, function (&$value, $key) {
            if (is_int($value)) {
                $value *= 2;
            }
        });

        $cover = new CoverArray($data);
        $cover->walk(
            function (&$value, $key) {
                if (is_int($value)) {
                    $value *= 2;
                }
            }
        );

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the walk() method with CoverArray as value.
     *
     * This test verifies that the walk() method correctly handles
     * CoverArray objects as values, allowing modification of the
     * CoverArray object itself through the callback.
     *
     *
     * Тестирование метода walk() со значением типа CoverArray.
     *
     * Этот тест проверяет, что метод walk() корректно обрабатывает
     * объекты CoverArray как значения, позволяя изменять сам
     * объект CoverArray через callback.
     *
     * @see CoverArray::walk()
     * @see array_walk()
     */
    public function testWalkWithCoverArrayValue(): void
    {
        $innerCover = new CoverArray(['x' => 1, 'y' => 2]);

        $data = [
            'outer' => 'test',
            'inner' => $innerCover
        ];

        // Создаем копию данных для array_walk (с обычным массивом вместо CoverArray)
        $expectedData = [
            'outer' => 'test',
            'inner' => ['x' => 1, 'y' => 2]
        ];

        $expected = $expectedData;
        array_walk($expected, function (&$value, $key) {
            if (is_string($value)) {
                $value = strtoupper($value);
            }
        });

        $cover = new CoverArray($data);
        $cover->walk(
            function (&$value, $key) {
                if ($value instanceof CoverArray) {
                    // Изменяем внутренний CoverArray
                    $value->walk(function (&$innerValue, $innerKey) {
                        $innerValue *= 10;
                    });
                } else {
                    $value = strtoupper($value);
                }
            }
        );

        // Проверяем, что внешняя строка преобразована
        $this->assertSame($expected['outer'], $cover->item('outer'));

        // Проверяем, что внутренний CoverArray был изменен
        // (не сравниваем с $expected['inner'], так как это разные типы)
        $this->assertSame(['x' => 10, 'y' => 20], $cover->item('inner')->getDataAsArray());
    }
}