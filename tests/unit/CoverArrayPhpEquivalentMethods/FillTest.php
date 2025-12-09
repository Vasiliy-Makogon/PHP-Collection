<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FillTest extends TestCase
{
    /**
     * Tests the fill() method (array_fill equivalent).
     *
     * This test verifies that the fill() static method correctly creates
     * a CoverArray filled with specified values starting from a given index,
     * mirroring PHP's array_fill() function behavior.
     *
     *
     * Тестирование метода fill() (эквивалент array_fill).
     *
     * Этот тест проверяет, что статический метод fill() корректно создает
     * CoverArray, заполненный указанными значениями, начиная с заданного индекса,
     * отражая поведение функции array_fill() PHP.
     *
     * @see CoverArray::fill()
     * @see array_fill()
     */
    public function testFillMethod(): void
    {
        // Test with positive start index
        // Тест с положительным начальным индексом
        $expected1 = [2 => 'foo', 3 => 'foo'];

        $this->assertSame(
            $expected1,
            CoverArray::fill(2, 2, 'foo')->getDataAsArray()
        );

        // Test with zero start index
        // Тест с нулевым начальным индексом
        $expected2 = [0 => 'bar', 1 => 'bar', 2 => 'bar'];

        $this->assertSame(
            $expected2,
            CoverArray::fill(0, 3, 'bar')->getDataAsArray()
        );

        // Test with negative start index
        // Тест с отрицательным начальным индексом
        $expected3 = [-2 => 'test', -1 => 'test', 0 => 'test'];

        $this->assertSame(
            $expected3,
            CoverArray::fill(-2, 3, 'test')->getDataAsArray()
        );

        // Test with count 0 (should return empty array)
        // Тест с количеством 0 (должен вернуть пустой массив)
        $expected4 = [];

        $this->assertSame(
            $expected4,
            CoverArray::fill(5, 0, 'value')->getDataAsArray()
        );

        // Test with integer value
        // Тест с целочисленным значением
        $expected5 = [0 => 42, 1 => 42, 2 => 42];

        $this->assertSame(
            $expected5,
            CoverArray::fill(0, 3, 42)->getDataAsArray()
        );

        // Test with array value
        // Тест со значением-массивом
        $arrayValue = ['a', 'b', 'c'];
        $expected6 = [0 => $arrayValue, 1 => $arrayValue];

        $this->assertSame(
            $expected6,
            CoverArray::fill(0, 2, $arrayValue)->getDataAsArray()
        );

        // Test with null value
        // Тест со значением null
        $expected7 = [1 => null, 2 => null, 3 => null];

        $this->assertSame(
            $expected7,
            CoverArray::fill(1, 3, null)->getDataAsArray()
        );

        // Test with boolean value
        // Тест с булевым значением
        $expected8 = [0 => true, 1 => true, 2 => true];

        $this->assertSame(
            $expected8,
            CoverArray::fill(0, 3, true)->getDataAsArray()
        );

        // Test with count 1
        // Тест с количеством 1
        $expected9 = [10 => 'single'];

        $this->assertSame(
            $expected9,
            CoverArray::fill(10, 1, 'single')->getDataAsArray()
        );
    }
}