<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class AnyTest extends TestCase
{
    /**
     * Tests the any() method (array_any equivalent).
     *
     * This test verifies that the any() method correctly checks if at least
     * one element in the CoverArray satisfies the given callback function,
     * returning true when any element passes the condition.
     *
     *
     * Тестирование метода any() (эквивалент array_any).
     *
     * Этот тест проверяет, что метод any() корректно проверяет, удовлетворяет ли
     * хотя бы один элемент в CoverArray заданной callback-функции,
     * возвращая true когда любой элемент удовлетворяет условию.
     *
     * @see CoverArray::any()
     * @see array_any()
     */
    public function testAnyMethod(): void
    {
        // Test with array of numbers
        // Тест с массивом чисел
        $data1 = [1, 2, 3, 4, 5];
        $cover1 = new CoverArray($data1);

        $this->assertTrue($cover1->any(function ($value, $key) {
            return $value > 3;
        }));

        $this->assertFalse($cover1->any(function ($value, $key) {
            return $value > 10;
        }));

        // Test with array of strings
        // Тест с массивом строк
        $data2 = ['apple', 'banana', 'cherry'];
        $cover2 = new CoverArray($data2);

        $this->assertTrue($cover2->any(function ($value, $key) {
            return $value === 'banana';
        }));

        $this->assertFalse($cover2->any(function ($value, $key) {
            return $value === 'orange';
        }));

        // Test with associative array
        // Тест с ассоциативным массивом
        $data3 = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
        $cover3 = new CoverArray($data3);

        $this->assertTrue($cover3->any(function ($value, $key) {
            return $key === 'age' && $value === 30;
        }));

        $this->assertFalse($cover3->any(function ($value, $key) {
            return $key === 'country' && $value === 'USA';
        }));

        // Test with empty array
        // Тест с пустым массивом
        $data4 = [];
        $cover4 = new CoverArray($data4);

        $this->assertFalse($cover4->any(function ($value, $key) {
            return $value === 'anything';
        }));

        // Test with callback that uses both value and key
        // Тест с callback, который использует и значение, и ключ
        $data5 = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
        $cover5 = new CoverArray($data5);

        $this->assertTrue($cover5->any(function ($value, $key) {
            return $key > 15 && strpos($value, 'tw') === 0;
        }));

        $this->assertFalse($cover5->any(function ($value, $key) {
            return $key > 40 || $value === 'forty';
        }));
    }
}