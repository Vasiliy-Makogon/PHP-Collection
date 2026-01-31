<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(CoverArray::class)]
class ItemTest extends TestCase
{
    /**
     * Tests item() method with existing scalar values.
     *
     * This test verifies that the item() method correctly returns
     * scalar values (strings, integers, floats, booleans) for
     * existing keys in the data array.
     *
     *
     * Тестирование метода item() с существующими скалярными значениями.
     *
     * Этот тест проверяет, что метод item() корректно возвращает
     * скалярные значения (строки, целые числа, числа с плавающей точкой, логические значения)
     * для существующих ключей в массиве данных.
     *
     * @see Simple::item()
     */
    public function testItemWithScalarValues(): void
    {
        $array = new NewTypeArray([
            'string' => 'value',
            'int' => 42,
            'float' => 3.14,
            'bool_true' => true,
            'bool_false' => false,
            'zero' => 0,
            'empty_string' => ''
        ]);

        $this->assertEquals('value', $array->item('string'));
        $this->assertEquals(42, $array->item('int'));
        $this->assertEquals(3.14, $array->item('float'));
        $this->assertTrue($array->item('bool_true'));
        $this->assertFalse($array->item('bool_false'));
        $this->assertEquals(0, $array->item('zero'));
        $this->assertEquals('', $array->item('empty_string'));
    }

    /**
     * Tests item() method with null values.
     *
     * This test ensures that the item() method returns null for keys
     * that exist but have null values, which is the same behavior
     * as the __get() method. Both methods should return null when
     * the key exists but its value is explicitly null.
     *
     *
     * Тестирование метода item() со значениями null.
     *
     * Этот тест гарантирует, что метод item() возвращает null для ключей,
     * которые существуют, но имеют значения null, что соответствует
     * поведению метода __get(). Оба метода должны возвращать null, когда
     * ключ существует, но его значение явно равно null.
     *
     * @see Simple::item()
     * @see Simple::__get()
     */
    public function testItemWithNullValues(): void
    {
        $array = new NewTypeArray([
            'null_value' => null,
            'explicit_null' => null
        ]);

        $this->assertNull($array->item('null_value'));
        $this->assertNull($array->item('explicit_null'));

        // Для проверки согласованности с __get()
        $this->assertNull($array->null_value);
        $this->assertNull($array->explicit_null);
    }

    /**
     * Tests item() method with non-existent keys.
     *
     * This test verifies that the item() method returns null for keys
     * that do not exist in the data array, providing a safe way to
     * access potentially undefined array elements without errors.
     *
     *
     * Тестирование метода item() с несуществующими ключами.
     *
     * Этот тест проверяет, что метод item() возвращает null для ключей,
     * которые не существуют в массиве данных, предоставляя безопасный способ
     * доступа к потенциально неопределенным элементам массива без ошибок.
     *
     * @see Simple::item()
     */
    public function testItemWithNonExistentKeys(): void
    {
        $array = new NewTypeArray(['existing' => 'value']);

        $this->assertNull($array->item('non_existent'));
        $this->assertNull($array->item('another_non_existent'));
        $this->assertEquals('value', $array->item('existing'));
    }

    /**
     * Tests item() method with object values.
     *
     * This test ensures that the item() method correctly returns
     * object values, including CoverArray instances, stdClass objects,
     * and other object types stored in the data array.
     *
     *
     * Тестирование метода item() со значениями-объектами.
     *
     * Этот тест гарантирует, что метод item() корректно возвращает
     * объектные значения, включая экземпляры CoverArray, объекты stdClass
     * и другие типы объектов, хранящиеся в массиве данных.
     *
     * @see Simple::item()
     */
    public function testItemWithObjectValues(): void
    {
        $nestedArray = new NewTypeArray(['nested' => 'value']);
        $stdObject = new stdClass();
        $stdObject->property = 'test';

        $array = new NewTypeArray([
            'object' => $stdObject,
            'empty_object' => new stdClass(),
            'cover_array' => new NewTypeArray(),
            'nested_cover' => $nestedArray
        ]);

        $this->assertSame($stdObject, $array->item('object'));
        $this->assertInstanceOf(stdClass::class, $array->item('empty_object'));
        $this->assertInstanceOf(NewTypeArray::class, $array->item('cover_array'));
        $this->assertSame($nestedArray, $array->item('nested_cover'));
    }

