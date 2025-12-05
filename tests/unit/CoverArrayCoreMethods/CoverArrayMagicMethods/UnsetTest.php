<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods\CoverArrayMagicMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(CoverArray::class)]
class UnsetTest extends TestCase
{
    /**
     * Tests unset() with various value types.
     *
     * This test verifies that the __unset method correctly removes
     * keys with different types of values including scalars, arrays,
     * objects, and CoverArray instances.
     *
     *
     * Тестирование unset() с различными типами значений.
     *
     * Этот тест проверяет, что метод __unset корректно удаляет
     * ключи с разными типами значений, включая скаляры, массивы,
     * объекты и экземпляры CoverArray.
     *
     * @see CoverArray::__unset()
     */
    public function testUnsetWithVariousValueTypes(): void
    {
        $nested = new NewTypeArray(['nested' => 'value']);
        $object = new stdClass();
        $object->property = 'test';

        $array = new NewTypeArray([
            'string' => 'value',
            'int' => 42,
            'float' => 3.14,
            'bool_true' => true,
            'bool_false' => false,
            'null' => null,
            'zero' => 0,
            'empty_string' => '',
            'filled_array' => [1, 2, 3],
            'assoc_array' => ['key' => 'value'],
            'empty_array' => [],
            'cover_array' => $nested,
            'std_object' => $object,
            'empty_object' => new stdClass()
        ]);

        $initialCount = count($array);

        // Удаляем различные типы значений
        unset($array->string);
        unset($array->int);
        unset($array->null); // null значение
        unset($array->filled_array);
        unset($array->cover_array);
        unset($array->std_object);

        $this->assertFalse(isset($array->string));
        $this->assertFalse(isset($array->int));
        $this->assertFalse(isset($array->null));
        $this->assertFalse(isset($array->filled_array));
        $this->assertFalse(isset($array->cover_array));
        $this->assertFalse(isset($array->std_object));

        // Проверяем, что остальные значения остались
        $this->assertTrue(isset($array->float));
        $this->assertTrue(isset($array->bool_true));
        $this->assertTrue(isset($array->bool_false));
        $this->assertTrue(isset($array->zero));
        $this->assertTrue(isset($array->empty_string));
        $this->assertTrue(isset($array->assoc_array));
        $this->assertTrue(isset($array->empty_array));
        $this->assertTrue(isset($array->empty_object));

        $this->assertCount($initialCount - 6, $array);
    }

    /**
     * Tests unset() with various key formats.
     *
     * This test ensures that the __unset method works correctly with
     * different key formats including numeric keys, special string keys,
     * and mixed key types.
     *
     *
     * Тестирование unset() с различными форматами ключей.
     *
     * Этот тест гарантирует, что метод __unset корректно работает с
     * различными форматами ключей, включая числовые ключи, специальные
     * строковые ключи и смешанные типы ключей.
     *
     * @see CoverArray::__unset()
     */
    public function testUnsetWithVariousKeyFormats(): void
    {
        $array = new NewTypeArray([
            // Числовые ключи
            0 => 'zero',
            1 => 'one',
            '2' => 'two', // строковый числовой ключ
            3 => 'three',
            4 => 'four', // дополнительный ключ

            // Специальные строковые ключи
            'key with spaces' => 'value1',
            'key-with-dashes' => 'value2',
            'key.with.dots' => 'value3',
            'key_with_underscores' => 'value4',
            'CamelCaseKey' => 'value5',
            '123numericStart' => 'value6',

            // Смешанные типы
            'null' => null
        ]);

        $initialCount = count($array); // 11 элементов

        // Удаляем числовые ключи (0, 1, '2')
        unset($array->{0});
        unset($array->{1});
        unset($array->{2});

        $this->assertFalse(isset($array->{0}));
        $this->assertFalse(isset($array->{1}));
        $this->assertFalse(isset($array->{2}));
        $this->assertTrue(isset($array->{3}));
        $this->assertTrue(isset($array->{4}));

        // Удаляем специальные строковые ключи
        unset($array->{'key with spaces'});
        unset($array->{'key-with-dashes'});
        unset($array->{'key.with.dots'});
        unset($array->key_with_underscores);
        unset($array->CamelCaseKey);
        unset($array->{'123numericStart'});

        $this->assertFalse(isset($array->{'key with spaces'}));
        $this->assertFalse(isset($array->{'key-with-dashes'}));
        $this->assertFalse(isset($array->{'key.with.dots'}));
        $this->assertFalse(isset($array->key_with_underscores));
        $this->assertFalse(isset($array->CamelCaseKey));
        $this->assertFalse(isset($array->{'123numericStart'}));

        // Удаляем смешанные типы
        unset($array->null);

        $this->assertFalse(isset($array->null));

        // Проверяем, что оставшиеся ключи существуют
        $this->assertTrue(isset($array->{3}));
        $this->assertTrue(isset($array->{4}));

        $this->assertCount(2, $array); // остались только ключи 3 и 4
    }

