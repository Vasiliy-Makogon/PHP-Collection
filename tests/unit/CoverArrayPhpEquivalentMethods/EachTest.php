<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class EachTest extends TestCase
{
    /**
     * Tests the each() method with associative array.
     *
     * This test verifies that the each() method correctly applies
     * a callback function to each element of an associative array,
     * passing both the value and key to the callback and returning
     * a new CoverArray with the transformed values.
     *
     *
     * Тестирование метода each() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод each() корректно применяет
     * callback-функцию к каждому элементу ассоциативного массива,
     * передавая и значение, и ключ в callback и возвращая
     * новый CoverArray с преобразованными значениями.
     *
     * @see CoverArray::each()
     */
    public function testEachWithAssociativeArray(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];

        $expected = ['a' => 2, 'b' => 4, 'c' => 6];

        $cover = new CoverArray($data);
        $result = $cover->each(
            fn(mixed $value, mixed $key): int => $value * 2
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the each() method with numeric indexed array.
     *
     * This test verifies that the each() method correctly applies
     * a callback function to each element of a numeric indexed array,
     * passing both the value and index to the callback.
     *
     *
     * Тестирование метода each() с числовым индексным массивом.
     *
     * Этот тест проверяет, что метод each() корректно применяет
     * callback-функцию к каждому элементу числового индексного массива,
     * передавая и значение, и индекс в callback.
     *
     * @see CoverArray::each()
     */
    public function testEachWithNumericIndexedArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];

        $expected = ['apple!', 'banana!', 'cherry!'];

        $cover = new CoverArray($data);
        $result = $cover->each(
            fn(mixed $value, mixed $key): string => $value . '!'
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests that each() does not modify the original CoverArray.
     *
     * This test verifies that the each() method returns a new
     * CoverArray instance without modifying the original object.
     *
     *
     * Тестирование, что each() не изменяет исходный CoverArray.
     *
     * Этот тест проверяет, что метод each() возвращает новый
     * экземпляр CoverArray без изменения исходного объекта.
     *
     * @see CoverArray::each()
     */
    public function testEachDoesNotModifyOriginal(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];

        $cover = new CoverArray($data);
        $result = $cover->each(
            fn(mixed $value, mixed $key): int => $value * 2
        );

        $this->assertSame($data, $cover->getDataAsArray());
        $this->assertNotSame($cover, $result);
    }

    /**
     * Tests the each() method with callback using both value and key.
     *
     * This test verifies that the each() method correctly passes
     * both value and key to the callback function for processing.
     *
     *
     * Тестирование метода each() с callback, использующим и значение, и ключ.
     *
     * Этот тест проверяет, что метод each() корректно передает
     * и значение, и ключ в callback-функцию для обработки.
     *
     * @see CoverArray::each()
     */
    public function testEachWithCallbackUsingBothValueAndKey(): void
    {
        $data = ['apple' => 'red', 'banana' => 'yellow', 'grape' => 'purple'];

        $expected = ['apple' => 'apple is red', 'banana' => 'banana is yellow', 'grape' => 'grape is purple'];

        $cover = new CoverArray($data);
        $result = $cover->each(
            fn(mixed $value, mixed $key): string => "$key is $value"
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the each() method with different value types.
     *
     * This test verifies that the each() method correctly handles
     * arrays containing different types of values (string, integer,
     * boolean, null, array).
     *
     *
     * Тестирование метода each() с разными типами значений.
     *
     * Этот тест проверяет, что метод each() корректно обрабатывает
     * массивы, содержащие разные типы значений (строка, целое число,
     * булево, null, массив).
     *
     * @see CoverArray::each()
     */
    public function testEachWithDifferentValueTypes(): void
    {
        $data = [
            'string' => 'hello',
            'integer' => 42,
            'boolean' => true,
            'null' => null,
            'array' => [1, 2, 3]
        ];

        $expected = [
            'string' => 'HELLO',
            'integer' => 84,
            'boolean' => false,
            'null' => null,
            'array' => [1, 2, 3]
        ];

        $cover = new CoverArray($data);
        $result = $cover->each(
            function (mixed $value, mixed $key) {
                if (is_string($value)) {
                    return strtoupper($value);
                } elseif (is_int($value)) {
                    return $value * 2;
                } elseif (is_bool($value)) {
                    return !$value;
                } else {
                    return $value;
                }
            }
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the each() method with CoverArray as value.
     *
     * This test verifies that the each() method correctly handles
     * CoverArray objects as values, applying the callback to the
     * CoverArray object itself (not recursively).
     *
     *
     * Тестирование метода each() со значением типа CoverArray.
     *
     * Этот тест проверяет, что метод each() корректно обрабатывает
     * объекты CoverArray как значения, применяя callback к самому
     * объекту CoverArray (не рекурсивно).
     *
     * @see CoverArray::each()
     */
    public function testEachWithCoverArrayValue(): void
    {
        $innerCover = new CoverArray(['x' => 1, 'y' => 2]);

        $data = [
            'outer' => 'test',
            'inner' => $innerCover
        ];

        $cover = new CoverArray($data);

        $expected = [
            'outer' => 'OUTER: test',
            'inner' => 'INNER: CoverArray object'
        ];

        $result = $cover->each(
            function (mixed $value, mixed $key) {
                if ($value instanceof CoverArray) {
                    return strtoupper($key) . ': CoverArray object';
                } else {
                    return strtoupper($key) . ': ' . $value;
                }
            }
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the each() method with object values.
     *
     * This test verifies that the each() method correctly handles
     * object values, applying the callback to the object itself.
     *
     *
     * Тестирование метода each() со значениями-объектами.
     *
     * Этот тест проверяет, что метод each() корректно обрабатывает
     * значения-объекты, применяя callback к самому объекту.
     *
     * @see CoverArray::each()
     */
    public function testEachWithObjectValues(): void
    {
        $object1 = new \stdClass();
        $object1->name = 'Object 1';

        $object2 = new \stdClass();
        $object2->name = 'Object 2';

        $data = [
            'obj1' => $object1,
            'obj2' => $object2,
            'string' => 'test'
        ];

        $cover = new CoverArray($data);

        $expected = [
            'obj1' => 'Object 1',
            'obj2' => 'Object 2',
            'string' => 'STRING: test'
        ];

        $result = $cover->each(
            function (mixed $value, mixed $key) {
                if ($value instanceof \stdClass) {
                    return $value->name;
                } else {
                    return strtoupper($key) . ': ' . $value;
                }
            }
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the each() method with empty array.
     *
     * This test verifies that the each() method correctly handles
     * empty arrays, returning an empty array without errors.
     *
     *
     * Тестирование метода each() с пустым массивом.
     *
     * Этот тест проверяет, что метод each() корректно обрабатывает
     * пустые массивы, возвращая пустой массив без ошибок.
     *
     * @see CoverArray::each()
     */
    public function testEachWithEmptyArray(): void
    {
        $cover = new CoverArray([]);

        $result = $cover->each(
            fn(mixed $value, mixed $key): string => "$key: $value"
        );

        $this->assertSame([], $result->getDataAsArray());
    }

    /**
     * Tests that each() returns a CoverArray instance.
     *
     * This test verifies that the each() method returns a new
     * CoverArray instance rather than a plain array.
     *
     *
     * Тестирование, что each() возвращает экземпляр CoverArray.
     *
     * Этот тест проверяет, что метод each() возвращает новый
     * экземпляр CoverArray, а не обычный массив.
     *
     * @see CoverArray::each()
     */
    public function testEachReturnsCoverArrayInstance(): void
    {
        $cover = new CoverArray(['test' => 'value']);

        $result = $cover->each(fn($v) => $v);

        $this->assertInstanceOf(CoverArray::class, $result);
    }

    /**
     * Tests the each() method preserving keys.
     *
     * This test verifies that the each() method preserves
     * the original keys of the array when applying transformations.
     *
     *
     * Тестирование метода each() с сохранением ключей.
     *
     * Этот тест проверяет, что метод each() сохраняет
     * исходные ключи массива при применении преобразований.
     *
     * @see CoverArray::each()
     */
    public function testEachPreservesKeys(): void
    {
        $data = ['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3'];

        $expected = ['key1' => 'VALUE1', 'key2' => 'VALUE2', 'key3' => 'VALUE3'];

        $cover = new CoverArray($data);
        $result = $cover->each(
            fn(mixed $value, mixed $key): string => strtoupper($value)
        );

        $this->assertSame($expected, $result->getDataAsArray());
        $this->assertSame(array_keys($data), array_keys($result->getDataAsArray()));
    }

    /**
     * Tests the each() method with complex transformation.
     *
     * This test verifies that the each() method can handle
     * more complex transformations that depend on both
     * the key and value in non-trivial ways.
     *
     *
     * Тестирование метода each() со сложным преобразованием.
     *
     * Этот тест проверяет, что метод each() может обрабатывать
     * более сложные преобразования, зависящие от ключа и значения
     * нетривиальным образом.
     *
     * @see CoverArray::each()
     */
    public function testEachWithComplexTransformation(): void
    {
        $data = [
            'user_1' => ['name' => 'John', 'age' => 30],
            'user_2' => ['name' => 'Jane', 'age' => 25],
            'user_3' => ['name' => 'Bob', 'age' => 35]
        ];

        $expected = [
            'user_1' => 'John (30 years old)',
            'user_2' => 'Jane (25 years old)',
            'user_3' => 'Bob (35 years old)'
        ];

        $cover = new CoverArray($data);
        $result = $cover->each(
            function (mixed $value, mixed $key) {
                return "{$value['name']} ({$value['age']} years old)";
            }
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }
}