    /**
     * Tests item() method with array values.
     *
     * This test verifies that the item() method works correctly with
     * array values, returning arrays as-is when accessed through the
     * item() method (arrays are converted to CoverArray via array2cover
     * when set, so we get CoverArray instances).
     *
     *
     * Тестирование метода item() со значениями-массивами.
     *
     * Этот тест проверяет, что метод item() корректно работает с
     * массивами-значениями, возвращая массивы как есть при доступе через
     * метод item() (массивы преобразуются в CoverArray через array2cover
     * при установке, поэтому мы получаем экземпляры CoverArray).
     *
     * @see Simple::item()
     * @see CoverArray::array2cover()
     */
    public function testItemWithArrayValues(): void
    {
        $array = new NewTypeArray([
            'empty_array' => [],
            'filled_array' => [1, 2, 3],
            'assoc_array' => ['key' => 'value']
        ]);

        $this->assertInstanceOf(NewTypeArray::class, $array->item('empty_array'));
        $this->assertEquals([], $array->item('empty_array')->getDataAsArray());

        $this->assertInstanceOf(NewTypeArray::class, $array->item('filled_array'));
        $this->assertEquals([1, 2, 3], $array->item('filled_array')->getDataAsArray());

        $this->assertInstanceOf(NewTypeArray::class, $array->item('assoc_array'));
        $this->assertEquals(['key' => 'value'], $array->item('assoc_array')->getDataAsArray());
    }

    /**
     * Tests item() method with numeric keys.
     *
     * This test ensures that the item() method works correctly with
     * numeric keys, providing access to array elements by their
     * numeric indices, similar to array access syntax.
     *
     *
     * Тестирование метода item() с числовыми ключами.
     *
     * Этот тест гарантирует, что метод item() корректно работает с
     * числовыми ключами, предоставляя доступ к элементам массива по их
     * числовым индексам, аналогично синтаксису доступа к массиву.
     *
     * @see Simple::item()
     */
    public function testItemWithNumericKeys(): void
    {
        $array = new NewTypeArray([
            0 => 'zero',
            1 => 'one',
            '2' => 'two', // строковый числовой ключ
            3 => 'three'
        ]);

        $this->assertEquals('zero', $array->item(0));
        $this->assertEquals('one', $array->item(1));
        $this->assertEquals('two', $array->item('2'));
        $this->assertEquals('three', $array->item(3));
    }

    /**
     * Tests item() method with special string keys.
     *
     * This test verifies that the item() method handles special string
     * keys correctly, including keys with spaces, special characters,
     * and unusual naming patterns.
     *
     *
     * Тестирование метода item() со специальными строковыми ключами.
     *
     * Этот тест проверяет, что метод item() корректно обрабатывает
     * специальные строковые ключи, включая ключи с пробелами,
     * специальными символами и необычными шаблонами именования.
     *
     * @see Simple::item()
     */
    public function testItemWithSpecialStringKeys(): void
    {
        $array = new NewTypeArray([
            'key with spaces' => 'value1',
            'key-with-dashes' => 'value2',
            'key.with.dots' => 'value3',
            'key_with_underscores' => 'value4',
            'CamelCaseKey' => 'value5',
            '123numericStart' => 'value6'
        ]);

        $this->assertEquals('value1', $array->item('key with spaces'));
        $this->assertEquals('value2', $array->item('key-with-dashes'));
        $this->assertEquals('value3', $array->item('key.with.dots'));
        $this->assertEquals('value4', $array->item('key_with_underscores'));
        $this->assertEquals('value5', $array->item('CamelCaseKey'));
        $this->assertEquals('value6', $array->item('123numericStart'));
    }

    /**
     * Tests item() method after data modification.
     *
     * This test ensures that the item() method reflects the current
     * state of the data, returning updated values after modifications
     * to the array.
     *
     *
     * Тестирование метода item() после модификации данных.
     *
     * Этот тест гарантирует, что метод item() отражает текущее
     * состояние данных, возвращая обновленные значения после модификаций
     * массива.
     *
     * @see Simple::item()
     */
    public function testItemAfterDataModification(): void
    {
        $array = new NewTypeArray(['initial' => 'value']);

        $this->assertEquals('value', $array->item('initial'));

        // Модифицируем данные
        $array->initial = 'modified_value';
        $array->newKey = 'new_value';

        $this->assertEquals('modified_value', $array->item('initial'));
        $this->assertEquals('new_value', $array->item('newKey'));

        // Удаляем ключ
        unset($array->initial);
        $this->assertNull($array->item('initial'));
    }

    /**
     * Tests item() method consistency with array access.
     *
     * This test verifies that the item() method behaves consistently
     * with array access syntax (offsetGet), providing the same results
     * for the same keys.
     *
     *
     * Тестирование согласованности метода item() с доступом к массиву.
     *
     * Этот тест проверяет, что метод item() ведет себя согласованно
     * с синтаксисом доступа к массиву (offsetGet), предоставляя те же
     * результаты для тех же ключей.
     *
     * @see Simple::item()
     * @see CoverArray::offsetGet()
     */
    public function testItemConsistencyWithArrayAccess(): void
    {
        $data = [
            'key1' => 'value1',
            'key2' => null,
            'key3' => [1, 2, 3],
            0 => 'zero'
        ];

        $array = new NewTypeArray($data);

        // Проверяем согласованность между item() и offsetGet()
        $this->assertEquals($array->item('key1'), $array['key1']);
        $this->assertEquals($array->item('key2'), $array['key2']);
        $this->assertEquals($array->item('key3')->getDataAsArray(), $array['key3']->getDataAsArray());
        $this->assertEquals($array->item(0), $array[0]);

        // Несуществующие ключи
        $this->assertEquals($array->item('non_existent'), $array['non_existent']);
    }

