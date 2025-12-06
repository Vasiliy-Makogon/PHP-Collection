<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(CoverArray::class)]
class GetDataTest extends TestCase
{
    /**
     * Tests getData() returns the internal data array.
     *
     * This test verifies that the getData() method correctly returns
     * the internal data array without any transformations, preserving
     * the original structure and values as stored. Arrays are converted
     * to CoverArray objects when stored, so getData() returns
     * CoverArray instances for array values.
     *
     *
     * Тестирование того, что getData() возвращает внутренний массив данных.
     *
     * Этот тест проверяет, что метод getData() корректно возвращает
     * внутренний массив данных без каких-либо преобразований, сохраняя
     * оригинальную структуру и значения как они хранятся. Массивы преобразуются
     * в объекты CoverArray при сохранении, поэтому getData() возвращает
     * экземпляры CoverArray для значений-массивов.
     *
     * @see Simple::getData()
     */
    public function testGetDataReturnsInternalDataArray(): void
    {
        $array = new NewTypeArray([
            'string' => 'value',
            'int' => 42,
            'null' => null
        ]);

        $returnedData = $array->getData();

        // Проверяем, что возвращены правильные значения
        $this->assertEquals('value', $returnedData['string']);
        $this->assertEquals(42, $returnedData['int']);
        $this->assertNull($returnedData['null']);
    }

    /**
     * Tests getData() returns CoverArray instances for array values.
     *
     * This test ensures that when arrays are stored in CoverArray,
     * they are converted to CoverArray objects, and getData() returns
     * these CoverArray instances, not the original arrays.
     *
     *
     * Тестирование того, что getData() возвращает экземпляры CoverArray для значений-массивов.
     *
     * Этот тест гарантирует, что когда массивы хранятся в CoverArray,
     * они преобразуются в объекты CoverArray, и getData() возвращает
     * эти экземпляры CoverArray, а не оригинальные массивы.
     *
     * @see Simple::getData()
     */
    public function testGetDataReturnsCoverArrayForArrays(): void
    {
        $array = new NewTypeArray([
            'array' => [1, 2, 3],
            'nested' => [
                'inner' => ['a', 'b', 'c']
            ]
        ]);

        $data = $array->getData();

        // Проверяем, что массивы преобразованы в CoverArray
        $this->assertInstanceOf(NewTypeArray::class, $data['array']);
        $this->assertEquals([1, 2, 3], $data['array']->getDataAsArray());

        $this->assertInstanceOf(NewTypeArray::class, $data['nested']);
        $this->assertInstanceOf(NewTypeArray::class, $data['nested']->inner);
        $this->assertEquals(['a', 'b', 'c'], $data['nested']->inner->getDataAsArray());
    }

    /**
     * Tests getData() with empty array.
     *
     * This test ensures that getData() returns an empty array for
     * a CoverArray object with no data, which is the expected
     * behavior for an empty collection.
     *
     *
     * Тестирование getData() с пустым массивом.
     *
     * Этот тест гарантирует, что getData() возвращает пустой массив для
     * объекта CoverArray без данных, что является ожидаемым поведением
     * для пустой коллекции.
     *
     * @see Simple::getData()
     */
    public function testGetDataWithEmptyArray(): void
    {
        $array = new NewTypeArray();
        $data = $array->getData();

        $this->assertEquals([], $data);
        $this->assertIsArray($data);
        $this->assertCount(0, $data);
        $this->assertEmpty($data);
    }

    /**
     * Tests getData() preserves object references.
     *
     * This test verifies that getData() returns the actual object
     * references stored in the internal array, not copies. This
     * is important for maintaining object identity.
     *
     *
     * Тестирование сохранения ссылок на объекты в getData().
     *
     * Этот тест проверяет, что getData() возвращает фактические ссылки
     * на объекты, хранящиеся во внутреннем массиве, а не копии. Это
     * важно для сохранения идентичности объектов.
     *
     * @see Simple::getData()
     */
    public function testGetDataPreservesObjectReferences(): void
    {
        $sharedObject = new stdClass();
        $sharedObject->id = 42;

        $array = new NewTypeArray([
            'ref1' => $sharedObject,
            'ref2' => $sharedObject // та же ссылка
        ]);

        $data = $array->getData();

        // Проверяем, что это один и тот же объект (по ссылке)
        $this->assertSame($data['ref1'], $data['ref2']);

        // Изменяем объект через возвращенный массив
        $data['ref1']->id = 100;

        // Проверяем, что изменение видно через исходный объект
        $this->assertEquals(100, $sharedObject->id);
        $this->assertEquals(100, $array->ref1->id);
        $this->assertEquals(100, $array->ref2->id);
    }

