<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FirstTest extends TestCase
{
    /**
     * Tests the first() method (array_first equivalent).
     *
     * This test verifies that the first() method correctly returns the first
     * element of the array without affecting the internal array pointer,
     * returning null if the array is empty, mirroring the behavior of array_first().
     *
     *
     * Тестирование метода first() (эквивалент array_first).
     *
     * Этот тест проверяет, что метод first() корректно возвращает первый
     * элемент массива, не затрагивая внутренний указатель массива,
     * возвращая null, если массив пуст, отражая поведение функции array_first().
     *
     * @see CoverArray::first()
     */
    public function testFirstMethod(): void
    {
        // Test with sequential numeric array
        // Тест с последовательным числовым массивом
        $data1 = [10, 20, 30, 40];
        $cover1 = new CoverArray($data1);

        $this->assertSame(10, $cover1->first());

        // Test with associative array (preserving insertion order in PHP 7+)
        // Тест с ассоциативным массивом (сохраняется порядок вставки в PHP 7+)
        $data2 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $cover2 = new CoverArray($data2);

        $this->assertSame('apple', $cover2->first());

        // Test with empty array
        // Тест с пустым массивом
        $data3 = [];
        $cover3 = new CoverArray($data3);

        $this->assertNull($cover3->first());

        // Test with array containing null as first element
        // Тест с массивом, содержащим null в качестве первого элемента
        $data4 = [null, 'second', 'third'];
        $cover4 = new CoverArray($data4);

        $this->assertNull($cover4->first());

        // Test with array containing false as first element
        // Тест с массивом, содержащим false в качестве первого элемента
        $data5 = [false, true, true];
        $cover5 = new CoverArray($data5);

        $this->assertFalse($cover5->first());

        // Test with array containing zero as first element
        // Тест с массивом, содержащим 0 в качестве первого элемента
        $data6 = [0, 1, 2];
        $cover6 = new CoverArray($data6);

        $this->assertSame(0, $cover6->first());

        // Test with array containing empty string as first element
        // Тест с массивом, содержащим пустую строку в качестве первого элемента
        $data7 = ['', 'not empty', 'another'];
        $cover7 = new CoverArray($data7);

        $this->assertSame('', $cover7->first());

        // Test with mixed key types array
        // Тест с массивом со смешанными типами ключей
        $data8 = [0 => 'zero', 'one' => 1, 2 => 'two'];
        $cover8 = new CoverArray($data8);

        $this->assertSame('zero', $cover8->first());

        // Test that method doesn't affect array pointer (same result on multiple calls)
        // Тест, что метод не затрагивает указатель массива (одинаковый результат при нескольких вызовах)
        $data9 = ['first', 'second', 'third'];
        $cover9 = new CoverArray($data9);

        $this->assertSame('first', $cover9->first());
        $this->assertSame('first', $cover9->first()); // Second call should return same result
        $this->assertSame('first', $cover9->first()); // Third call should return same result

        // Test with array containing array as first element
        // Тест с массивом, содержащим массив в качестве первого элемента
        $nestedArray = ['nested' => 'value'];
        $data10 = [$nestedArray, 'simple', 123];
        $cover10 = new CoverArray($data10);

        // Since CoverArray converts nested arrays to CoverArray instances
        // Так как CoverArray преобразует вложенные массивы в экземпляры CoverArray
        $firstElement = $cover10->first();
        $this->assertInstanceOf(CoverArray::class, $firstElement);
        $this->assertSame($nestedArray, $firstElement->getDataAsArray());
    }
}