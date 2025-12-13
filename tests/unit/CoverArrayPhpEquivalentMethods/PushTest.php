<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class PushTest extends TestCase
{
    /**
     * Tests the push() method with single element.
     *
     * This test verifies that the push() method correctly adds
     * a single element to the end of the CoverArray, matching
     * PHP's array_push() function behavior.
     *
     *
     * Тестирование метода push() с одним элементом.
     *
     * Этот тест проверяет, что метод push() корректно добавляет
     * один элемент в конец CoverArray, соответствуя поведению
     * функции array_push() PHP.
     *
     * @see CoverArray::push()
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testPushSingleElement(): void
    {
        // Test pushing single element
        // Тест добавления одного элемента
        $data = [1, 2, 3];
        $expected = $data;
        array_push($expected, 4);

        $cover = new CoverArray($data);
        $cover->push(4);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the push() method with multiple elements.
     *
     * This test verifies that the push() method correctly adds
     * multiple elements to the end of the CoverArray, matching
     * PHP's array_push() function behavior.
     *
     *
     * Тестирование метода push() с несколькими элементами.
     *
     * Этот тест проверяет, что метод push() корректно добавляет
     * несколько элементов в конец CoverArray, соответствуя поведению
     * функции array_push() PHP.
     *
     * @see CoverArray::push()
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testPushMultipleElements(): void
    {
        // Test pushing multiple elements
        // Тест добавления нескольких элементов
        $data = [1, 2, 3];
        $expected = $data;
        array_push($expected, 4, 5, 6);

        $cover = new CoverArray($data);
        $cover->push(4, 5, 6);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests that push() is an alias for append().
     *
     * This test verifies that the push() method behaves identically
     * to the append() method, producing the same results.
     *
     *
     * Тестирование, что push() является псевдонимом для append().
     *
     * Этот тест проверяет, что метод push() ведет себя идентично
     * методу append(), производя те же результаты.
     *
     * @see CoverArray::push()
     * @see CoverArray::append()
     */
    public function testPushIsAliasForAppend(): void
    {
        // Test that push is an alias for append (same behavior)
        // Тест, что push является псевдонимом для append (одинаковое поведение)
        $data = ['a', 'b', 'c'];
        $expected = $data;
        array_push($expected, 'd', 'e');

        $coverAppend = new CoverArray($data);
        $coverPush = new CoverArray($data);

        $coverAppend->append('d', 'e');
        $coverPush->push('d', 'e');

        $this->assertSame($expected, $coverAppend->getDataAsArray());
        $this->assertSame($expected, $coverPush->getDataAsArray());
        $this->assertSame($coverAppend->getDataAsArray(), $coverPush->getDataAsArray());
    }

    /**
     * Tests the push() method with different types.
     *
     * This test verifies that the push() method correctly handles
     * elements of different types (string, float, null, boolean),
     * matching PHP's array_push() function behavior.
     *
     *
     * Тестирование метода push() с разными типами.
     *
     * Этот тест проверяет, что метод push() корректно обрабатывает
     * элементы разных типов (строка, число с плавающей точкой, null, boolean),
     * соответствуя поведению функции array_push() PHP.
     *
     * @see CoverArray::push()
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testPushWithDifferentTypes(): void
    {
        // Test pushing with different types
        // Тест добавления с разными типами
        $data = [1];
        $expected = $data;
        array_push($expected, 'string', 2.5, null, false);

        $cover = new CoverArray($data);
        $cover->push('string', 2.5, null, false);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the push() method with array element.
     *
     * This test verifies that the push() method correctly converts
     * nested arrays to CoverArray instances when pushing them,
     * unlike PHP's array_push() which adds arrays as-is.
     *
     *
     * Тестирование метода push() с элементом-массивом.
     *
     * Этот тест проверяет, что метод push() корректно преобразует
     * вложенные массивы в экземпляры CoverArray при их добавлении,
     * в отличие от array_push() PHP, который добавляет массивы как есть.
     *
     * @see CoverArray::push()
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testPushArrayElement(): void
    {
        // Test pushing array (should be converted to CoverArray)
        // Тест добавления массива (должен быть преобразован в CoverArray)
        $data = ['first'];
        $arrayValue = ['nested' => ['key' => 'value']];

        $expected = $data;
        array_push($expected, $arrayValue);

        $cover = new CoverArray($data);
        $cover->push($arrayValue);

        // Проверяем первый элемент
        $this->assertSame($expected[0], $cover->item(0));

        // Проверяем, что второй элемент является CoverArray и содержит правильные данные
        $secondElement = $cover->item(1);
        $this->assertInstanceOf(CoverArray::class, $secondElement);
        $this->assertSame($arrayValue, $secondElement->getDataAsArray());
    }

    /**
     * Tests the push() method with CoverArray element.
     *
     * This test verifies that the push() method correctly handles
     * CoverArray objects as elements, preserving them without
     * additional conversion.
     *
     *
     * Тестирование метода push() с элементом типа CoverArray.
     *
     * Этот тест проверяет, что метод push() корректно обрабатывает
     * объекты CoverArray как элементы, сохраняя их без дополнительного
     * преобразования.
     *
     * @see CoverArray::push()
     * @see CoverArray::append()
     */
    public function testPushCoverArrayElement(): void
    {
        // Test pushing CoverArray element
        // Тест добавления элемента типа CoverArray
        $data = ['first'];
        $coverArrayValue = new CoverArray(['nested' => ['key' => 'value']]);

        $expected = $data;
        array_push($expected, $coverArrayValue);

        $cover = new CoverArray($data);
        $cover->push($coverArrayValue);

        // Проверяем первый элемент
        $this->assertSame($expected[0], $cover->item(0));

        // Проверяем, что второй элемент является тем же объектом CoverArray
        $secondElement = $cover->item(1);
        $this->assertSame($coverArrayValue, $secondElement);
        $this->assertInstanceOf(CoverArray::class, $secondElement);
    }

    /**
     * Tests the push() method with empty array.
     *
     * This test verifies that the push() method correctly adds
     * elements to an empty CoverArray, matching PHP's array_push()
     * function behavior.
     *
     *
     * Тестирование метода push() с пустым массивом.
     *
     * Этот тест проверяет, что метод push() корректно добавляет
     * элементы в пустой CoverArray, соответствуя поведению
     * функции array_push() PHP.
     *
     * @see CoverArray::push()
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testPushToEmptyArray(): void
    {
        // Test pushing to empty array
        // Тест добавления в пустой массив
        $data = [];
        $expected = $data;
        array_push($expected, 'apple', 'banana', 'cherry');

        $cover = new CoverArray($data);
        $cover->push('apple', 'banana', 'cherry');

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the push() method returns same instance for chaining.
     *
     * This test verifies that the push() method returns the same
     * CoverArray instance, allowing for method chaining.
     *
     *
     * Тестирование, что метод push() возвращает тот же экземпляр для цепочек вызовов.
     *
     * Этот тест проверяет, что метод push() возвращает тот же экземпляр
     * CoverArray, позволяя создавать цепочки вызовов.
     *
     * @see CoverArray::push()
     * @see CoverArray::append()
     */
    public function testPushReturnsSameInstance(): void
    {
        // Test that method returns same instance (for chaining)
        // Тест, что метод возвращает тот же экземпляр (для цепочки вызовов)
        $data = [10, 20];
        $cover = new CoverArray($data);

        $returned = $cover->push(30);
        $this->assertSame($cover, $returned);
    }

    /**
     * Tests chaining push() method calls.
     *
     * This test verifies that multiple push() calls can be chained
     * together, producing the correct final array.
     *
     *
     * Тестирование цепочки вызовов метода push().
     *
     * Этот тест проверяет, что несколько вызовов push() могут быть
     * объединены в цепочку, создавая правильный конечный массив.
     *
     * @see CoverArray::push()
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testChainingPushCalls(): void
    {
        // Test chaining push calls
        // Тест цепочки вызовов push
        $data = ['start'];
        $expected = $data;
        array_push($expected, 'middle1', 'middle2', 'end1', 'end2');

        $cover = new CoverArray($data);
        $cover->push('middle1', 'middle2')->push('end1', 'end2');

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the push() method with associative array.
     *
     * This test verifies that the push() method correctly handles
     * associative arrays by adding new elements with numeric indices,
     * matching PHP's array_push() function behavior.
     *
     *
     * Тестирование метода push() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод push() корректно обрабатывает
     * ассоциативные массивы, добавляя новые элементы с числовыми индексами,
     * соответствуя поведению функции array_push() PHP.
     *
     * @see CoverArray::push()
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testPushWithAssociativeArray(): void
    {
        // Test pushing with associative array (keys are preserved for string keys, numeric reindexed)
        // Тест добавления с ассоциативным массивом (строковые ключи сохраняются, числовые переиндексируются)
        $data = ['a' => 'apple', 'b' => 'banana'];
        $expected = $data;
        array_push($expected, 'cherry', 'date');

        $cover = new CoverArray($data);
        $cover->push('cherry', 'date');

        $this->assertSame($expected, $cover->getDataAsArray());
    }
}