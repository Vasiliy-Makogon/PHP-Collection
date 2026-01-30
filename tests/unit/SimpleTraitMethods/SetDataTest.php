<?php

declare(strict_types=1);

namespace SimpleTraitMethods;

use Krugozor\Cover\Simple;
use Krugozor\Cover\Tests\SimpleTraitTestClass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;
use ArrayIterator;

#[CoversClass(Simple::class)]
class SetDataTest extends TestCase
{
    /**
     * Tests setData() with scalar values in an array.
     *
     * This test verifies that the Simple trait's setData() method correctly
     * sets scalar values from an iterable source into the internal data array.
     *
     *
     * Тестирует setData() со скалярными значениями в массиве.
     *
     * Этот тест проверяет, что метод setData() трейта Simple корректно
     * устанавливает скалярные значения из итерируемого источника
     * во внутренний массив данных.
     *
     * @see Simple::setData()
     */
    public function testSetDataWithScalarValues(): void
    {
        $obj = new SimpleTraitTestClass();

        $data = [
            'string' => 'value',
            'int' => 42,
            'float' => 3.14,
            'bool_true' => true,
            'bool_false' => false,
            'null' => null,
            'zero' => 0,
            'empty_string' => ''
        ];

        $result = $obj->setData($data);

        // Check values are set correctly
        $this->assertSame('value', $obj->string);
        $this->assertSame(42, $obj->int);
        $this->assertSame(3.14, $obj->float);
        $this->assertTrue($obj->bool_true);
        $this->assertFalse($obj->bool_false);
        $this->assertNull($obj->null);
        $this->assertSame(0, $obj->zero);
        $this->assertSame('', $obj->empty_string);

        // Check fluent interface (returns $this)
        $this->assertSame($obj, $result);
    }

    /**
     * Tests setData() stores arrays WITHOUT converting them to CoverArray.
     *
     * This test verifies the key difference between Simple::setData() and
     * CoverArray::setData(). The Simple trait stores arrays as-is, while
     * CoverArray converts them to CoverArray instances via array2cover().
     *
     *
     * Тестирует, что setData() сохраняет массивы БЕЗ преобразования в CoverArray.
     *
     * Этот тест проверяет ключевое различие между Simple::setData() и
     * CoverArray::setData(). Трейт Simple сохраняет массивы как есть, тогда как
     * CoverArray преобразует их в экземпляры CoverArray через array2cover().
     *
     * @see Simple::setData()
     */
    public function testSetDataArraysWithoutConversion(): void
    {
        $obj = new SimpleTraitTestClass();

        $data = [
            'simple' => ['a', 'b', 'c'],
            'assoc' => ['name' => 'John', 'age' => 30],
            'nested' => [
                'level1' => [
                    'level2' => 'deep value'
                ]
            ],
            'empty' => []
        ];

        $obj->setData($data);

        // Arrays remain as plain PHP arrays (NOT CoverArray instances)
        $this->assertIsArray($obj->simple);
        $this->assertIsArray($obj->assoc);
        $this->assertIsArray($obj->nested);
        $this->assertIsArray($obj->empty);

        // Values are preserved exactly
        $this->assertSame(['a', 'b', 'c'], $obj->simple);
        $this->assertSame(['name' => 'John', 'age' => 30], $obj->assoc);
        $this->assertSame('deep value', $obj->nested['level1']['level2']);
        $this->assertSame([], $obj->empty);

        // Nested arrays are also plain arrays
        $this->assertIsArray($obj->nested['level1']);
    }

    /**
     * Tests setData() with null parameter does nothing.
     *
     * This test verifies that when null is passed to setData(),
     * the internal data remains unchanged.
     *
     *
     * Тестирует, что setData() с параметром null ничего не делает.
     *
     * Этот тест проверяет, что когда null передается в setData(),
     * внутренние данные остаются без изменений.
     *
     * @see Simple::setData()
     */
    public function testSetDataWithNullDoesNothing(): void
    {
        $obj = new SimpleTraitTestClass();
        $obj->existing = 'value';

        $result = $obj->setData(null);

        // Data should remain unchanged
        $this->assertSame('value', $obj->existing);

        // Should still return $this for chaining
        $this->assertSame($obj, $result);
    }

    /**
     * Tests setData() with empty iterable does nothing.
     *
     * This test verifies that when an empty array or iterable is passed,
     * the internal data remains unchanged (no clearing occurs).
     *
     *
     * Тестирует, что setData() с пустым итерируемым объектом ничего не делает.
     *
     * Этот тест проверяет, что когда передается пустой массив или итерируемый
     * объект, внутренние данные остаются без изменений (очистка не происходит).
     *
     * @see Simple::setData()
     */
    public function testSetDataWithEmptyIterableDoesNotClearData(): void
    {
        $obj = new SimpleTraitTestClass();
        $obj->existing = 'value';

        $obj->setData([]);

        // Data should remain unchanged
        $this->assertSame('value', $obj->existing);
        $this->assertSame(['existing' => 'value'], $obj->getDataAsArray());
    }

