<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class UnshiftTest extends TestCase
{
    /**
     * Tests the unshift() method with single element.
     *
     * This test verifies that the unshift() method correctly prepends
     * a single element to the beginning of the array, modifying the original
     * array, mirroring PHP's array_unshift() function behavior.
     *
     *
     * Тестирование метода unshift() с одним элементом.
     *
     * Этот тест проверяет, что метод unshift() корректно добавляет
     * один элемент в начало массива, изменяя исходный массив,
     * отражая поведение функции array_unshift() PHP.
     *
     * @see CoverArray::unshift()
     * @see array_unshift()
     */
    public function testUnshiftWithSingleElement(): void
    {
        $data = ['b', 'c', 'd'];
        $dataCopy = $data;

        array_unshift($data, 'a');
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->unshift('a');

        // Check modified array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the unshift() method with multiple elements.
     *
     * This test verifies that the unshift() method correctly prepends
     * multiple elements to the beginning of the array, preserving their order,
     * mirroring PHP's array_unshift() function behavior.
     *
     *
     * Тестирование метода unshift() с несколькими элементами.
     *
     * Этот тест проверяет, что метод unshift() корректно добавляет
     * несколько элементов в начало массива, сохраняя их порядок,
     * отражая поведение функции array_unshift() PHP.
     *
     * @see CoverArray::unshift()
     * @see array_unshift()
     */
    public function testUnshiftWithMultipleElements(): void
    {
        $data = ['d', 'e'];
        $dataCopy = $data;

        array_unshift($data, 'a', 'b', 'c');
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->unshift('a', 'b', 'c');

        // Check modified array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the unshift() method with associative array.
     *
     * This test verifies that the unshift() method correctly prepends
     * elements to an associative array, reindexing numeric keys,
     * mirroring PHP's array_unshift() function behavior.
     *
     *
     * Тестирование метода unshift() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод unshift() корректно добавляет
     * элементы в ассоциативный массив, переиндексируя числовые ключи,
     * отражая поведение функции array_unshift() PHP.
     *
     * @see CoverArray::unshift()
     * @see array_unshift()
     */
    public function testUnshiftWithAssociativeArray(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana'];
        $dataCopy = $data;

        array_unshift($data, 'cherry');
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->unshift('cherry');

        // Check modified array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the unshift() method with empty array.
     *
     * This test verifies that the unshift() method correctly prepends
     * elements to an empty array,
     * mirroring PHP's array_unshift() function behavior.
     *
     *
     * Тестирование метода unshift() с пустым массивом.
     *
     * Этот тест проверяет, что метод unshift() корректно добавляет
     * элементы в пустой массив,
     * отражая поведение функции array_unshift() PHP.
     *
     * @see CoverArray::unshift()
     * @see array_unshift()
     */
    public function testUnshiftWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        array_unshift($data, 'a', 'b');
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->unshift('a', 'b');

        // Check modified array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the unshift() method with no arguments.
     *
     * This test verifies that the unshift() method correctly handles
     * being called with no arguments, leaving the array unchanged,
     * mirroring PHP's array_unshift() function behavior.
     *
     *
     * Тестирование метода unshift() без аргументов.
     *
     * Этот тест проверяет, что метод unshift() корректно обрабатывает
     * вызов без аргументов, оставляя массив неизменным,
     * отражая поведение функции array_unshift() PHP.
     *
     * @see CoverArray::unshift()
     * @see array_unshift()
     */
    public function testUnshiftWithNoArguments(): void
    {
        $data = ['a', 'b', 'c'];
        $dataCopy = $data;

        // array_unshift with no additional arguments keeps array unchanged
        $expected = $dataCopy;

        $cover = new CoverArray($dataCopy);
        $result = $cover->unshift();

        // Check array is unchanged
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the unshift() method with mixed types.
     *
     * This test verifies that the unshift() method correctly prepends
     * elements of different types to the array,
     * mirroring PHP's array_unshift() function behavior.
     *
     *
     * Тестирование метода unshift() со смешанными типами.
     *
     * Этот тест проверяет, что метод unshift() корректно добавляет
     * элементы разных типов в начало массива,
     * отражая поведение функции array_unshift() PHP.
     *
     * @see CoverArray::unshift()
     * @see array_unshift()
     */
    public function testUnshiftWithMixedTypes(): void
    {
        $data = ['existing'];
        $dataCopy = $data;

        array_unshift($data, 1, 'string', null, true, 3.14);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->unshift(1, 'string', null, true, 3.14);

        // Check modified array
        $this->assertSame($expected, $cover->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the unshift() method with array as element.
     *
     * This test verifies that the unshift() method correctly prepends
     * an array as a single element (nested array),
     * mirroring PHP's array_unshift() function behavior.
     *
     *
     * Тестирование метода unshift() с массивом как элементом.
     *
     * Этот тест проверяет, что метод unshift() корректно добавляет
     * массив как единичный элемент (вложенный массив),
     * отражая поведение функции array_unshift() PHP.
     *
     * @see CoverArray::unshift()
     * @see array_unshift()
     */
    public function testUnshiftWithArrayAsElement(): void
    {
        $data = ['b', 'c'];
        $dataCopy = $data;
        $nestedArray = ['x', 'y', 'z'];

        array_unshift($data, $nestedArray);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->unshift($nestedArray);

        // Check result matches PHP's array_unshift behavior
        $resultData = $cover->getDataAsArray();
        $this->assertSame($expected, $resultData);

        // Check structure
        $this->assertCount(3, $resultData);
        $this->assertSame($nestedArray, $resultData[0]);
        $this->assertSame('b', $resultData[1]);
        $this->assertSame('c', $resultData[2]);

        // Check that internally the nested array is stored as CoverArray
        $this->assertInstanceOf(CoverArray::class, $cover[0]);
        $this->assertSame($nestedArray, $cover[0]->getDataAsArray());

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the unshift() method reindexing numeric keys.
     *
     * This test verifies that the unshift() method reindexes numeric keys
     * after prepending elements,
     * mirroring PHP's array_unshift() function behavior.
     *
     *
     * Тестирование метода unshift() с переиндексацией числовых ключей.
     *
     * Этот тест проверяет, что метод unshift() переиндексирует числовые ключи
     * после добавления элементов в начало,
     * отражая поведение функции array_unshift() PHP.
     *
     * @see CoverArray::unshift()
     * @see array_unshift()
     */
    public function testUnshiftReindexingNumericKeys(): void
    {
        $data = [0 => 'a', 1 => 'b', 2 => 'c'];
        $dataCopy = $data;

        array_unshift($data, 'x', 'y');
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->unshift('x', 'y');

        // Check that numeric keys are reindexed
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame('x', $cover[0]);
        $this->assertSame('y', $cover[1]);
        $this->assertSame('a', $cover[2]);

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the unshift() method with large array.
     *
     * This test verifies that the unshift() method correctly handles
     * prepending to a large array,
     * mirroring PHP's array_unshift() function behavior.
     *
     *
     * Тестирование метода unshift() с большим массивом.
     *
     * Этот тест проверяет, что метод unshift() корректно обрабатывает
     * добавление в начало большого массива,
     * отражая поведение функции array_unshift() PHP.
     *
     * @see CoverArray::unshift()
     * @see array_unshift()
     */
    public function testUnshiftWithLargeArray(): void
    {
        $data = range(1, 100);
        $dataCopy = $data;

        array_unshift($data, 0);
        $expected = $data;

        $cover = new CoverArray($dataCopy);
        $result = $cover->unshift(0);

        // Check modified array
        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertCount(101, $cover);
        $this->assertSame(0, $cover[0]);
        $this->assertSame(1, $cover[1]);

        // Check that method returns $this
        $this->assertSame($cover, $result);
    }
}
