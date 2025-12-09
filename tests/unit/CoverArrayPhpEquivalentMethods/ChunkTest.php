<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ValueError;

#[CoversClass(CoverArray::class)]
class ChunkTest extends TestCase
{
    /**
     * Tests the chunk() method without preserving keys.
     *
     * This test verifies that the chunk() method correctly splits
     * the CoverArray into chunks of specified size without preserving
     * original keys, mirroring the behavior of PHP's array_chunk() function
     * with $preserve_keys set to false.
     *
     *
     * Тестирование метода chunk() без сохранения ключей.
     *
     * Этот тест проверяет, что метод chunk() корректно разбивает
     * CoverArray на части указанного размера без сохранения исходных ключей,
     * отражая поведение функции array_chunk() PHP с $preserve_keys установленным в false.
     *
     * @see CoverArray::chunk()
     * @see array_chunk()
     */
    public function testChunkWithoutPreservingKeys(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date', 'e' => 'elderberry'];

        $expected = array_chunk($data, 2, false);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->chunk(2, false)->getDataAsArray()
        );
    }

    /**
     * Tests the chunk() method preserving keys.
     *
     * This test verifies that the chunk() method correctly splits
     * the CoverArray into chunks of specified size while preserving
     * original keys, mirroring the behavior of PHP's array_chunk() function
     * with $preserve_keys set to true.
     *
     *
     * Тестирование метода chunk() с сохранением ключей.
     *
     * Этот тест проверяет, что метод chunk() корректно разбивает
     * CoverArray на части указанного размера с сохранением исходных ключей,
     * отражая поведение функции array_chunk() PHP с $preserve_keys установленным в true.
     *
     * @see CoverArray::chunk()
     * @see array_chunk()
     */
    public function testChunkPreservingKeys(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date', 'e' => 'elderberry'];

        $expected = array_chunk($data, 2, true);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->chunk(2, true)->getDataAsArray()
        );
    }

    /**
     * Tests the chunk() method with chunk size 3.
     *
     * This test verifies that the chunk() method correctly splits
     * the CoverArray into chunks of size 3, creating chunks of
     * different sizes if the array is not evenly divisible,
     * mirroring the behavior of PHP's array_chunk() function.
     *
     *
     * Тестирование метода chunk() с размером части 3.
     *
     * Этот тест проверяет, что метод chunk() корректно разбивает
     * CoverArray на части размером 3, создавая части разного размера,
     * если массив не делится равномерно, отражая поведение функции array_chunk() PHP.
     *
     * @see CoverArray::chunk()
     * @see array_chunk()
     */
    public function testChunkWithSizeThree(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date', 'e' => 'elderberry'];

        $expected = array_chunk($data, 3, false);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->chunk(3, false)->getDataAsArray()
        );
    }

    /**
     * Tests the chunk() method with chunk size larger than array.
     *
     * This test verifies that the chunk() method correctly handles
     * chunk sizes larger than the array, returning a single chunk
     * containing the entire array, mirroring the behavior of PHP's array_chunk() function.
     *
     *
     * Тестирование метода chunk() с размером части больше размера массива.
     *
     * Этот тест проверяет, что метод chunk() корректно обрабатывает
     * размеры частей, превышающие размер массива, возвращая одну часть,
     * содержащую весь массив, отражая поведение функции array_chunk() PHP.
     *
     * @see CoverArray::chunk()
     * @see array_chunk()
     */
    public function testChunkWithSizeLargerThanArray(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date', 'e' => 'elderberry'];

        $expected = array_chunk($data, 10, false);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->chunk(10, false)->getDataAsArray()
        );
    }

    /**
     * Tests the chunk() method with chunk size 1 and preserving keys.
     *
     * This test verifies that the chunk() method correctly splits
     * the CoverArray into chunks of size 1 while preserving keys,
     * creating one-element chunks, mirroring the behavior of PHP's array_chunk() function.
     *
     *
     * Тестирование метода chunk() с размером части 1 и сохранением ключей.
     *
     * Этот тест проверяет, что метод chunk() корректно разбивает
     * CoverArray на части размером 1 с сохранением ключей,
     * создавая одноэлементные части, отражая поведение функции array_chunk() PHP.
     *
     * @see CoverArray::chunk()
     * @see array_chunk()
     */
    public function testChunkWithSizeOneAndPreservingKeys(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date', 'e' => 'elderberry'];

        $expected = array_chunk($data, 1, true);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->chunk(1, true)->getDataAsArray()
        );
    }

    /**
     * Tests the chunk() method exception for invalid chunk size (0).
     *
     * This test verifies that the chunk() method throws a ValueError
     * when an invalid chunk size (0) is provided, mirroring the behavior
     * of PHP's array_chunk() function.
     *
     *
     * Тестирование исключения метода chunk() для недопустимого размера части (0).
     *
     * Этот тест проверяет, что метод chunk() выбрасывает ValueError
     * при указании недопустимого размера части (0), отражая поведение
     * функции array_chunk() PHP.
     *
     * @see CoverArray::chunk()
     * @see array_chunk()
     */
    public function testChunkThrowsValueErrorForSizeZero(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date', 'e' => 'elderberry'];
        $cover = new CoverArray($data);

        $this->expectException(ValueError::class);
        $cover->chunk(0, false);
    }

    /**
     * Tests the chunk() method with numeric indexed array.
     *
     * This test verifies that the chunk() method correctly handles
     * numerically indexed arrays, splitting them into chunks,
     * mirroring the behavior of PHP's array_chunk() function.
     *
     *
     * Тестирование метода chunk() с числовым индексным массивом.
     *
     * Этот тест проверяет, что метод chunk() корректно обрабатывает
     * числовые индексные массивы, разбивая их на части,
     * отражая поведение функции array_chunk() PHP.
     *
     * @see CoverArray::chunk()
     * @see array_chunk()
     */
    public function testChunkWithNumericIndexedArray(): void
    {
        $data = ['apple', 'banana', 'cherry', 'date', 'elderberry'];

        $expected = array_chunk($data, 2, false);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->chunk(2, false)->getDataAsArray()
        );
    }

    /**
     * Tests the chunk() method with empty array.
     *
     * This test verifies that the chunk() method correctly handles
     * empty arrays, returning an empty array without errors,
     * mirroring the behavior of PHP's array_chunk() function.
     *
     *
     * Тестирование метода chunk() с пустым массивом.
     *
     * Этот тест проверяет, что метод chunk() корректно обрабатывает
     * пустые массивы, возвращая пустой массив без ошибок,
     * отражая поведение функции array_chunk() PHP.
     *
     * @see CoverArray::chunk()
     * @see array_chunk()
     */
    public function testChunkWithEmptyArray(): void
    {
        $data = [];

        $expected = array_chunk($data, 2, false);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->chunk(2, false)->getDataAsArray()
        );
    }
}