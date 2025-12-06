<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;
use RuntimeException;

#[CoversClass(CoverArray::class)]
class SetDataTest extends TestCase
{
    /**
     * Tests setData() with scalar values.
     *
     * This test verifies that the setData() method correctly sets
     * scalar values in the CoverArray object. The method should
     * add or update keys with the new data provided.
     *
     *
     * Тестирование setData() со скалярными значениями.
     *
     * Этот тест проверяет, что метод setData() корректно устанавливает
     * скалярные значения в объекте CoverArray. Метод должен добавлять
     * или обновлять ключи новыми предоставленными данными.
     *
     * @see CoverArray::setData()
     */
    public function testSetDataWithScalarValues(): void
    {
        $array = new NewTypeArray();

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

        $result = $array->setData($data);

        // Проверяем, что данные установлены
        $this->assertEquals('value', $array->string);
        $this->assertEquals(42, $array->int);
        $this->assertEquals(3.14, $array->float);
        $this->assertTrue($array->bool_true);
        $this->assertFalse($array->bool_false);
        $this->assertNull($array->null);
        $this->assertEquals(0, $array->zero);
        $this->assertEquals('', $array->empty_string);

        // Проверяем, что метод возвращает $this (для fluent interface)
        $this->assertSame($array, $result);
    }

    /**
     * Tests setData() with arrays converts them to CoverArray objects.
     *
     * This test ensures that when setData() receives arrays as values,
     * they are automatically converted to CoverArray objects through
     * the array2cover() method, creating a nested structure of
     * CoverArray objects.
     *
     *
     * Тестирование преобразования массивов в объекты CoverArray в setData().
     *
     * Этот тест гарантирует, что когда setData() получает массивы в качестве значений,
     * они автоматически преобразуются в объекты CoverArray через
     * метод array2cover(), создавая вложенную структуру из
     * объектов CoverArray.
     *
     * @see CoverArray::setData()
     * @see CoverArray::array2cover()
     */
    public function testSetDataConvertsArraysToCoverArrayObjects(): void
    {
        $array = new NewTypeArray();

        $data = [
            'simple' => 'value',
            'nested' => [
                'level1' => [
                    'level2' => [1, 2, 3]
                ]
            ],
            'list' => [1, 2, 3],
            'assoc' => ['a' => 1, 'b' => 2]
        ];

        $array->setData($data);

        // Проверяем, что массивы преобразованы в CoverArray
        $this->assertInstanceOf(NewTypeArray::class, $array->nested);
        $this->assertInstanceOf(NewTypeArray::class, $array->nested->level1);
        $this->assertInstanceOf(NewTypeArray::class, $array->nested->level1->level2);
        $this->assertInstanceOf(NewTypeArray::class, $array->list);
        $this->assertInstanceOf(NewTypeArray::class, $array->assoc);

        // Проверяем значения
        $this->assertEquals('value', $array->simple);
        $this->assertEquals([1, 2, 3], $array->nested->level1->level2->getDataAsArray());
        $this->assertEquals([1, 2, 3], $array->list->getDataAsArray());
        $this->assertEquals(['a' => 1, 'b' => 2], $array->assoc->getDataAsArray());
    }

    /**
     * Tests setData() with existing CoverArray objects preserves them.
     *
     * This test verifies that when setData() receives existing
     * CoverArray objects as values, they are not re-converted
     * (array2cover returns existing CoverArray objects as-is).
     *
     *
     * Тестирование сохранения существующих объектов CoverArray в setData().
     *
     * Этот тест проверяет, что когда setData() получает существующие
     * объекты CoverArray в качестве значений, они не преобразуются повторно
     * (array2cover возвращает существующие объекты CoverArray как есть).
     *
     * @see CoverArray::setData()
     * @see CoverArray::array2cover()
     */
    public function testSetDataPreservesExistingCoverArrayObjects(): void
    {
        $existingCover = new NewTypeArray(['existing' => 'data']);
        $anotherCover = new NewTypeArray(['another' => 'value']);

        $array = new NewTypeArray();

        $data = [
            'cover1' => $existingCover,
            'cover2' => $anotherCover,
            'nested' => [
                'inner_cover' => $existingCover // та же ссылка
            ]
        ];

        $array->setData($data);

        // Проверяем, что существующие объекты CoverArray не были клонированы
        $this->assertSame($existingCover, $array->cover1);
        $this->assertSame($anotherCover, $array->cover2);
        $this->assertSame($existingCover, $array->nested->inner_cover);

        // Изменяем данные через одну ссылку
        $array->cover1->existing = 'modified';

        // Проверяем, что изменение видно через все ссылки
        $this->assertEquals('modified', $existingCover->existing);
        $this->assertEquals('modified', $array->nested->inner_cover->existing);
    }

