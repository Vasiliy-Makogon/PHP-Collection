<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods\CoverArrayMagicMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(CoverArray::class)]
class CoverArrayMagicSerializeUnserializeTest extends TestCase
{
    /**
     * Тестирование полного цикла сериализации/десериализации со скалярными значениями.
     *
     * Этот тест проверяет, что объект CoverArray может быть сериализован
     * и десериализован через стандартные PHP-функции с сохранением
     * скалярных значений.
     *
     *
     * Tests complete serialization/deserialization cycle with scalar values.
     *
     * This test verifies that CoverArray objects can be serialized
     * and deserialized through standard PHP functions while preserving
     * scalar values.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testSerializeUnserializeWithScalarValues(): void
    {
        $originalData = [
            'string' => 'value',
            'int' => 42,
            'float' => 3.14,
            'bool_true' => true,
            'bool_false' => false,
            'null' => null,
            'zero' => 0,
            'empty_string' => ''
        ];

        $original = new NewTypeArray($originalData);

        // Используем стандартные PHP-функции
        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized);
        $this->assertInstanceOf(CoverArray::class, $unserialized);

        $this->assertEquals('value', $unserialized->string);
        $this->assertEquals(42, $unserialized->int);
        $this->assertEquals(3.14, $unserialized->float);
        $this->assertTrue($unserialized->bool_true);
        $this->assertFalse($unserialized->bool_false);
        $this->assertNull($unserialized->null);
        $this->assertEquals(0, $unserialized->zero);
        $this->assertEquals('', $unserialized->empty_string);
        $this->assertCount(8, $unserialized);
    }

    /**
     * Тестирование полного цикла сериализации/десериализации с вложенными массивами.
     *
     * Этот тест проверяет, что вложенные массивы правильно преобразуются
     * в объекты CoverArray и обратно при стандартной сериализации PHP.
     *
     *
     * Tests complete serialization/deserialization cycle with nested arrays.
     *
     * This test verifies that nested arrays are correctly converted
     * to CoverArray objects and back during standard PHP serialization.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testSerializeUnserializeWithNestedArrays(): void
    {
        $originalData = [
            'simple' => 'value',
            'nested' => [
                'level1' => [
                    'level2' => [1, 2, 3]
                ]
            ],
            'list' => [1, 2, 3],
            'assoc' => ['a' => 1, 'b' => 2]
        ];

        $original = new NewTypeArray($originalData);

        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized);
        $this->assertInstanceOf(CoverArray::class, $unserialized);

        $this->assertEquals('value', $unserialized->simple);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized->nested);
        $this->assertInstanceOf(CoverArray::class, $unserialized->nested);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized->nested->level1);
        $this->assertInstanceOf(CoverArray::class, $unserialized->nested->level1);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized->nested->level1->level2);
        $this->assertInstanceOf(CoverArray::class, $unserialized->nested->level1->level2);

        $this->assertEquals([1, 2, 3], $unserialized->nested->level1->level2->getDataAsArray());
    }

    /**
     * Тестирование сериализации/десериализации пустого объекта.
     *
     * Этот тест проверяет, что пустой объект CoverArray может быть
     * сериализован и десериализован без потери данных.
     *
     *
     * Tests serialization/deserialization of empty object.
     *
     * This test verifies that an empty CoverArray object can be
     * serialized and deserialized without data loss.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testSerializeUnserializeEmptyObject(): void
    {
        $original = new NewTypeArray();
        $this->assertTrue($original->isEmpty());

        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized);
        $this->assertInstanceOf(CoverArray::class, $unserialized);

        $this->assertTrue($unserialized->isEmpty());
        $this->assertCount(0, $unserialized);
    }

    /**
     * Тестирование согласованности данных после десериализации.
     *
     * Этот тест проверяет, что данные остаются идентичными
     * после полного цикла сериализации и десериализации.
     *
     *
     * Tests data consistency after deserialization.
     *
     * This test verifies that data remains identical
     * after a complete serialization and deserialization cycle.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testDataConsistencyAfterDeserialization(): void
    {
        $data = [
            'scalar' => 'value',
            'array' => [1, 2, 3],
            'nested' => [
                'inner' => ['a', 'b', 'c']
            ],
            'object' => new stdClass()
        ];

        $original = new NewTypeArray($data);

        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        $this->assertEquals(
            $original->getDataAsArray(),
            $unserialized->getDataAsArray()
        );
    }

    /**
     * Тестирование сохранения ссылок на объекты после десериализации.
     *
     * Этот тест проверяет, что ссылки на одни и те же объекты
     * сохраняются после десериализации.
     *
     *
     * Tests preservation of object references after deserialization.
     *
     * This test verifies that references to the same objects
     * are preserved after deserialization.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testObjectReferencesAfterDeserialization(): void
    {
        $sharedObject = new stdClass();
        $sharedObject->id = 42;

        $data = [
            'ref1' => $sharedObject,
            'ref2' => $sharedObject,
            'nested' => [
                'ref3' => $sharedObject
            ]
        ];

        $original = new NewTypeArray($data);

        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        // Проверяем, что все ссылки указывают на один и тот же объект
        $this->assertSame($unserialized->ref1, $unserialized->ref2);
        $this->assertSame($unserialized->ref1, $unserialized->nested->ref3);
    }

    /**
     * Тестирование типа сериализованной строки.
     *
     * Этот тест проверяет, что serialize() возвращает строку,
     * а unserialize() правильно восстанавливает объект.
     *
     *
     * Tests serialized string type.
     *
     * This test verifies that serialize() returns a string,
     * and unserialize() correctly restores the object.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testSerializeReturnsString(): void
    {
        $original = new NewTypeArray(['key' => 'value']);

        $serialized = serialize($original);

        $this->assertIsString($serialized);
        $this->assertEquals('O:33:"Krugozor\Cover\Tests\NewTypeArray":1:{s:3:"key";s:5:"value";}', $serialized);

        $unserialized = unserialize($serialized);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized);
        $this->assertEquals('value', $unserialized->key);
    }

    /**
     * Тестирование сериализации/десериализации с вложенными объектами CoverArray.
     *
     * Проверяет, что вложенные объекты CoverArray правильно сериализуются
     * и десериализуются с сохранением их типа.
     *
     * Tests serialization/deserialization with nested CoverArray objects.
     *
     * Verifies that nested CoverArray objects are properly serialized
     * and deserialized while preserving their type.
     */
    public function testSerializeUnserializeWithNestedCoverArrayObjects(): void
    {
        $originalData = [
            'nested' => new NewTypeArray([
                'inner' => new NewTypeArray(['key' => 'value'])
            ]),
            'mixed' => [
                'cover' => new NewTypeArray(['a' => 1]),
                'array' => ['b' => 2]
            ]
        ];

        $original = new NewTypeArray($originalData);

        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized);

