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
     * Tests the chunk() method (array_chunk equivalent).
     *
     * This test verifies that the chunk() method correctly splits the CoverArray
     * into chunks of specified size, with optional key preservation,
     * mirroring the behavior of PHP's array_chunk() function.
     *
     *
     * Тестирование метода chunk() (эквивалент array_chunk).
     *
     * Этот тест проверяет, что метод chunk() корректно разбивает CoverArray
     * на части указанного размера, с опциональным сохранением ключей,
     * отражая поведение функции array_chunk() PHP.
     *
     * @see CoverArray::chunk()
     * @see array_chunk()
     */
    public function testChunkMethod(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date', 'e' => 'elderberry'];
        $cover = new CoverArray($data);

        // Test chunk without preserving keys
        // Тест разбиения без сохранения ключей
        $expected1 = array_chunk($data, 2, false);

        $this->assertSame(
            $expected1,
            $cover->chunk(2, false)->getDataAsArray()
        );

        // Test chunk preserving keys
        // Тест разбиения с сохранением ключей
        $expected2 = array_chunk($data, 2, true);

        $this->assertSame(
            $expected2,
            $cover->chunk(2, true)->getDataAsArray()
        );

        // Test chunk with size 3
        // Тест разбиения на размер 3
        $expected3 = array_chunk($data, 3, false);

        $this->assertSame(
            $expected3,
            $cover->chunk(3, false)->getDataAsArray()
        );

        // Test chunk with size larger than array
        // Тест разбиения на размер больше массива
        $expected4 = array_chunk($data, 10, false);

        $this->assertSame(
            $expected4,
            $cover->chunk(10, false)->getDataAsArray()
        );

        // Test chunk with size 1
        // Тест разбиения на размер 1
        $expected5 = array_chunk($data, 1, true);

        $this->assertSame(
            $expected5,
            $cover->chunk(1, true)->getDataAsArray()
        );

        // Test exception for invalid chunk size (0)
        // Тест исключения для недопустимого размера части (0)
        $this->expectException(ValueError::class);
        $cover->chunk(0, false);
    }
}