    /**
     * Tests setData() with objects (non-arrays) preserves them as-is.
     *
     * This test ensures that objects (other than arrays) passed to
     * setData() are stored as-is without conversion. Only arrays
     * are converted to CoverArray objects.
     *
     *
     * Тестирование сохранения объектов (не массивов) как есть в setData().
     *
     * Этот тест гарантирует, что объекты (кроме массивов), переданные в
     * setData(), хранятся как есть без преобразования. Только массивы
     * преобразуются в объекты CoverArray.
     *
     * @see CoverArray::setData()
     */
    public function testSetDataPreservesNonArrayObjects(): void
    {
        $stdObject = new stdClass();
        $stdObject->property = 'value';

        $closure = function () {
            return 'test';
        };
        $datetime = new \DateTime('2023-01-01');

        $array = new NewTypeArray();

        $data = [
            'object' => $stdObject,
            'closure' => $closure,
            'datetime' => $datetime,
            'callable_array' => [$this, 'testSetDataPreservesNonArrayObjects'] // массив-callable
        ];

        $array->setData($data);

        // Проверяем, что объекты сохранены как есть
        $this->assertSame($stdObject, $array->object);
        $this->assertSame($closure, $array->closure);
        $this->assertSame($datetime, $array->datetime);

        // Callable-массив должен быть сохранен как массив (не преобразован в CoverArray)
        $this->assertIsArray($array->callable_array);
        $this->assertIsCallable($array->callable_array);
    }

    /**
     * Tests setData() with empty iterable doesn't clear data.
     *
     * This test ensures that when setData() receives an empty
     * iterable (empty array or other empty iterable), it does NOT
     * clear existing data. Empty iterable means "no data to set",
     * not "clear all data".
     *
     *
     * Тестирование setData() с пустым итерируемым объектом не очищает данные.
     *
     * Этот тест гарантирует, что когда setData() получает пустой
     * итерируемый объект (пустой массив или другой пустой итерируемый объект),
     * он НЕ очищает существующие данные. Пустой итерируемый объект означает
     * "нет данных для установки", а не "очистить все данные".
     *
     * @see CoverArray::setData()
     */
    public function testSetDataWithEmptyIterableDoesNotClearData(): void
    {
        $array = new NewTypeArray(['existing' => 'value']);
        $this->assertCount(1, $array);

        // Пустой массив не должен ничего изменять
        $array->setData([]);
        $this->assertCount(1, $array);
        $this->assertEquals('value', $array->existing);

        // Пустой ArrayIterator не должен ничего изменять
        $array->setData(new \ArrayIterator([]));
        $this->assertCount(1, $array);
        $this->assertEquals('value', $array->existing);
    }