    /**
     * Tests unset() with non-existent and dynamic keys.
     *
     * This test verifies that the __unset method does not throw errors
     * when attempting to unset non-existent keys and correctly handles
     * dynamically added properties.
     *
     *
     * Тестирование unset() с несуществующими и динамическими ключами.
     *
     * Этот тест проверяет, что метод __unset не вызывает ошибок
     * при попытке удалить несуществующие ключи и корректно обрабатывает
     * динамически добавленные свойства.
     *
     * @see CoverArray::__unset()
     * @see CoverArray::__set()
     */
    public function testUnsetWithNonExistentAndDynamicKeys(): void
    {
        $array = new NewTypeArray(['initial' => 'value']);

        // Удаление несуществующих ключей не должно вызывать ошибок
        unset($array->non_existent);
        unset($array->another_non_existent);
        unset($array->undefined);

        $this->assertFalse(isset($array->non_existent));
        $this->assertFalse(isset($array->another_non_existent));
        $this->assertFalse(isset($array->undefined));

        // Добавляем динамические свойства
        $array->dynamic1 = 'value1';
        $array->dynamic2 = 'value2';
        $array->dynamic3 = null;

        $this->assertTrue(isset($array->dynamic1));
        $this->assertTrue(isset($array->dynamic2));
        $this->assertFalse(isset($array->dynamic3)); // null значение

        // Удаляем динамические свойства
        unset($array->dynamic1);
        unset($array->dynamic2);
        unset($array->dynamic3); // даже если не установлен через isset()
        unset($array->non_existent_dynamic);

        $this->assertFalse(isset($array->dynamic1));
        $this->assertFalse(isset($array->dynamic2));
        $this->assertFalse(isset($array->dynamic3));
        $this->assertFalse(isset($array->non_existent_dynamic));

        // Удаляем исходный ключ
        unset($array->initial);

        $this->assertFalse(isset($array->initial));
        $this->assertCount(0, $array);
    }

    /**
     * Tests unset() consistency with ArrayAccess interface.
     *
     * This test ensures that the __unset method behaves consistently
     * with the offsetUnset() method from the ArrayAccess interface,
     * providing uniform property and array unsetting behavior.
     *
     *
     * Тестирование согласованности unset() с интерфейсом ArrayAccess.
     *
     * Этот тест гарантирует, что метод __unset ведет себя согласованно
     * с методом offsetUnset() из интерфейса ArrayAccess,
     * обеспечивая единообразное поведение удаления свойств и элементов массива.
     *
     * @see CoverArray::__unset()
     * @see CoverArray::offsetUnset()
     */
    public function testUnsetConsistencyWithArrayAccess(): void
    {
        $array = new NewTypeArray([
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'key4' => 'value4'
        ]);

        // Удаляем через __unset (как свойство)
        unset($array->key1);
        $this->assertFalse(isset($array->key1));
        $this->assertFalse($array->offsetExists('key1'));

        // Удаляем через offsetUnset (как элемент массива)
        $array->offsetUnset('key2');
        $this->assertFalse(isset($array->key2));
        $this->assertFalse($array->offsetExists('key2'));

        // Удаляем через unset() с синтаксисом массива
        unset($array['key3']);
        $this->assertFalse(isset($array->key3));
        $this->assertFalse($array->offsetExists('key3'));

        // Проверяем, что оставшийся ключ доступен обоими способами
        $this->assertTrue(isset($array->key4));
        $this->assertTrue($array->offsetExists('key4'));
        $this->assertEquals('value4', $array->key4);
        $this->assertEquals('value4', $array['key4']);

        $this->assertCount(1, $array);
    }

    /**
     * Tests unset() does not affect other keys and preserves data types.
     *
     * This test ensures that unsetting one key does not affect other
     * keys in the array and that remaining data maintains its original
     * types and structure.
     *
     *
     * Тестирование того, что unset() не влияет на другие ключи и сохраняет типы данных.
     *
     * Этот тест гарантирует, что удаление одного ключа не влияет на
     * другие ключи в массиве и что оставшиеся данные сохраняют свои
     * исходные типы и структуру.
     *
     * @see CoverArray::__unset()
     */
    public function testUnsetDoesNotAffectOtherKeysAndPreservesDataTypes(): void
    {
        $nestedArray = new NewTypeArray(['nested' => 'value']);
        $stdObject = new stdClass();
        $stdObject->property = 'test';

        $array = new NewTypeArray([
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
            'key4' => 'value4',
            'string' => 'text',
            'int' => 42,
            'float' => 3.14,
            'bool' => true,
            'array' => [1, 2, 3],
            'object' => $stdObject,
            'cover_array' => $nestedArray,
            'null' => null
        ]);

        $originalData = $array->getDataAsArray();

        // Сохраняем ссылки на объекты перед удалением
        $originalObject = $array->object;
        $originalCoverArray = $array->cover_array;

        // Удаляем некоторые ключи
        unset($array->key2);
        unset($array->string);
        unset($array->null);
        unset($array->array);

        // Проверяем, что удаленные ключи отсутствуют
        $this->assertFalse(isset($array->key2));
        $this->assertFalse(isset($array->string));
        $this->assertFalse(isset($array->null));
        $this->assertFalse(isset($array->array));

        // Проверяем, что остальные ключи остались нетронутыми
        $this->assertTrue(isset($array->key1));
        $this->assertTrue(isset($array->key3));
        $this->assertTrue(isset($array->key4));
        $this->assertTrue(isset($array->int));
        $this->assertTrue(isset($array->float));
        $this->assertTrue(isset($array->bool));
        $this->assertTrue(isset($array->object));
        $this->assertTrue(isset($array->cover_array));

        // Проверяем значения
        $this->assertEquals('value1', $array->key1);
        $this->assertEquals('value3', $array->key3);
        $this->assertEquals('value4', $array->key4);
        $this->assertEquals(42, $array->int);
        $this->assertEquals(3.14, $array->float);
        $this->assertTrue($array->bool);

        // Проверяем сохранение типов данных
        $this->assertIsInt($array->int);
        $this->assertIsFloat($array->float);
        $this->assertIsBool($array->bool);
        $this->assertIsObject($array->object);
        $this->assertInstanceOf(NewTypeArray::class, $array->cover_array);

        // Проверяем, что это те же объекты (не клонированные)
        $this->assertSame($originalObject, $array->object);
        $this->assertSame($originalCoverArray, $array->cover_array);

        $this->assertCount(8, $array); // Было 12 элементов, удалили 4, осталось 8
    }
}