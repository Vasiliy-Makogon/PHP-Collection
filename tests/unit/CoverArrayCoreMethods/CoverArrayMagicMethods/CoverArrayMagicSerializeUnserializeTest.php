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
     * Tests complete serialization/deserialization cycle with scalar values.
     *
     * This test verifies that CoverArray objects can be serialized
     * and deserialized through standard PHP functions while preserving
     * scalar values.
     *
     *
     * Тестирование полного цикла сериализации/десериализации со скалярными значениями.
     *
     * Этот тест проверяет, что объект CoverArray может быть сериализован
     * и десериализован через стандартные PHP-функции с сохранением
     * скалярных значений.
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
     * Tests serialization/deserialization of nested data structures.
     *
     * This test verifies that nested arrays and CoverArray objects are correctly
     * converted during standard PHP serialization.
     *
     *
     * Тестирование сериализации/десериализации вложенных структур данных.
     *
     * Этот тест проверяет, что вложенные массивы и объекты CoverArray правильно
     * преобразуются при стандартной сериализации PHP.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testSerializeUnserializeWithNestedDataStructures(): void
    {
        $originalData = [
            'simple' => 'value',
            'nested_array' => [
                'level1' => [
                    'level2' => [1, 2, 3]
                ]
            ],
            'nested_cover' => new NewTypeArray([
                'inner' => new NewTypeArray(['key' => 'value'])
            ]),
            'mixed' => [
                'cover' => new NewTypeArray(['a' => 1]),
                'array' => ['b' => 2]
            ],
            'list' => [1, 2, 3],
            'assoc' => ['a' => 1, 'b' => 2]
        ];

        $original = new NewTypeArray($originalData);
        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized);
        $this->assertEquals('value', $unserialized->simple);

        // Проверяем вложенные массивы
        $this->assertInstanceOf(NewTypeArray::class, $unserialized->nested_array);
        $this->assertInstanceOf(NewTypeArray::class, $unserialized->nested_array->level1);
        $this->assertInstanceOf(NewTypeArray::class, $unserialized->nested_array->level1->level2);
        $this->assertEquals([1, 2, 3], $unserialized->nested_array->level1->level2->getDataAsArray());

        // Проверяем вложенные объекты CoverArray
        $this->assertInstanceOf(NewTypeArray::class, $unserialized->nested_cover);
        $this->assertInstanceOf(NewTypeArray::class, $unserialized->nested_cover->inner);
        $this->assertEquals('value', $unserialized->nested_cover->inner->key);

        // Проверяем смешанную структуру
        $this->assertInstanceOf(NewTypeArray::class, $unserialized->mixed['cover']);
        $this->assertInstanceOf(NewTypeArray::class, $unserialized->mixed['array']);
    }

    /**
     * Tests serialization/deserialization of empty object.
     *
     * This test verifies that an empty CoverArray object can be
     * serialized and deserialized without data loss.
     *
     *
     * Тестирование сериализации/десериализации пустого объекта.
     *
     * Этот тест проверяет, что пустой объект CoverArray может быть
     * сериализован и десериализован без потери данных.
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
     * Tests data consistency after deserialization.
     *
     * This test verifies that data remains identical
     * after a complete serialization and deserialization cycle,
     * including object references.
     *
     *
     * Тестирование согласованности данных после десериализации.
     *
     * Этот тест проверяет, что данные остаются идентичными
     * после полного цикла сериализации и десериализации,
     * включая ссылки на объекты.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testDataConsistencyAndReferencesAfterDeserialization(): void
    {
        $sharedObject = new stdClass();
        $sharedObject->id = 42;

        $data = [
            'scalar' => 'value',
            'array' => [1, 2, 3],
            'nested' => [
                'inner' => ['a', 'b', 'c']
            ],
            'object' => new stdClass(),
            'ref1' => $sharedObject,
            'ref2' => $sharedObject,
            'nested_ref' => [
                'ref3' => $sharedObject
            ]
        ];

        $original = new NewTypeArray($data);
        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        // Проверяем целостность данных
        $this->assertEquals(
            $original->getDataAsArray(),
            $unserialized->getDataAsArray()
        );

        // Проверяем сохранение ссылок на объекты
        $this->assertSame($unserialized->ref1, $unserialized->ref2);
        $this->assertSame($unserialized->ref1, $unserialized->nested_ref->ref3);
    }

    /**
     * Tests serialized string format and type.
     *
     * This test verifies that serialize() returns a string
     * with expected format, and unserialize() correctly restores the object.
     *
     *
     * Тестирование формата и типа сериализованной строки.
     *
     * Этот тест проверяет, что serialize() возвращает строку
     * с ожидаемым форматом, а unserialize() правильно восстанавливает объект.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testSerializeReturnsStringWithCorrectFormat(): void
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
     * Tests serialization with deep nesting.
     *
     * Verifies handling of deeply nested data structures
     * and preservation of method functionality after deserialization.
     *
     *
     * Тестирование сериализации с глубокой вложенностью.
     *
     * Проверяет обработку глубоко вложенных структур данных
     * и сохранение функциональности методов после десериализации.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testSerializeUnserializeWithDeepNestingAndMethodPreservation(): void
    {
        // Создаем глубоко вложенную структуру
        $deepArray = [];
        $current = &$deepArray;

        for ($i = 0; $i < 5; $i++) {
            $current['level' . $i] = ['value' => $i];
            $current = &$current['level' . $i];
        }
        $current['final'] = 'deep_value';

        $original = new NewTypeArray($deepArray);

        // Используем метод setData для изменения структуры
        $original->setData(['config' => ['db' => ['host' => 'localhost', 'port' => 3306]]]);

        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        // Проверяем работу метода get с точечной нотацией
        $this->assertEquals('localhost', $unserialized->get('config.db.host'));
        $this->assertEquals(3306, $unserialized->get('config.db.port'));

        // Проверяем другие методы
        $this->assertFalse($unserialized->isEmpty());
        $this->assertTrue($unserialized->keyExists('config'));

        // Проверяем глубокую вложенность
        $value = $unserialized;
        for ($i = 0; $i < 5; $i++) {
            $this->assertInstanceOf(NewTypeArray::class, $value);
            $value = $value['level' . $i];
        }

        $this->assertEquals('deep_value', $value['final']);
    }

    /**
     * Tests serialization with numeric keys and edge cases.
     *
     * Verifies correct handling of arrays with numeric indices,
     * special characters, and edge case values.
     *
     *
     * Тестирование сериализации с числовыми ключами и граничными случаями.
     *
     * Проверяет корректную обработку массивов с числовыми индексами,
     * специальных символов и граничных значений.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testSerializeUnserializeWithNumericKeysAndEdgeCases(): void
    {
        $originalData = [
            0 => 'zero',
            1 => 'one',
            5 => 'five', // Пропущенные индексы
            '10' => 'ten_string_key',
            2 => [100, 200, 300],
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

        // Проверяем числовые ключи
        $this->assertEquals('zero', $unserialized[0]);
        $this->assertEquals('one', $unserialized[1]);
        $this->assertEquals('five', $unserialized[5]);
        $this->assertEquals('ten_string_key', $unserialized['10']);
        $this->assertInstanceOf(NewTypeArray::class, $unserialized[2]);
        $this->assertEquals(100, $unserialized[2][0]);

        // Проверяем граничные случаи
        $this->assertEquals([], $unserialized->empty_array->getDataAsArray());
        $this->assertEquals(['', null, []], $unserialized->array_with_empty->getDataAsArray());
        $this->assertEquals('Привет мир! 🚀', $unserialized->unicode);
        $this->assertEquals(PHP_INT_MAX, $unserialized->large_number);
        $this->assertInfinite($unserialized->inf);
        $this->assertNan($unserialized->nan);
        $this->assertEqualsWithDelta(0.3, $unserialized->float_precision, 0.0000001);
    }

    /**
     * Tests serialization performance with large data sets.
     *
     * Verifies that serialization works correctly with large data volumes
     * and maintains performance.
     *
     *
     * Тестирование производительности сериализации больших данных.
     *
     * Проверяет, что сериализация работает корректно с большими объемами данных
     * и сохраняет производительность.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testSerializeUnserializeLargeDataSet(): void
    {
        $largeData = [];
        for ($i = 0; $i < 500; $i++) {
            $largeData['key_' . $i] = [
                'id' => $i,
                'name' => 'Item ' . $i,
                'data' => str_repeat('x', 50),
                'nested' => array_fill(0, 5, 'nested_value')
            ];
        }

        $original = new NewTypeArray($largeData);
        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized);
        $this->assertCount(500, $unserialized);
        $this->assertEquals('Item 42', $unserialized->key_42['name']);
        $this->assertEquals('Item 499', $unserialized->key_499['name']);
    }

    /**
     * Tests no conflict with __sleep/__wakeup magic methods.
     *
     * Verifies that __serialize/__unserialize implementation doesn't conflict
     * with deprecated magic methods and correctly handles object cloning.
     *
     *
     * Тестирование отсутствия конфликта с магическими методами __sleep/__wakeup.
     *
     * Проверяет, что реализация __serialize/__unserialize не конфликтует
     * с устаревшими магическими методами и правильно обрабатывает клонирование объектов.
     *
     * @see CoverArray::__serialize()
     * @see CoverArray::__unserialize()
     * @see serialize()
     * @see unserialize()
     */
    public function testNoSleepWakeupConflictAndCloning(): void
    {
        $original = new NewTypeArray(['key' => 'value', 'nested' => ['a' => 1]]);

        // Проверяем отсутствие старых магических методов
        $this->assertFalse(method_exists($original, '__sleep'));
        $this->assertFalse(method_exists($original, '__wakeup'));

        // Проверяем клонирование перед сериализацией
        $clone = $original->copy();
        $this->assertEquals($original->getDataAsArray(), $clone->getDataAsArray());
        $this->assertNotSame($original, $clone);

        // Проверяем сериализацию/десериализацию
        $serialized = serialize($original);
        $unserialized = unserialize($serialized);

        $this->assertInstanceOf(NewTypeArray::class, $unserialized);
        $this->assertEquals('value', $unserialized->key);
        $this->assertInstanceOf(NewTypeArray::class, $unserialized->nested);
        $this->assertEquals(1, $unserialized->nested->a);
    }
}