    /**
     * Tests getData() with nested CoverArray objects.
     *
     * This test ensures that when getData() is called on a CoverArray
     * containing other CoverArray objects, it returns those objects
     * as-is, maintaining the object hierarchy in the returned data.
     *
     *
     * Тестирование getData() с вложенными объектами CoverArray.
     *
     * Этот тест гарантирует, что при вызове getData() на CoverArray,
     * содержащем другие объекты CoverArray, он возвращает эти объекты
     * как есть, сохраняя иерархию объектов в возвращаемых данных.
     *
     * @see Simple::getData()
     */
    public function testGetDataWithNestedCoverArrays(): void
    {
        $innerCover = new NewTypeArray(['inner_key' => 'inner_value']);

        $array = new NewTypeArray([
            'cover' => $innerCover,
            'nested' => new NewTypeArray([
                'deep' => 'value'
            ])
        ]);

        $data = $array->getData();

        // Проверяем, что вложенные CoverArray возвращаются как объекты
        $this->assertInstanceOf(NewTypeArray::class, $data['cover']);
        $this->assertSame($innerCover, $data['cover']);

        $this->assertInstanceOf(NewTypeArray::class, $data['nested']);
        $this->assertEquals('value', $data['nested']->deep);
    }

    /**
     * Tests getData() with various data types.
     *
     * This test verifies that getData() correctly returns all
     * types of data stored in the CoverArray, including scalars,
     * CoverArray objects (for arrays), and other objects.
     *
     *
     * Тестирование getData() с различными типами данных.
     *
     * Этот тест проверяет, что getData() корректно возвращает все
     * типы данных, хранящиеся в CoverArray, включая скаляры,
     * объекты CoverArray (для массивов) и другие объекты.
     *
     * @see Simple::getData()
     */
    public function testGetDataWithVariousDataTypes(): void
    {
        $stdObject = new stdClass();
        $stdObject->property = 'value';

        $closure = function () {
            return 'test';
        };

        $array = new NewTypeArray([
            'string' => 'text',
            'int' => 42,
            'float' => 3.14,
            'bool_true' => true,
            'bool_false' => false,
            'null' => null,
            'object' => $stdObject,
            'closure' => $closure,
            'cover_array' => new NewTypeArray(['nested' => 'value'])
        ]);

        $data = $array->getData();

        // Проверяем все типы данных
        $this->assertEquals('text', $data['string']);
        $this->assertEquals(42, $data['int']);
        $this->assertEquals(3.14, $data['float']);
        $this->assertTrue($data['bool_true']);
        $this->assertFalse($data['bool_false']);
        $this->assertNull($data['null']);
        $this->assertSame($stdObject, $data['object']);
        $this->assertSame($closure, $data['closure']);
        $this->assertInstanceOf(NewTypeArray::class, $data['cover_array']);
    }

    /**
     * Tests getData() after data modifications.
     *
     * This test ensures that getData() returns the current state
     * of the internal data array, reflecting any modifications
     * made after the object was created.
     *
     *
     * Тестирование getData() после модификации данных.
     *
     * Этот тест гарантирует, что getData() возвращает текущее состояние
     * внутреннего массива данных, отражая любые модификации, сделанные
     * после создания объекта.
     *
     * @see Simple::getData()
     */
    public function testGetDataAfterDataModifications(): void
    {
        $array = new NewTypeArray(['initial' => 'value']);

        $initialData = $array->getData();
        $this->assertEquals(['initial' => 'value'], $initialData);

        // Модифицируем данные
        $array->newKey = 'new_value';
        $array->initial = 'modified_value';
        unset($array->initial);
        $array->anotherKey = [1, 2, 3]; // Будет преобразован в CoverArray

        $modifiedData = $array->getData();

        $this->assertArrayHasKey('newKey', $modifiedData);
        $this->assertArrayNotHasKey('initial', $modifiedData);
        $this->assertArrayHasKey('anotherKey', $modifiedData);

        $this->assertEquals('new_value', $modifiedData['newKey']);
        $this->assertInstanceOf(NewTypeArray::class, $modifiedData['anotherKey']);
        $this->assertEquals([1, 2, 3], $modifiedData['anotherKey']->getDataAsArray());
    }

    /**
     * Tests getData() preserves array keys exactly.
     *
     * This test verifies that getData() preserves all array keys
     * exactly as they are stored, including numeric keys, string
     * keys with special characters, and empty string keys.
     *
     *
     * Тестирование точного сохранения ключей массива в getData().
     *
     * Этот тест проверяет, что getData() сохраняет все ключи массива
     * точно так, как они хранятся, включая числовые ключи, строковые
     * ключи со специальными символами и пустые строковые ключи.
     *
     * @see Simple::getData()
     */
    public function testGetDataPreservesArrayKeysExactly(): void
    {
        $data = [
            0 => 'zero',
            1 => 'one',
            '2' => 'two_string_key',
            3 => 'three',
            'key with spaces' => 'value1',
            'key-with-dashes' => 'value2',
            'key.with.dots' => 'value3',
            '' => 'empty_key',
            'null' => null
        ];

        $array = new NewTypeArray($data);
        $returnedData = $array->getData();

        // Проверяем точное соответствие ключей
        $this->assertArrayHasKey(0, $returnedData);
        $this->assertArrayHasKey(1, $returnedData);
        $this->assertArrayHasKey('2', $returnedData);
        $this->assertArrayHasKey(3, $returnedData);
        $this->assertArrayHasKey('key with spaces', $returnedData);
        $this->assertArrayHasKey('key-with-dashes', $returnedData);
        $this->assertArrayHasKey('key.with.dots', $returnedData);
        $this->assertArrayHasKey('', $returnedData);
        $this->assertArrayHasKey('null', $returnedData);

        $this->assertCount(9, $returnedData);
    }