    /**
     * Tests setData() updates existing keys and adds new ones without removing others.
     *
     * This test verifies that setData() adds new keys and updates existing ones
     * without removing keys that are not present in the new data. The method
     * merges the new data with existing data, overwriting matching keys but
     * preserving non-matching ones.
     *
     *
     * Тестирование того, что setData() обновляет существующие ключи и добавляет новые без удаления других.
     *
     * Этот тест проверяет, что setData() добавляет новые ключи и обновляет существующие
     * без удаления ключей, которые отсутствуют в новых данных. Метод
     * объединяет новые данные с существующими, перезаписывая совпадающие ключи, но
     * сохраняя несовпадающие.
     *
     * @see CoverArray::setData()
     */
    public function testSetDataUpdatesAndAddsKeysWithoutRemovingOthers(): void
    {
        $array = new NewTypeArray([
            'old_key1' => 'old_value1',
            'old_key2' => 'old_value2',
            'old_key3' => 'old_value3',
            'nested' => new NewTypeArray(['old' => 'data'])
        ]);

        $this->assertCount(4, $array);
        $this->assertEquals('old_value1', $array->old_key1);
        $this->assertEquals('old_value2', $array->old_key2);
        $this->assertEquals('old_value3', $array->old_key3);
        $this->assertInstanceOf(NewTypeArray::class, $array->nested);

        // Обновляем некоторые ключи и добавляем новые
        $newData = [
            'old_key1' => 'updated_value1', // Обновляем существующий ключ
            'new_key1' => 'new_value1',     // Добавляем новый ключ
            'new_key2' => 'new_value2',     // Добавляем новый ключ
            'nested' => ['nested' => 'value'] // Заменяем объект на массив (будет преобразован в CoverArray)
        ];

        $array->setData($newData);

        // Старые ключи, которые не были обновлены, должны остаться
        $this->assertEquals('updated_value1', $array->old_key1); // Обновлен
        $this->assertEquals('old_value2', $array->old_key2);     // Не изменен
        $this->assertEquals('old_value3', $array->old_key3);     // Не изменен

        // Новые ключи должны быть добавлены
        $this->assertEquals('new_value1', $array->new_key1);
        $this->assertEquals('new_value2', $array->new_key2);

        // Вложенный объект был заменен новым CoverArray
        $this->assertInstanceOf(NewTypeArray::class, $array->nested);
        $this->assertEquals('value', $array->nested->nested);

        // Общее количество ключей: 6 (4 исходных + 2 новых, old_key1 обновлен, nested заменен)
        $this->assertCount(6, $array);
    }

    /**
     * Tests setData() with overlapping keys.
     *
     * This test ensures that when setData() receives data with keys that
     * already exist in the CoverArray, those keys are updated with the
     * new values, while non-overlapping keys remain unchanged.
     *
     *
     * Тестирование setData() с перекрывающимися ключами.
     *
     * Этот тест гарантирует, что когда setData() получает данные с ключами,
     * которые уже существуют в CoverArray, эти ключи обновляются новыми
     * значениями, в то время как неперекрывающиеся ключи остаются неизменными.
     *
     * @see CoverArray::setData()
     */
    public function testSetDataWithOverlappingKeys(): void
    {
        $array = new NewTypeArray([
            'key1' => 'original1',
            'key2' => 'original2',
            'key3' => 'original3',
            'key4' => 'original4'
        ]);

        $this->assertCount(4, $array);

        // Передаем данные с некоторыми существующими ключами и одним новым
        $array->setData([
            'key2' => 'updated2', // Существующий ключ
            'key3' => 'updated3', // Существующий ключ
            'key5' => 'new5'      // Новый ключ
        ]);

        // Проверяем обновления
        $this->assertEquals('original1', $array->key1); // Не изменен
        $this->assertEquals('updated2', $array->key2);  // Обновлен
        $this->assertEquals('updated3', $array->key3);  // Обновлен
        $this->assertEquals('original4', $array->key4); // Не изменен
        $this->assertEquals('new5', $array->key5);      // Добавлен

        $this->assertCount(5, $array);
    }

    /**
     * Tests setData() with various key types.
     *
     * This test ensures that setData() correctly handles all types
     * of array keys, including numeric keys, string numeric keys,
     * and keys with special characters.
     *
     *
     * Тестирование setData() с различными типами ключей.
     *
     * Этот тест гарантирует, что setData() корректно обрабатывает все типы
     * ключей массива, включая числовые ключи, строковые числовые ключи
     * и ключи со специальными символами.
     *
     * @see CoverArray::setData()
     */
    public function testSetDataWithVariousKeyTypes(): void
    {
        $array = new NewTypeArray();

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

        $array->setData($data);

        // Проверяем доступ через ArrayAccess для всех ключей
        $this->assertEquals('zero', $array[0]);
        $this->assertEquals('one', $array[1]);
        $this->assertEquals('two_string_key', $array['2']);
        $this->assertEquals('three', $array[3]);
        $this->assertEquals('value1', $array['key with spaces']);
        $this->assertEquals('value2', $array['key-with-dashes']);
        $this->assertEquals('value3', $array['key.with.dots']);
        $this->assertEquals('empty_key', $array['']);
        $this->assertNull($array['null']);

        $this->assertCount(9, $array);
    }

