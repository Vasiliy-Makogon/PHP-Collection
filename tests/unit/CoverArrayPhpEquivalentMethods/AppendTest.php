<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class AppendTest extends TestCase
{
    /**
     * Tests the append() method with single element.
     *
     * This test verifies that the append() method correctly adds
     * a single element to the end of the CoverArray, matching
     * PHP's array_push() function behavior.
     *
     *
     * Тестирование метода append() с одним элементом.
     *
     * Этот тест проверяет, что метод append() корректно добавляет
     * один элемент в конец CoverArray, соответствуя поведению
     * функции array_push() PHP.
     *
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testAppendSingleElement(): void
    {
        // Test appending single element
        // Тест добавления одного элемента
        $data = [1, 2, 3];
        $expected = $data;
        array_push($expected, 4);

        $cover = new CoverArray($data);
        $cover->append(4);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the append() method with multiple elements.
     *
     * This test verifies that the append() method correctly adds
     * multiple elements to the end of the CoverArray, matching
     * PHP's array_push() function behavior.
     *
     *
     * Тестирование метода append() с несколькими элементами.
     *
     * Этот тест проверяет, что метод append() корректно добавляет
     * несколько элементов в конец CoverArray, соответствуя поведению
     * функции array_push() PHP.
     *
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testAppendMultipleElements(): void
    {
        // Test appending multiple elements
        // Тест добавления нескольких элементов
        $data = [1, 2, 3];
        $expected = $data;
        array_push($expected, 4, 5, 6);

        $cover = new CoverArray($data);
        $cover->append(4, 5, 6);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the append() method with different types.
     *
     * This test verifies that the append() method correctly handles
     * elements of different types (string, integer, boolean, null),
     * matching PHP's array_push() function behavior.
     *
     *
     * Тестирование метода append() с разными типами.
     *
     * Этот тест проверяет, что метод append() корректно обрабатывает
     * элементы разных типов (строка, целое число, boolean, null),
     * соответствуя поведению функции array_push() PHP.
     *
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testAppendWithDifferentTypes(): void
    {
        // Test appending with different types
        // Тест добавления с разными типами
        $data = ['a', 'b'];
        $expected = $data;
        array_push($expected, 'c', 1, true, null);

        $cover = new CoverArray($data);
        $cover->append('c', 1, true, null);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the append() method with array element.
     *
     * This test verifies that the append() method correctly converts
     * nested arrays to CoverArray instances when appending them,
     * unlike PHP's array_push() which adds arrays as-is.
     *
     *
     * Тестирование метода append() с элементом-массивом.
     *
     * Этот тест проверяет, что метод append() корректно преобразует
     * вложенные массивы в экземпляры CoverArray при их добавлении,
     * в отличие от array_push() PHP, который добавляет массивы как есть.
     *
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testAppendArrayElement(): void
    {
        // Test appending array (should be converted to CoverArray)
        // Тест добавления массива (должен быть преобразован в CoverArray)
        $data = [1, 2];
        $arrayValue = ['nested' => 'value'];

        $expected = $data;
        array_push($expected, $arrayValue);

        $cover = new CoverArray($data);
        $cover->append($arrayValue);

        // Проверяем первые два элемента
        $this->assertSame($expected[0], $cover->item(0));
        $this->assertSame($expected[1], $cover->item(1));

        // Проверяем, что третий элемент является CoverArray и содержит правильные данные
        $thirdElement = $cover->item(2);
        $this->assertInstanceOf(CoverArray::class, $thirdElement);
        $this->assertSame($arrayValue, $thirdElement->getDataAsArray());
    }

    /**
     * Tests the append() method with empty array.
     *
     * This test verifies that the append() method correctly adds
     * elements to an empty CoverArray, matching PHP's array_push()
     * function behavior.
     *
     *
     * Тестирование метода append() с пустым массивом.
     *
     * Этот тест проверяет, что метод append() корректно добавляет
     * элементы в пустой CoverArray, соответствуя поведению
     * функции array_push() PHP.
     *
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testAppendToEmptyArray(): void
    {
        // Test appending to empty array
        // Тест добавления в пустой массив
        $data = [];
        $expected = $data;
        array_push($expected, 'first', 'second');

        $cover = new CoverArray($data);
        $cover->append('first', 'second');

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the append() method with numeric string keys.
     *
     * This test verifies that the append() method correctly handles
     * arrays with numeric string keys, matching PHP's array_push()
     * function behavior which adds new elements with numeric indices.
     *
     *
     * Тестирование метода append() с числовыми строковыми ключами.
     *
     * Этот тест проверяет, что метод append() корректно обрабатывает
     * массивы с числовыми строковыми ключами, соответствуя поведению
     * функции array_push() PHP, которая добавляет новые элементы с числовыми индексами.
     *
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testAppendWithNumericStringKeys(): void
    {
        // Test appending with numeric string keys
        // Тест добавления с числовыми строковыми ключами
        $data = [0 => 'zero', 1 => 'one'];
        $expected = $data;
        array_push($expected, 'two', 'three');

        $cover = new CoverArray($data);
        $cover->append('two', 'three');

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the append() method returns same instance for chaining.
     *
     * This test verifies that the append() method returns the same
     * CoverArray instance, allowing for method chaining.
     *
     *
     * Тестирование, что метод append() возвращает тот же экземпляр для цепочек вызовов.
     *
     * Этот тест проверяет, что метод append() возвращает тот же экземпляр
     * CoverArray, позволяя создавать цепочки вызовов.
     *
     * @see CoverArray::append()
     */
    public function testAppendReturnsSameInstance(): void
    {
        // Test that method returns same instance (for chaining)
        // Тест, что метод возвращает тот же экземпляр (для цепочки вызовов)
        $data = [1, 2];
        $cover = new CoverArray($data);

        $returned = $cover->append(3);
        $this->assertSame($cover, $returned);
    }

    /**
     * Tests chaining append() method calls.
     *
     * This test verifies that multiple append() calls can be chained
     * together, producing the correct final array.
     *
     *
     * Тестирование цепочки вызовов метода append().
     *
     * Этот тест проверяет, что несколько вызовов append() могут быть
     * объединены в цепочку, создавая правильный конечный массив.
     *
     * @see CoverArray::append()
     */
    public function testChainingAppendCalls(): void
    {
        // Test chaining append calls
        // Тест цепочки вызовов append
        $data = [1];
        $expected = $data;
        array_push($expected, 2, 3, 4, 5);

        $cover = new CoverArray($data);
        $cover->append(2)->append(3, 4)->append(5);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the append() method with associative array.
     *
     * This test verifies that the append() method correctly handles
     * associative arrays by adding new elements with numeric indices,
     * matching PHP's array_push() function behavior.
     *
     *
     * Тестирование метода append() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод append() корректно обрабатывает
     * ассоциативные массивы, добавляя новые элементы с числовыми индексами,
     * соответствуя поведению функции array_push() PHP.
     *
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testAppendWithAssociativeArray(): void
    {
        // Test appending with associative array (push reindexes numeric keys)
        // Тест добавления с ассоциативным массивом (push переиндексирует числовые ключи)
        $data = ['a' => 1, 'b' => 2];
        $expected = $data;
        array_push($expected, 3, 4);

        $cover = new CoverArray($data);
        $cover->append(3, 4);

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the append() method with false, 0, and empty string.
     *
     * This test verifies that the append() method correctly handles
     * edge case values like false, 0, and empty string, matching
     * PHP's array_push() function behavior.
     *
     *
     * Тестирование метода append() с false, 0 и пустой строкой.
     *
     * Этот тест проверяет, что метод append() корректно обрабатывает
     * граничные значения, такие как false, 0 и пустая строка,
     * соответствуя поведению функции array_push() PHP.
     *
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testAppendWithFalseZeroEmptyString(): void
    {
        // Test appending with false, 0, empty string
        // Тест добавления с false, 0, пустой строкой
        $data = ['first'];
        $expected = $data;
        array_push($expected, false, 0, '');

        $cover = new CoverArray($data);
        $cover->append(false, 0, '');

        $this->assertSame($expected, $cover->getDataAsArray());
    }
}