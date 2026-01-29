<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class CountTest extends TestCase
{
    /**
     * Tests the count() method with basic array.
     *
     * This test verifies that the count() method correctly returns
     * the number of elements in the array,
     * mirroring PHP's count() function behavior.
     *
     *
     * Тестирование метода count() с базовым массивом.
     *
     * Этот тест проверяет, что метод count() корректно возвращает
     * количество элементов в массиве,
     * отражая поведение функции count() PHP.
     *
     * @see CoverArray::count()
     * @see count()
     */
    public function testCountWithBasicArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];
        $dataCopy = $data;

        $expected = count($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->count();

        // Check count
        $this->assertSame($expected, $result);
        $this->assertSame(3, $result);
    }

    /**
     * Tests the count() method with empty array.
     *
     * This test verifies that the count() method returns zero
     * for empty arrays,
     * mirroring PHP's count() function behavior.
     *
     *
     * Тестирование метода count() с пустым массивом.
     *
     * Этот тест проверяет, что метод count() возвращает ноль
     * для пустых массивов,
     * отражая поведение функции count() PHP.
     *
     * @see CoverArray::count()
     * @see count()
     */
    public function testCountWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $expected = count($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->count();

        // Check count is zero
        $this->assertSame($expected, $result);
        $this->assertSame(0, $result);
    }

    /**
     * Tests the count() method with single element.
     *
     * This test verifies that the count() method returns one
     * for single-element arrays,
     * mirroring PHP's count() function behavior.
     *
     *
     * Тестирование метода count() с одним элементом.
     *
     * Этот тест проверяет, что метод count() возвращает один
     * для массивов с одним элементом,
     * отражая поведение функции count() PHP.
     *
     * @see CoverArray::count()
     * @see count()
     */
    public function testCountWithSingleElement(): void
    {
        $data = [42];
        $dataCopy = $data;

        $expected = count($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->count();

        // Check count is one
        $this->assertSame($expected, $result);
        $this->assertSame(1, $result);
    }

    /**
     * Tests the count() method with string keys.
     *
     * This test verifies that the count() method correctly counts
     * elements in an associative array with string keys,
     * mirroring PHP's count() function behavior.
     *
     *
     * Тестирование метода count() со строковыми ключами.
     *
     * Этот тест проверяет, что метод count() корректно считает
     * элементы в ассоциативном массиве со строковыми ключами,
     * отражая поведение функции count() PHP.
     *
     * @see CoverArray::count()
     * @see count()
     */
    public function testCountWithStringKeys(): void
    {
        $data = ['first' => 'one', 'second' => 'two', 'third' => 'three'];
        $dataCopy = $data;

        $expected = count($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->count();

        // Check count
        $this->assertSame($expected, $result);
        $this->assertSame(3, $result);
    }

    /**
     * Tests the count() method with numeric keys.
     *
     * This test verifies that the count() method correctly counts
     * elements in an array with numeric keys,
     * mirroring PHP's count() function behavior.
     *
     *
     * Тестирование метода count() с числовыми ключами.
     *
     * Этот тест проверяет, что метод count() корректно считает
     * элементы в массиве с числовыми ключами,
     * отражая поведение функции count() PHP.
     *
     * @see CoverArray::count()
     * @see count()
     */
    public function testCountWithNumericKeys(): void
    {
        $data = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
        $dataCopy = $data;

        $expected = count($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->count();

        // Check count
        $this->assertSame($expected, $result);
        $this->assertSame(3, $result);
    }

    /**
     * Tests the count() method with mixed key types.
     *
     * This test verifies that the count() method correctly counts
     * elements in an array with mixed key types,
     * mirroring PHP's count() function behavior.
     *
     *
     * Тестирование метода count() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод count() корректно считает
     * элементы в массиве со смешанными типами ключей,
     * отражая поведение функции count() PHP.
     *
     * @see CoverArray::count()
     * @see count()
     */
    public function testCountWithMixedKeyTypes(): void
    {
        $data = [0 => 'zero', 'one' => 1, 2 => 'two', 'three' => 3];
        $dataCopy = $data;

        $expected = count($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->count();

        // Check count
        $this->assertSame($expected, $result);
        $this->assertSame(4, $result);
    }

    /**
     * Tests the count() method with large array.
     *
     * This test verifies that the count() method correctly counts
     * elements in a large array,
     * mirroring PHP's count() function behavior.
     *
     *
     * Тестирование метода count() с большим массивом.
     *
     * Этот тест проверяет, что метод count() корректно считает
     * элементы в большом массиве,
     * отражая поведение функции count() PHP.
     *
     * @see CoverArray::count()
     * @see count()
     */
    public function testCountWithLargeArray(): void
    {
        $data = range(1, 100);
        $dataCopy = $data;

        $expected = count($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->count();

        // Check count
        $this->assertSame($expected, $result);
        $this->assertSame(100, $result);
    }

    /**
     * Tests the count() method consistency.
     *
     * This test verifies that the count() method returns
     * the same value on multiple calls without modification,
     * mirroring PHP's count() function behavior.
     *
     *
     * Тестирование метода count() на консистентность.
     *
     * Этот тест проверяет, что метод count() возвращает
     * одно и то же значение при множественных вызовах без изменений,
     * отражая поведение функции count() PHP.
     *
     * @see CoverArray::count()
     * @see count()
     */
    public function testCountConsistency(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];

        $cover = new CoverArray($data);
        $result1 = $cover->count();
        $result2 = $cover->count();
        $result3 = $cover->count();

        // Check consistency
        $this->assertSame($result1, $result2);
        $this->assertSame($result2, $result3);
        $this->assertSame(5, $result1);
    }

    /**
     * Tests the count() method with nested arrays.
     *
     * This test verifies that the count() method counts
     * only top-level elements (non-recursive),
     * mirroring PHP's count() function default behavior.
     *
     *
     * Тестирование метода count() с вложенными массивами.
     *
     * Этот тест проверяет, что метод count() считает
     * только элементы верхнего уровня (нерекурсивно),
     * отражая поведение функции count() PHP по умолчанию.
     *
     * @see CoverArray::count()
     * @see count()
     */
    public function testCountWithNestedArrays(): void
    {
        $data = [
            'first' => ['a', 'b', 'c'],
            'second' => ['d', 'e'],
            'third' => 'f'
        ];
        $dataCopy = $data;

        $expected = count($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->count();

        // Check count (non-recursive)
        $this->assertSame($expected, $result);
        $this->assertSame(3, $result);
    }

    /**
     * Tests the count() method with Countable interface.
     *
     * This test verifies that the count() method works
     * with PHP's built-in count() function through Countable interface,
     * allowing CoverArray to be used with count().
     *
     *
     * Тестирование метода count() с интерфейсом Countable.
     *
     * Этот тест проверяет, что метод count() работает
     * с встроенной функцией count() PHP через интерфейс Countable,
     * позволяя использовать CoverArray с count().
     *
     * @see CoverArray::count()
     * @see count()
     */
    public function testCountWithCountableInterface(): void
    {
        $data = [1, 2, 3, 4, 5];

        $cover = new CoverArray($data);

        // Test direct method call
        $methodResult = $cover->count();

        // Test through count() function (Countable interface)
        $functionResult = count($cover);

        // Check both give same result
        $this->assertSame($methodResult, $functionResult);
        $this->assertSame(5, $methodResult);
        $this->assertSame(5, $functionResult);
    }
}