    /**
     * Tests setData() merges new data with existing data.
     *
     * This test verifies that setData() adds new keys and updates existing
     * ones without removing keys that are not present in the new data.
     *
     *
     * Тестирует, что setData() объединяет новые данные с существующими.
     *
     * Этот тест проверяет, что setData() добавляет новые ключи и обновляет
     * существующие, не удаляя ключи, которые отсутствуют в новых данных.
     *
     * @see Simple::setData()
     */
    public function testSetDataMergesWithExistingData(): void
    {
        $obj = new SimpleTraitTestClass();

        // Set initial data
        $obj->setData([
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3'
        ]);

        // Update some keys and add new ones
        $obj->setData([
            'key2' => 'updated2',
            'key4' => 'new4'
        ]);

        // key1 should remain unchanged
        $this->assertSame('value1', $obj->key1);
        // key2 should be updated
        $this->assertSame('updated2', $obj->key2);
        // key3 should remain unchanged
        $this->assertSame('value3', $obj->key3);
        // key4 should be added
        $this->assertSame('new4', $obj->key4);
    }

    /**
     * Tests setData() with ArrayIterator.
     *
     * This test verifies that setData() works correctly with
     * iterable objects like ArrayIterator, not just arrays.
     *
     *
     * Тестирует setData() с ArrayIterator.
     *
     * Этот тест проверяет, что setData() корректно работает с
     * итерируемыми объектами, такими как ArrayIterator, а не только с массивами.
     *
     * @see Simple::setData()
     */
    public function testSetDataWithArrayIterator(): void
    {
        $obj = new SimpleTraitTestClass();

        $iterator = new ArrayIterator([
            'key1' => 'value1',
            'key2' => 'value2',
            'nested' => ['inner' => 'value']
        ]);

        $obj->setData($iterator);

        $this->assertSame('value1', $obj->key1);
        $this->assertSame('value2', $obj->key2);

        // Arrays from iterator are NOT converted (Simple trait behavior)
        $this->assertIsArray($obj->nested);
        $this->assertSame('value', $obj->nested['inner']);
    }

    /**
     * Tests setData() with a generator.
     *
     * This test verifies that setData() works correctly with generators,
     * which are another type of iterable.
     *
     *
     * Тестирует setData() с генератором.
     *
     * Этот тест проверяет, что setData() корректно работает с генераторами,
     * которые являются другим типом итерируемых объектов.
     *
     * @see Simple::setData()
     */
    public function testSetDataWithGenerator(): void
    {
        $obj = new SimpleTraitTestClass();

        $generator = (function () {
            yield 'gen_key1' => 'gen_value1';
            yield 'gen_key2' => 'gen_value2';
            yield 'array_key' => ['nested' => 'data'];
        })();

        $obj->setData($generator);

        $this->assertSame('gen_value1', $obj->gen_key1);
        $this->assertSame('gen_value2', $obj->gen_key2);

        // Arrays from generator are NOT converted (Simple trait behavior)
        $this->assertIsArray($obj->array_key);
        $this->assertSame('data', $obj->array_key['nested']);
    }

    /**
     * Tests setData() with object values.
     *
     * This test verifies that objects are stored directly by reference
     * without modification.
     *
     *
     * Тестирует setData() со значениями-объектами.
     *
     * Этот тест проверяет, что объекты сохраняются напрямую по ссылке
     * без изменений.
     *
     * @see Simple::setData()
     */
    public function testSetDataWithObjectValues(): void
    {
        $obj = new SimpleTraitTestClass();

        $stdObject = new stdClass();
        $stdObject->property = 'value';

        $obj->setData([
            'object' => $stdObject
        ]);

        // Same object reference
        $this->assertSame($stdObject, $obj->object);

        // Modifications through one reference affect the other
        $stdObject->newProperty = 'new value';
        $this->assertSame('new value', $obj->object->newProperty);
    }

    /**
     * Tests setData() fluent interface (method chaining).
     *
     * This test verifies that setData() returns $this, allowing
     * method chaining.
     *
     *
     * Тестирует fluent interface (цепочку методов) setData().
     *
     * Этот тест проверяет, что setData() возвращает $this,
     * позволяя создавать цепочки методов.
     *
     * @see Simple::setData()
     */
    public function testSetDataFluentInterface(): void
    {
        $obj = new SimpleTraitTestClass();

        $result = $obj
            ->setData(['key1' => 'value1'])
            ->setData(['key2' => 'value2'])
            ->setData(['key3' => 'value3']);

        $this->assertSame($obj, $result);
        $this->assertSame('value1', $obj->key1);
        $this->assertSame('value2', $obj->key2);
        $this->assertSame('value3', $obj->key3);
    }

    /**
     * Tests setData() with various key types.
     *
     * This test verifies that setData() correctly handles all types
     * of array keys, including numeric keys, string numeric keys,
     * and keys with special characters.
     *
     *
     * Тестирует setData() с различными типами ключей.
     *
     * Этот тест проверяет, что setData() корректно обрабатывает все типы
     * ключей массива, включая числовые ключи, строковые числовые ключи
     * и ключи со специальными символами.
     *
     * @see Simple::setData()
     */
    public function testSetDataWithVariousKeyTypes(): void
    {
        $obj = new SimpleTraitTestClass();

        $data = [
            0 => 'zero',
            1 => 'one',
            '2' => 'two_string_key',
            'key with spaces' => 'spaces',
            'key-with-dashes' => 'dashes',
            'key.with.dots' => 'dots',
            'café' => 'UTF-8',
            '' => 'empty_key'
        ];

        $obj->setData($data);

        $this->assertSame('zero', $obj->item(0));
        $this->assertSame('one', $obj->item(1));
        $this->assertSame('two_string_key', $obj->item('2'));
        $this->assertSame('spaces', $obj->item('key with spaces'));
        $this->assertSame('dashes', $obj->item('key-with-dashes'));
        $this->assertSame('dots', $obj->item('key.with.dots'));
        $this->assertSame('UTF-8', $obj->café);
        $this->assertSame('empty_key', $obj->item(''));
    }
}