    /**
     * Tests setData() with iterable objects (not arrays).
     *
     * This test verifies that setData() works correctly with
     * iterable objects other than arrays, such as ArrayIterator,
     * generators, and other Traversable objects.
     *
     *
     * Тестирование setData() с итерируемыми объектами (не массивами).
     *
     * Этот тест проверяет, что setData() корректно работает с
     * итерируемыми объектами, отличными от массивов, такими как ArrayIterator,
     * генераторы и другие Traversable-объекты.
     *
     * @see CoverArray::setData()
     */
    public function testSetDataWithIterableObjects(): void
    {
        $array = new NewTypeArray();

        // Тестируем с ArrayIterator
        $iterator = new \ArrayIterator([
            'key1' => 'value1',
            'key2' => 'value2',
            'nested' => ['inner' => 'value']
        ]);

        $array->setData($iterator);

        $this->assertEquals('value1', $array->key1);
        $this->assertEquals('value2', $array->key2);
        $this->assertInstanceOf(NewTypeArray::class, $array->nested);
        $this->assertEquals('value', $array->nested->inner);

        // Тестируем с генератором
        $generator = (function () {
            yield 'gen_key1' => 'gen_value1';
            yield 'gen_key2' => 'gen_value2';
            yield 'nested' => ['gen_inner' => 'gen_value'];
        })();

        $array->setData($generator);

        $this->assertEquals('gen_value1', $array->gen_key1);
        $this->assertEquals('gen_value2', $array->gen_key2);
        $this->assertInstanceOf(NewTypeArray::class, $array->nested);
        $this->assertEquals('gen_value', $array->nested->gen_inner);
    }

    /**
     * Tests setData() with deeply nested structures.
     *
     * This test verifies that setData() correctly handles deeply
     * nested arrays, converting all levels to CoverArray objects
     * through recursive array2cover calls.
     *
     *
     * Тестирование setData() с глубоко вложенными структурами.
     *
     * Этот тест проверяет, что setData() корректно обрабатывает глубоко
     * вложенные массивы, преобразуя все уровни в объекты CoverArray
     * через рекурсивные вызовы array2cover.
     *
     * @see CoverArray::setData()
     * @see CoverArray::array2cover()
     */
    public function testSetDataWithDeeplyNestedStructures(): void
    {
        $array = new NewTypeArray();

        // Создаем глубоко вложенную структуру
        $deepData = [];
        $current = &$deepData;

        for ($i = 0; $i < 5; $i++) {
            $current['level' . $i] = ['value' => $i, 'nested' => []];
            $current = &$current['level' . $i]['nested'];
        }
        $current['final'] = 'deep_value';

        $array->setData($deepData);

        // Проверяем, что структура правильно преобразована
        $this->assertInstanceOf(NewTypeArray::class, $array->level0);
        $this->assertEquals(0, $array->level0->value);

        $this->assertInstanceOf(NewTypeArray::class, $array->level0->nested->level1);
        $this->assertEquals(1, $array->level0->nested->level1->value);

        // Проверяем самый глубокий уровень
        $deepest = $array->level0->nested->level1->nested->level2->nested
            ->level3->nested->level4->nested;

        $this->assertInstanceOf(NewTypeArray::class, $deepest);
        $this->assertEquals('deep_value', $deepest->final);
    }

    /**
     * Tests setData() is used in constructor.
     *
     * This test verifies that the CoverArray constructor internally
     * uses setData() to initialize the object with provided data,
     * ensuring consistent behavior between constructor initialization
     * and manual setData() calls.
     *
     *
     * Тестирование использования setData() в конструкторе.
     *
     * Этот тест проверяет, что конструктор CoverArray внутренне
     * использует setData() для инициализации объекта предоставленными данными,
     * обеспечивая согласованное поведение между инициализацией конструктора
     * и ручными вызовами setData().
     *
     * @see CoverArray::__construct()
     * @see CoverArray::setData()
     */
    public function testSetDataIsUsedInConstructor(): void
    {
        $data = [
            'key1' => 'value1',
            'key2' => [1, 2, 3],
            'key3' => new NewTypeArray(['nested' => 'value'])
        ];

        // Создаем через конструктор
        $array1 = new NewTypeArray($data);

        // Создаем пустой и устанавливаем через setData
        $array2 = new NewTypeArray();
        $array2->setData($data);

        // Проверяем, что результаты одинаковы
        $this->assertEquals($array1->getDataAsArray(), $array2->getDataAsArray());

        // Проверяем конкретные значения
        $this->assertEquals('value1', $array1->key1);
        $this->assertEquals('value1', $array2->key1);

        $this->assertInstanceOf(NewTypeArray::class, $array1->key2);
        $this->assertInstanceOf(NewTypeArray::class, $array2->key2);

        $this->assertSame($data['key3'], $array1->key3);
        $this->assertSame($data['key3'], $array2->key3);
    }

