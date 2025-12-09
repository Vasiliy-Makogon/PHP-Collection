<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FilterTest extends TestCase
{
    /**
     * Tests the filter() method (array_filter equivalent).
     *
     * This test verifies that the filter() method correctly filters elements
     * of the CoverArray using a callback function with different filtering modes,
     * mirroring PHP's array_filter() function behavior.
     *
     *
     * Тестирование метода filter() (эквивалент array_filter).
     *
     * Этот тест проверяет, что метод filter() корректно фильтрует элементы
     * CoverArray с использованием callback-функции с различными режимами фильтрации,
     * отражая поведение функции array_filter() PHP.
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterMethod(): void
    {
        // Test with callback that filters by value
        // Тест с callback, который фильтрует по значению
        $data1 = [1, 2, 3, 4, 5];
        $callback1 = function ($value) {
            return $value % 2 === 0; // только четные числа
        };

        $expected1 = array_filter($data1, $callback1);

        $cover1 = new CoverArray($data1);
        $this->assertSame(
            $expected1,
            $cover1->filter($callback1)->getDataAsArray()
        );

        // Test with callback that filters by key (ARRAY_FILTER_USE_KEY)
        // Тест с callback, который фильтрует по ключу (ARRAY_FILTER_USE_KEY)
        $data2 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $callback2 = function ($key) {
            return in_array($key, ['a', 'c']); // только ключи 'a' и 'c'
        };

        $expected2 = array_filter($data2, $callback2, ARRAY_FILTER_USE_KEY);

        $cover2 = new CoverArray($data2);
        $this->assertSame(
            $expected2,
            $cover2->filter($callback2, ARRAY_FILTER_USE_KEY)->getDataAsArray()
        );

        // Test with callback that filters by both value and key (ARRAY_FILTER_USE_BOTH)
        // Тест с callback, который фильтрует и по значению, и по ключу (ARRAY_FILTER_USE_BOTH)
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $callback3 = function ($value, $key) {
            return $value > 1 && $key !== 'c'; // значение > 1 и ключ не 'c'
        };

        $expected3 = array_filter($data3, $callback3, ARRAY_FILTER_USE_BOTH);

        $cover3 = new CoverArray($data3);
        $this->assertSame(
            $expected3,
            $cover3->filter($callback3, ARRAY_FILTER_USE_BOTH)->getDataAsArray()
        );

        // Test without callback (removes empty values) - excluding empty array to avoid PHP version differences
        // Тест без callback (удаляет пустые значения) - исключаем пустой массив, чтобы избежать различий между версиями PHP
        $data4 = [0 => 'a', 1 => false, 2 => null, 3 => '', 4 => 'b'];

        $expected4 = array_filter($data4);

        $cover4 = new CoverArray($data4);
        $this->assertSame(
            $expected4,
            $cover4->filter()->getDataAsArray()
        );

        // Test with callback that always returns false
        // Тест с callback, который всегда возвращает false
        $data5 = ['x' => 1, 'y' => 2, 'z' => 3];
        $callback5 = function ($value) {
            return false;
        };

        $expected5 = array_filter($data5, $callback5);

        $cover5 = new CoverArray($data5);
        $this->assertSame(
            $expected5,
            $cover5->filter($callback5)->getDataAsArray()
        );

        // Test with callback that always returns true
        // Тест с callback, который всегда возвращает true
        $data6 = ['x' => 1, 'y' => 2, 'z' => 3];
        $callback6 = function ($value) {
            return true;
        };

        $expected6 = array_filter($data6, $callback6);

        $cover6 = new CoverArray($data6);
        $this->assertSame(
            $expected6,
            $cover6->filter($callback6)->getDataAsArray()
        );

        // Test with empty array
        // Тест с пустым массивом
        $data7 = [];

        $expected7 = array_filter($data7);

        $cover7 = new CoverArray($data7);
        $this->assertSame(
            $expected7,
            $cover7->filter()->getDataAsArray()
        );

        // Test with array containing only falsey values (excluding empty array)
        // Тест с массивом, содержащим только ложные значения (исключая пустой массив)
        $data8 = [0, false, null, ''];

        $expected8 = array_filter($data8);

        $cover8 = new CoverArray($data8);
        $this->assertSame(
            $expected8,
            $cover8->filter()->getDataAsArray()
        );

        // Test with callback that uses only value (default mode)
        // Тест с callback, который использует только значение (режим по умолчанию)
        $data9 = [10, 20, 30, 40, 50];
        $callback9 = function ($value) {
            return $value > 25;
        };

        $expected9 = array_filter($data9, $callback9);

        $cover9 = new CoverArray($data9);
        $this->assertSame(
            $expected9,
            $cover9->filter($callback9)->getDataAsArray()
        );
    }
}