        // Проверяем, что вложенный объект остался NewTypeArray
        $this->assertInstanceOf(NewTypeArray::class, $unserialized->nested);
        $this->assertInstanceOf(NewTypeArray::class, $unserialized->nested->inner);
        $this->assertEquals('value', $unserialized->nested->inner->key);

        // Проверяем смешанную структуру
        $this->assertInstanceOf(NewTypeArray::class, $unserialized->mixed['cover']);
        $this->assertInstanceOf(NewTypeArray::class, $unserialized->mixed['array']);
    }

    /**
     * Тестирование сериализации с глубокой вложенностью.
     *
     * Проверяет обработку глубоко вложенных структур данных.
     *
     * Tests serialization with deep nesting.
     *
     * Verifies handling of deeply nested data structures.
     */
    public function testSerializeUnserializeWithDeepNesting(): void
    {
        // Создаем глубоко вложенную структуру (10 уровней)
        $deepArray = [];
        $current = &$deepArray;

        for ($i = 0; $i < 10; $i++) {
            $current['level' . $i] = ['value' => $i];
            $current = &$current['level' . $i];
        }
        $current['final'] = 'deep_value';

        $original = new NewTypeArray($deepArray);

        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        // Проверяем, что можем пройти по всей цепочке
        $value = $unserialized;
        for ($i = 0; $i < 10; $i++) {
            $this->assertInstanceOf(NewTypeArray::class, $value);
            $value = $value['level' . $i];
        }

        $this->assertEquals('deep_value', $value['final']);
    }

    /**
     * Тестирование сохранения функциональности методов после десериализации.
     *
     * Проверяет, что методы объекта работают корректно после десериализации.
     *
     * Tests preservation of method functionality after deserialization.
     *
     * Verifies that object methods work correctly after deserialization.
     */
    public function testMethodFunctionalityAfterDeserialization(): void
    {
        $original = new NewTypeArray([
            'users' => [
                ['id' => 1, 'name' => 'Alice'],
                ['id' => 2, 'name' => 'Bob'],
                ['id' => 3, 'name' => 'Charlie']
            ]
        ]);

        // Используем метод get с точечной нотацией
        $original->setData(['config' => ['db' => ['host' => 'localhost']]]);

        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        // Проверяем работу метода get с точечной нотацией
        $this->assertEquals('localhost', $unserialized->get('config.db.host'));

        // Проверяем работу других методов
        $this->assertFalse($unserialized->isEmpty());
        $this->assertCount(2, $unserialized);
        $this->assertEquals(
            ['db' => ['host' => 'localhost']],
            $unserialized->get('config')->getDataAsArray()
        );
    }

    /**
     * Тестирование сериализации с числовыми ключами.
     *
     * Проверяет корректную обработку массивов с числовыми индексами.
     *
     * Tests serialization with numeric keys.
     *
     * Verifies correct handling of arrays with numeric indices.
     */
    public function testSerializeUnserializeWithNumericKeys(): void
    {
        $originalData = [
            0 => 'zero',
            1 => 'one',
            5 => 'five', // Пропущенные индексы
            '10' => 'ten_string_key',
            2 => [100, 200, 300]
        ];

        $original = new NewTypeArray($originalData);

        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        $this->assertEquals('zero', $unserialized[0]);
        $this->assertEquals('one', $unserialized[1]);
        $this->assertEquals('five', $unserialized[5]);
        $this->assertEquals('ten_string_key', $unserialized['10']);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized[2]);
        $this->assertEquals(100, $unserialized[2][0]);
    }

    /**
     * Тестирование граничных случаев при сериализации.
     *
     * Проверяет обработку специальных значений и граничных случаев.
     *
     * Tests edge cases in serialization.
     *
     * Verifies handling of special values and edge cases.
     */
    public function testSerializeUnserializeEdgeCases(): void
    {
        $originalData = [
            'empty_array' => [],
            'array_with_empty' => ['', null, []],
            'nested_empty' => [[], [[]]],
            'special_chars' => "Line1\nLine2\tTab",
            'unicode' => 'Привет мир! 🚀',
            'large_number' => PHP_INT_MAX,
            'negative' => -PHP_INT_MAX - 1,
            'float_precision' => 0.1 + 0.2,
            'inf' => INF,
            'nan' => NAN,
            'negative_zero' => -0.0
        ];

        $original = new NewTypeArray($originalData);

        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        // Проверяем специальные случаи
        $this->assertEquals([], $unserialized->empty_array->getDataAsArray());
        $this->assertEquals(['', null, []], $unserialized->array_with_empty->getDataAsArray());
        $this->assertEquals('Привет мир! 🚀', $unserialized->unicode);
        $this->assertEquals(PHP_INT_MAX, $unserialized->large_number);

        // INF и NAN требуют специальной проверки
        $this->assertInfinite($unserialized->inf);
        $this->assertNan($unserialized->nan);

        // Проверяем float (с учетом точности)
        $this->assertEqualsWithDelta(0.3, $unserialized->float_precision, 0.0000001);
    }

    /**
     * Тестирование производительности сериализации больших данных.
     *
     * Проверяет, что сериализация работает с большими объемами данных.
     *
     * Tests serialization performance with large data sets.
     *
     * Verifies that serialization works with large data volumes.
     */
    public function testSerializeUnserializeLargeDataSet(): void
    {
        // Создаем большой массив данных
        $largeData = [];
        for ($i = 0; $i < 1000; $i++) {
            $largeData['key_' . $i] = [
                'id' => $i,
                'name' => 'Item ' . $i,
                'data' => str_repeat('x', 100),
                'nested' => array_fill(0, 10, 'nested_value')
            ];
        }

        $original = new NewTypeArray($largeData);

        $start = microtime(true);
        $serialized = serialize($original);
        $serializeTime = microtime(true) - $start;

        $start = microtime(true);
        $unserialized = unserialize($serialized);
        $unserializeTime = microtime(true) - $start;

        $this->assertInstanceOf(NewTypeArray::class, $unserialized);
        $this->assertCount(1000, $unserialized);

        // Проверяем несколько случайных элементов
        $this->assertEquals('Item 42', $unserialized->key_42['name']);
        $this->assertEquals('Item 999', $unserialized->key_999['name']);
    }

    /**
     * Тестирование отсутствия конфликта с магическими методами __sleep/__wakeup.
     *
     * Проверяет, что реализация __serialize/__unserialize не конфликтует
     * с устаревшими магическими методами.
     *
     * Tests no conflict with __sleep/__wakeup magic methods.
     *
     * Verifies that __serialize/__unserialize implementation doesn't conflict
     * with deprecated magic methods.
     */
    public function testNoSleepWakeupConflict(): void
    {
        $original = new NewTypeArray(['key' => 'value']);

        // Убеждаемся, что объект не имеет метода __sleep
        $this->assertFalse(method_exists($original, '__sleep'));

        // Убеждаемся, что объект не имеет метода __wakeup
        $this->assertFalse(method_exists($original, '__wakeup'));

        // Сериализация должна работать через __serialize
        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized);
        $this->assertEquals('value', $unserialized->key);
    }
}