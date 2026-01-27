<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ShiftTest extends TestCase
{
    /**
     * Tests the shift() method with indexed array.
     *
     * This test verifies that the shift() method correctly removes
     * and returns the first element from an indexed array,
     * mirroring PHP's array_shift() function.
     *
     *
     * Тестирование метода shift() с индексированным массивом.
     *
     * Этот тест проверяет, что метод shift() корректно удаляет
     * и возвращает первый элемент из индексированного массива,
     * отражая функцию array_shift() PHP.
     *
     * @see CoverArray::shift()
     * @see array_shift()
     */
    public function testShiftWithIndexedArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];
        $dataCopy = $data;

        $expectedValue = array_shift($dataCopy);
        $expectedArray = $dataCopy;

        $cover = new CoverArray($data);
        $result = $cover->shift();

        $this->assertSame($expectedValue, $result);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the shift() method with associative array.
     *
     * This test verifies that the shift() method correctly removes
     * and returns the first element from an associative array,
     * mirroring PHP's array_shift() function.
     *
     *
     * Тестирование метода shift() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод shift() корректно удаляет
     * и возвращает первый элемент из ассоциативного массива,
     * отражая функцию array_shift() PHP.
     *
     * @see CoverArray::shift()
     * @see array_shift()
     */
    public function testShiftWithAssociativeArray(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $dataCopy = $data;

        $expectedValue = array_shift($dataCopy);
        $expectedArray = $dataCopy;

        $cover = new CoverArray($data);
        $result = $cover->shift();

        $this->assertSame($expectedValue, $result);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the shift() method with empty array.
     *
     * This test verifies that the shift() method correctly returns
     * null when the array is empty,
     * mirroring PHP's array_shift() function.
     *
     *
     * Тестирование метода shift() с пустым массивом.
     *
     * Этот тест проверяет, что метод shift() корректно возвращает
     * null, когда массив пуст,
     * отражая функцию array_shift() PHP.
     *
     * @see CoverArray::shift()
     * @see array_shift()
     */
    public function testShiftWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $expectedValue = array_shift($dataCopy);

        $cover = new CoverArray($data);
        $result = $cover->shift();

        $this->assertSame($expectedValue, $result);
        $this->assertSame([], $cover->getDataAsArray());
    }

    /**
     * Tests the shift() method with single element array.
     *
     * This test verifies that the shift() method correctly removes
     * the only element from a single element array,
     * mirroring PHP's array_shift() function.
     *
     *
     * Тестирование метода shift() с массивом из одного элемента.
     *
     * Этот тест проверяет, что метод shift() корректно удаляет
     * единственный элемент из массива с одним элементом,
     * отражая функцию array_shift() PHP.
     *
     * @see CoverArray::shift()
     * @see array_shift()
     */
    public function testShiftWithSingleElementArray(): void
    {
        $data = ['only'];
        $dataCopy = $data;

        $expectedValue = array_shift($dataCopy);
        $expectedArray = $dataCopy;

        $cover = new CoverArray($data);
        $result = $cover->shift();

        $this->assertSame($expectedValue, $result);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the shift() method reindexes numeric keys.
     *
     * This test verifies that the shift() method correctly reindexes
     * numeric keys after removing the first element,
     * mirroring PHP's array_shift() function.
     *
     *
     * Тестирование метода shift() переиндексирует числовые ключи.
     *
     * Этот тест проверяет, что метод shift() корректно переиндексирует
     * числовые ключи после удаления первого элемента,
     * отражая функцию array_shift() PHP.
     *
     * @see CoverArray::shift()
     * @see array_shift()
     */
    public function testShiftReindexesNumericKeys(): void
    {
        $data = [10 => 'a', 20 => 'b', 30 => 'c'];
        $dataCopy = $data;

        $expectedValue = array_shift($dataCopy);
        $expectedArray = $dataCopy;

        $cover = new CoverArray($data);
        $result = $cover->shift();

        $this->assertSame($expectedValue, $result);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the shift() method with mixed keys.
     *
     * This test verifies that the shift() method correctly handles
     * arrays with mixed string and numeric keys,
     * mirroring PHP's array_shift() function.
     *
     *
     * Тестирование метода shift() со смешанными ключами.
     *
     * Этот тест проверяет, что метод shift() корректно обрабатывает
     * массивы со смешанными строковыми и числовыми ключами,
     * отражая функцию array_shift() PHP.
     *
     * @see CoverArray::shift()
     * @see array_shift()
     */
    public function testShiftWithMixedKeys(): void
    {
        $data = ['a' => 1, 0 => 2, 'b' => 3, 1 => 4];
        $dataCopy = $data;

        $expectedValue = array_shift($dataCopy);
        $expectedArray = $dataCopy;

        $cover = new CoverArray($data);
        $result = $cover->shift();

        $this->assertSame($expectedValue, $result);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the shift() method with null value as first element.
     *
     * This test verifies that the shift() method correctly returns
     * null when the first element is null,
     * mirroring PHP's array_shift() function.
     *
     *
     * Тестирование метода shift() со значением null в качестве первого элемента.
     *
     * Этот тест проверяет, что метод shift() корректно возвращает
     * null, когда первый элемент равен null,
     * отражая функцию array_shift() PHP.
     *
     * @see CoverArray::shift()
     * @see array_shift()
     */
    public function testShiftWithNullValueAsFirstElement(): void
    {
        $data = [null, 'second', 'third'];
        $dataCopy = $data;

        $expectedValue = array_shift($dataCopy);
        $expectedArray = $dataCopy;

        $cover = new CoverArray($data);
        $result = $cover->shift();

        $this->assertSame($expectedValue, $result);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the shift() method with array as first element.
     *
     * This test verifies that the shift() method correctly returns
     * an array when the first element is an array,
     * mirroring PHP's array_shift() function.
     *
     * Note: CoverArray converts nested arrays to CoverArray objects,
     * so the returned value is a CoverArray instance.
     *
     *
     * Тестирование метода shift() с массивом в качестве первого элемента.
     *
     * Этот тест проверяет, что метод shift() корректно возвращает
     * массив, когда первый элемент является массивом,
     * отражая функцию array_shift() PHP.
     *
     * Примечание: CoverArray конвертирует вложенные массивы в объекты CoverArray,
     * поэтому возвращаемое значение является экземпляром CoverArray.
     *
     * @see CoverArray::shift()
     * @see array_shift()
     */
    public function testShiftWithArrayAsFirstElement(): void
    {
        $data = [['nested' => 'array'], 'second', 'third'];
        $dataCopy = $data;

        $expectedValue = array_shift($dataCopy);
        $expectedArray = $dataCopy;

        $cover = new CoverArray($data);
        $result = $cover->shift();

        // CoverArray converts nested arrays to CoverArray objects
        // CoverArray конвертирует вложенные массивы в объекты CoverArray
        $this->assertInstanceOf(CoverArray::class, $result);
        $this->assertSame($expectedValue, $result->getDataAsArray());
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the shift() method called multiple times.
     *
     * This test verifies that the shift() method correctly removes
     * elements when called multiple times in sequence,
     * mirroring PHP's array_shift() function.
     *
     *
     * Тестирование метода shift() при многократном вызове.
     *
     * Этот тест проверяет, что метод shift() корректно удаляет
     * элементы при многократном последовательном вызове,
     * отражая функцию array_shift() PHP.
     *
     * @see CoverArray::shift()
     * @see array_shift()
     */
    public function testShiftCalledMultipleTimes(): void
    {
        $data = ['first', 'second', 'third'];
        $dataCopy = $data;

        $cover = new CoverArray($data);

        $this->assertSame(array_shift($dataCopy), $cover->shift());
        $this->assertSame(array_shift($dataCopy), $cover->shift());
        $this->assertSame(array_shift($dataCopy), $cover->shift());
        $this->assertSame(array_shift($dataCopy), $cover->shift()); // Should be null
    }
}