    /**
     * Tests getData() with large dataset.
     *
     * This test verifies that getData() performs efficiently
     * even with large datasets, returning the complete data
     * array without performance degradation.
     *
     *
     * Тестирование getData() с большим набором данных.
     *
     * Этот тест проверяет, что getData() выполняется эффективно
     * даже с большими наборами данных, возвращая полный массив
     * данных без деградации производительности.
     *
     * @see Simple::getData()
     */
    public function testGetDataWithLargeDataset(): void
    {
        $largeData = [];
        for ($i = 0; $i < 10000; $i++) {
            $largeData['key_' . $i] = 'value_' . $i;
        }

        $array = new NewTypeArray($largeData);

        $startTime = microtime(true);
        $returnedData = $array->getData();
        $endTime = microtime(true);

        $executionTime = $endTime - $startTime;

        // Проверяем, что все данные возвращены
        $this->assertCount(10000, $returnedData);
        $this->assertEquals('value_0', $returnedData['key_0']);
        $this->assertEquals('value_9999', $returnedData['key_9999']);

        // getData() должен быть быстрым
        $this->assertLessThan(0.1, $executionTime,
            'getData() should be fast even with large datasets');
    }

    /**
     * Tests getData() does not modify internal data.
     *
     * This test ensures that calling getData() does not modify
     * the internal data structure of the CoverArray object.
     * The method should be a simple getter without side effects.
     *
     *
     * Тестирование того, что getData() не модифицирует внутренние данные.
     *
     * Этот тест гарантирует, что вызов getData() не изменяет
     * внутреннюю структуру данных объекта CoverArray.
     * Метод должен быть простым геттером без побочных эффектов.
     *
     * @see Simple::getData()
     */
    public function testGetDataDoesNotModifyInternalData(): void
    {
        $array = new NewTypeArray([
            'key1' => 'value1',
            'key2' => [1, 2, 3],
            'key3' => new NewTypeArray(['nested' => 'value'])
        ]);

        // Многократный вызов getData()
        $data1 = $array->getData();
        $data2 = $array->getData();

        // Все вызовы должны возвращать те же данные
        $this->assertEquals($data1, $data2);

        // Изменение возвращенного массива не должно влиять на исходный объект
        $data1['key1'] = 'modified';

        $this->assertEquals('value1', $array->key1); // Исходное значение не изменилось
    }

    /**
     * Tests getData() with callable arrays are not converted.
     *
     * This test verifies that arrays that are callable (like [object, method])
     * are not converted to CoverArray objects when stored, and getData()
     * returns them as regular arrays.
     *
     *
     * Тестирование того, что callable-массивы не преобразуются в getData().
     *
     * Этот тест проверяет, что массивы, которые являются callable (например [object, method]),
     * не преобразуются в объекты CoverArray при сохранении, и getData()
     * возвращает их как обычные массивы.
     *
     * @see Simple::getData()
     * @see CoverArray::array2cover()
     */
    public function testGetDataWithCallableArrays(): void
    {
        $callableArray = [$this, 'testGetDataWithCallableArrays'];

        $array = new NewTypeArray([
            'callable' => $callableArray,
            'regular_array' => [1, 2, 3] // Этот будет преобразован в CoverArray
        ]);

        $data = $array->getData();

        // Callable-массив должен остаться массивом
        $this->assertIsArray($data['callable']);
        $this->assertIsCallable($data['callable']);
        $this->assertSame($callableArray, $data['callable']);

        // Обычный массив должен быть преобразован в CoverArray
        $this->assertInstanceOf(NewTypeArray::class, $data['regular_array']);
    }

    /**
     * Tests getData() with cyclic references.
     *
     * This test verifies that getData() handles cyclic references
     * correctly, returning the actual object references without
     * causing infinite recursion or memory issues.
     *
     *
     * Тестирование getData() с циклическими ссылками.
     *
     * Этот тест проверяет, что getData() корректно обрабатывает
     * циклические ссылки, возвращая фактические ссылки на объекты без
     * вызова бесконечной рекурсии или проблем с памятью.
     *
     * @see Simple::getData()
     */
    public function testGetDataWithCyclicReferences(): void
    {
        // Создаем циклическую ссылку
        $array1 = new NewTypeArray(['name' => 'array1']);
        $array2 = new NewTypeArray(['name' => 'array2']);

        $array1->reference = $array2;
        $array2->reference = $array1;

        $data1 = $array1->getData();
        $data2 = $array2->getData();

        // Проверяем, что ссылки сохранились
        $this->assertSame($array2, $data1['reference']);
        $this->assertSame($array1, $data2['reference']);

        // Проверяем, что это действительно циклическая ссылка
        $this->assertSame($array1, $data1['reference']->reference);
        $this->assertSame($array2, $data2['reference']->reference);
    }
}