    /**
     * Tests item() method with large dataset.
     *
     * This test verifies that the item() method performs efficiently
     * even with large datasets, providing quick access to elements
     * regardless of array size.
     *
     *
     * Тестирование метода item() с большим набором данных.
     *
     * Этот тест проверяет, что метод item() выполняется эффективно
     * даже с большими наборами данных, обеспечивая быстрый доступ к
     * элементам независимо от размера массива.
     *
     * @see Simple::item()
     */
    public function testItemWithLargeDataset(): void
    {
        $largeData = [];
        for ($i = 0; $i < 10000; $i++) {
            $largeData['key_' . $i] = 'value_' . $i;
        }

        $array = new NewTypeArray($largeData);

        // Тестируем доступ к первому, последнему и среднему элементам
        $first = $array->item('key_0');
        $middle = $array->item('key_5000');
        $last = $array->item('key_9999');

        $this->assertEquals('value_0', $first);
        $this->assertEquals('value_5000', $middle);
        $this->assertEquals('value_9999', $last);
    }

    /**
     * Tests item() method with mixed key types in complex structure.
     *
     * This test verifies that the item() method correctly handles
     * complex nested structures with mixed key types, maintaining
     * proper access to deeply nested elements.
     *
     *
     * Тестирование метода item() со смешанными типами ключей в сложной структуре.
     *
     * Этот тест проверяет, что метод item() корректно обрабатывает
     * сложные вложенные структуры со смешанными типами ключей, сохраняя
     * правильный доступ к глубоко вложенным элементам.
     *
     * @see Simple::item()
     */
    public function testItemWithComplexNestedStructure(): void
    {
        $deepObject = new stdClass();
        $deepObject->id = 999;

        $array = new NewTypeArray([
            'level1' => new NewTypeArray([
                'level2' => new NewTypeArray([
                    'level3' => new NewTypeArray([
                        'scalar' => 'deep_value',
                        'object' => $deepObject,
                        'array' => [1, 2, 3],
                        'numeric_key' => 42,
                        'special key' => 'with spaces'
                    ])
                ])
            ])
        ]);

        // Проверяем доступ к глубоко вложенным элементам
        $this->assertInstanceOf(NewTypeArray::class, $array->item('level1'));
        $this->assertInstanceOf(NewTypeArray::class, $array->item('level1')->item('level2'));
        $this->assertInstanceOf(NewTypeArray::class, $array->item('level1')->item('level2')->item('level3'));

        $level3 = $array->item('level1')->item('level2')->item('level3');

        $this->assertEquals('deep_value', $level3->item('scalar'));
        $this->assertSame($deepObject, $level3->item('object'));
        $this->assertInstanceOf(NewTypeArray::class, $level3->item('array'));
        $this->assertEquals([1, 2, 3], $level3->item('array')->getDataAsArray());
        $this->assertEquals(42, $level3->item('numeric_key'));
        $this->assertEquals('with spaces', $level3->item('special key'));
    }

    /**
     * Tests item() method consistency with __get() method.
     *
     * This test verifies that the item() method behaves consistently
     * with the __get() method, returning the same values for the same
     * keys. Both methods provide the same access pattern to the data,
     * with item() accepting any key type (string or numeric) and
     * __get() being used for property-like access.
     *
     *
     * Тестирование согласованности метода item() с методом __get().
     *
     * Этот тест проверяет, что метод item() ведет себя согласованно
     * с методом __get(), возвращая одинаковые значения для одинаковых
     * ключей. Оба метода предоставляют одинаковый способ доступа
     * к данным, где item() принимает любой тип ключа (строковый или числовой),
     * а __get() используется для доступа, подобного свойствам.
     *
     * @see Simple::item()
     * @see Simple::__get()
     */
    public function testItemConsistencyWithMagicGet(): void
    {
        $array = new NewTypeArray([
            'string' => 'value',
            'int' => 42,
            'null' => null,
            'array' => [1, 2, 3],
            0 => 'zero',
            '1' => 'one'
        ]);

        // Проверяем, что item() и __get() возвращают одинаковые значения
        $this->assertEquals($array->string, $array->item('string'));
        $this->assertEquals($array->int, $array->item('int'));
        $this->assertEquals($array->null, $array->item('null'));

        // Для массивов оба возвращают CoverArray экземпляры
        $this->assertSame($array->array, $array->item('array'));

        // Числовые ключи - item() работает, __get() может работать через фигурные скобки
        $this->assertEquals('zero', $array->item(0));
        $this->assertEquals('zero', $array->{0});
        $this->assertEquals('one', $array->item('1'));
        $this->assertEquals('one', $array->{'1'});

        // Несуществующие ключи
        $this->assertNull($array->non_existent);
        $this->assertNull($array->item('non_existent'));
    }
}