    /**
     * Tests setData() throws exception when maximum recursion depth is exceeded.
     *
     * This test verifies that setData() correctly throws a RuntimeException
     * when processing nested arrays that exceed the maximum allowed depth
     * of 512 levels in the array2cover conversion method.
     *
     * The test creates an array with 513 levels of nesting, which triggers
     * depth=513 in array2cover's recursion, exceeding the maxDepth of 512.
     * This ensures proper handling of deeply nested structures to prevent
     * stack overflow or infinite recursion scenarios.
     *
     *
     * Тестирование выбрасывания исключения setData() при превышении максимальной глубины рекурсии.
     *
     * Этот тест проверяет, что setData() корректно выбрасывает RuntimeException
     * при обработке вложенных массивов, превышающих максимально допустимую глубину
     * в 512 уровней в методе преобразования array2cover.
     *
     * Тест создает массив с 513 уровнями вложенности, что вызывает depth=513
     * в рекурсии array2cover, превышая maxDepth=512. Это обеспечивает правильную
     * обработку глубоко вложенных структур для предотвращения переполнения стека
     * или сценариев бесконечной рекурсии.
     *
     * @see CoverArray::setData()
     * @see CoverArray::array2cover()
     * @see RuntimeException
     */
    public function testSetDataThrowsExceptionWhenDepthExceedsMax(): void
    {
        // Arrange: Create an array with 513 nesting levels
        $deepArray = [];
        $current = &$deepArray;
        for ($i = 0; $i <= 513; $i++) {
            $current['level'] = [];
            $current = &$current['level'];
        }

        $cover = new CoverArray();

        // Assert: Expect RuntimeException with specific message
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Maximum recursion depth exceeded');

        // Act: Attempt to set data with excessive nesting
        $cover->setData($deepArray);
    }

    /**
     * Tests setData() correctly handles maximum allowed nesting depth.
     *
     * This test verifies that setData() successfully processes arrays
     * with exactly 512 levels of nesting, which is the maximum allowed
     * depth in the array2cover conversion method.
     *
     * The test creates an array with 512 nesting levels and a final value,
     * ensuring that the conversion completes without exceptions and all
     * nested levels are properly converted to CoverArray objects while
     * preserving the structure and values.
     *
     *
     * Тестирование корректной обработки setData() максимально допустимой глубины вложенности.
     *
     * Этот тест проверяет, что setData() успешно обрабатывает массивы
     * ровно с 512 уровнями вложенности, что является максимально допустимой
     * глубиной в методе преобразования array2cover.
     *
     * Тест создает массив с 512 уровнями вложенности и конечным значением,
     * гарантируя, что преобразование завершается без исключений и все
     * вложенные уровни корректно преобразуются в объекты CoverArray
     * с сохранением структуры и значений.
     *
     * @see CoverArray::setData()
     * @see CoverArray::array2cover()
     * @see CoverArray::isEmpty()
     */
    public function testSetDataHandlesMaxDepthCorrectly(): void
    {
        // Arrange: Create an array with exactly 512 nesting levels
        $deepArray = [];
        $current = &$deepArray;
        for ($i = 0; $i < 512; $i++) {
            $current['level'] = [];
            $current = &$current['level'];
        }
        $current['final_value'] = 'success';

        $cover = new CoverArray();

        // Act: Set data with maximum allowed nesting
        $cover->setData($deepArray);

        // Assert: Verify data was processed without exceptions
        $this->assertFalse($cover->isEmpty(), 'CoverArray should not be empty after setData()');

        // Assert: Verify structure and type conversions
        $currentElement = $cover['level'];
        for ($i = 0; $i < 511; $i++) {
            $this->assertInstanceOf(
                CoverArray::class,
                $currentElement,
                sprintf('Element at depth %d should be CoverArray instance', $i + 1)
            );
            $currentElement = $currentElement['level'];
        }

        // Assert: Verify final value preservation
        $this->assertInstanceOf(CoverArray::class, $currentElement);
        $this->assertEquals('success', $currentElement['final_value'],
            'Final value should be preserved after deep conversion');
    }
}