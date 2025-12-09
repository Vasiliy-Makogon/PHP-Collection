<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class AllTest extends TestCase
{
    /**
     * Tests the all() method (array_all equivalent).
     *
     * This test verifies that the all() method correctly checks if all
     * elements in the CoverArray satisfy the given callback function,
     * returning true only when all elements pass the condition.
     *
     *
     * Тестирование метода all() (эквивалент array_all).
     *
     * Этот тест проверяет, что метод all() корректно проверяет, удовлетворяют ли
     * все элементы в CoverArray заданной callback-функции,
     * возвращая true только когда все элементы удовлетворяют условию.
     *
     * @see CoverArray::all()
     * @see array_all()
     */
    public function testAllMethod(): void
    {
        // Test with array where all elements satisfy condition
        // Тест с массивом, где все элементы удовлетворяют условию
        $data1 = [2, 4, 6, 8, 10];
        $cover1 = new CoverArray($data1);

        $this->assertTrue($cover1->all(function ($value, $key) {
            return $value % 2 === 0; // все числа четные
        }));

        // Test with array where not all elements satisfy condition
        // Тест с массивом, где не все элементы удовлетворяют условию
        $data2 = [2, 4, 5, 8, 10];
        $cover2 = new CoverArray($data2);

        $this->assertFalse($cover2->all(function ($value, $key) {
            return $value % 2 === 0; // 5 не четное
        }));

        // Test with array of strings
        // Тест с массивом строк
        $data3 = ['apple', 'apricot', 'avocado'];
        $cover3 = new CoverArray($data3);

        $this->assertTrue($cover3->all(function ($value, $key) {
            return str_starts_with($value, 'a');
        }));

        $data4 = ['apple', 'banana', 'apricot'];
        $cover4 = new CoverArray($data4);

        $this->assertFalse($cover4->all(function ($value, $key) {
            return str_starts_with($value, 'a');
        }));

        // Test with associative array
        // Тест с ассоциативным массивом
        $data5 = ['a' => 1, 'b' => 2, 'c' => 3];
        $cover5 = new CoverArray($data5);

        $this->assertTrue($cover5->all(function ($value, $key) {
            return is_string($key) && is_int($value);
        }));

        // Test with empty array (should return true)
        // Тест с пустым массивом (должен вернуть true)
        $data6 = [];
        $cover6 = new CoverArray($data6);

        $this->assertTrue($cover6->all(function ($value, $key) {
            return $value > 10; // для пустого массива всегда true
        }));

        // Test with callback that checks both value and key
        // Тест с callback, который проверяет и значение, и ключ
        $data7 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $cover7 = new CoverArray($data7);

        $this->assertTrue($cover7->all(function ($value, $key) {
            return is_int($key) && is_string($value);
        }));

        $data8 = [0 => 'zero', 1 => 1, 2 => 'two'];
        $cover8 = new CoverArray($data8);

        $this->assertFalse($cover8->all(function ($value, $key) {
            return is_string($value);
        }));
    }
}