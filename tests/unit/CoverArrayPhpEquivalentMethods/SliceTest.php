<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class SliceTest extends TestCase
{
    /**
     * Tests the slice() method with positive offset.
     *
     * This test verifies that the slice() method correctly extracts
     * elements starting from a positive offset,
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() с положительным смещением.
     *
     * Этот тест проверяет, что метод slice() корректно извлекает
     * элементы, начиная с положительного смещения,
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithPositiveOffset(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];

        $expected = array_slice($data, 2);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->slice(2)->getDataAsArray());
    }

    /**
     * Tests the slice() method with negative offset.
     *
     * This test verifies that the slice() method correctly extracts
     * elements starting from a negative offset (from end),
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() с отрицательным смещением.
     *
     * Этот тест проверяет, что метод slice() корректно извлекает
     * элементы, начиная с отрицательного смещения (с конца),
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithNegativeOffset(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];

        $expected = array_slice($data, -3);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->slice(-3)->getDataAsArray());
    }

    /**
     * Tests the slice() method with positive length.
     *
     * This test verifies that the slice() method correctly extracts
     * a specified number of elements,
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() с положительной длиной.
     *
     * Этот тест проверяет, что метод slice() корректно извлекает
     * указанное количество элементов,
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithPositiveLength(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];

        $expected = array_slice($data, 1, 3);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->slice(1, 3)->getDataAsArray());
    }

    /**
     * Tests the slice() method with negative length.
     *
     * This test verifies that the slice() method correctly excludes
     * elements from the end when negative length is specified,
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() с отрицательной длиной.
     *
     * Этот тест проверяет, что метод slice() корректно исключает
     * элементы с конца при указании отрицательной длины,
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithNegativeLength(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];

        $expected = array_slice($data, 1, -1);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->slice(1, -1)->getDataAsArray());
    }

    /**
     * Tests the slice() method with preserve_keys = true.
     *
     * This test verifies that the slice() method correctly preserves
     * numeric keys when preserve_keys is true,
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() с preserve_keys = true.
     *
     * Этот тест проверяет, что метод slice() корректно сохраняет
     * числовые ключи, когда preserve_keys равен true,
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithPreserveKeysTrue(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];

        $expected = array_slice($data, 2, 2, true);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->slice(2, 2, true)->getDataAsArray());
    }

    /**
     * Tests the slice() method with preserve_keys = false (default).
     *
     * This test verifies that the slice() method correctly reindexes
     * numeric keys when preserve_keys is false,
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() с preserve_keys = false (по умолчанию).
     *
     * Этот тест проверяет, что метод slice() корректно переиндексирует
     * числовые ключи, когда preserve_keys равен false,
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithPreserveKeysFalse(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];

        $expected = array_slice($data, 2, 2, false);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->slice(2, 2, false)->getDataAsArray());
    }

    /**
     * Tests the slice() method with associative array.
     *
     * This test verifies that the slice() method correctly handles
     * associative arrays (string keys are always preserved),
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод slice() корректно обрабатывает
     * ассоциативные массивы (строковые ключи всегда сохраняются),
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithAssociativeArray(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];

        $expected = array_slice($data, 1, 3);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->slice(1, 3)->getDataAsArray());
    }

    /**
     * Tests the slice() method with empty array.
     *
     * This test verifies that the slice() method correctly handles
     * an empty array,
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() с пустым массивом.
     *
     * Этот тест проверяет, что метод slice() корректно обрабатывает
     * пустой массив,
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithEmptyArray(): void
    {
        $data = [];

        $expected = array_slice($data, 0, 5);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->slice(0, 5)->getDataAsArray());
    }

    /**
     * Tests the slice() method with offset beyond array length.
     *
     * This test verifies that the slice() method correctly returns
     * an empty array when offset is beyond array length,
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() со смещением за пределами длины массива.
     *
     * Этот тест проверяет, что метод slice() корректно возвращает
     * пустой массив, когда смещение превышает длину массива,
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithOffsetBeyondArrayLength(): void
    {
        $data = ['a', 'b', 'c'];

        $expected = array_slice($data, 10);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->slice(10)->getDataAsArray());
    }

    /**
     * Tests the slice() method with zero offset and null length.
     *
     * This test verifies that the slice() method correctly returns
     * the entire array when offset is 0 and length is null,
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() с нулевым смещением и null длиной.
     *
     * Этот тест проверяет, что метод slice() корректно возвращает
     * весь массив, когда смещение равно 0 и длина равна null,
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithZeroOffsetAndNullLength(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];

        $expected = array_slice($data, 0, null);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->slice(0, null)->getDataAsArray());
    }

    /**
     * Tests the slice() method with mixed keys and preserve_keys.
     *
     * This test verifies that the slice() method correctly handles
     * arrays with mixed string and numeric keys,
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() со смешанными ключами и preserve_keys.
     *
     * Этот тест проверяет, что метод slice() корректно обрабатывает
     * массивы со смешанными строковыми и числовыми ключами,
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithMixedKeysAndPreserveKeys(): void
    {
        $data = ['a' => 1, 0 => 2, 'b' => 3, 1 => 4, 'c' => 5];

        $expectedWithPreserve = array_slice($data, 1, 3, true);
        $expectedWithoutPreserve = array_slice($data, 1, 3, false);

        $cover = new CoverArray($data);

        $this->assertSame($expectedWithPreserve, $cover->slice(1, 3, true)->getDataAsArray());
        $this->assertSame($expectedWithoutPreserve, $cover->slice(1, 3, false)->getDataAsArray());
    }

    /**
     * Tests the slice() method with negative offset and negative length.
     *
     * This test verifies that the slice() method correctly handles
     * both negative offset and negative length,
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() с отрицательным смещением и отрицательной длиной.
     *
     * Этот тест проверяет, что метод slice() корректно обрабатывает
     * и отрицательное смещение, и отрицательную длину,
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithNegativeOffsetAndNegativeLength(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];

        $expected = array_slice($data, -4, -1);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->slice(-4, -1)->getDataAsArray());
    }

    /**
     * Tests the slice() method with length zero.
     *
     * This test verifies that the slice() method correctly returns
     * an empty array when length is zero,
     * mirroring PHP's array_slice() function.
     *
     *
     * Тестирование метода slice() с нулевой длиной.
     *
     * Этот тест проверяет, что метод slice() корректно возвращает
     * пустой массив, когда длина равна нулю,
     * отражая функцию array_slice() PHP.
     *
     * @see CoverArray::slice()
     * @see array_slice()
     */
    public function testSliceWithZeroLength(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];

        $expected = array_slice($data, 2, 0);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->slice(2, 0)->getDataAsArray());
    }
}
