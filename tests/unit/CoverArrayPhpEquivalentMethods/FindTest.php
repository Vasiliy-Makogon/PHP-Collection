<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FindTest extends TestCase
{
    /**
     * Tests the find() method (array_find equivalent).
     *
     * This test verifies that the find() method correctly returns the first
     * element satisfying a callback function, or null if no element matches,
     * mirroring the behavior of the array_find() function.
     *
     *
     * Тестирование метода find() (эквивалент array_find).
     *
     * Этот тест проверяет, что метод find() корректно возвращает первый
     * элемент, удовлетворяющий callback-функции, или null если ни один элемент не соответствует,
     * отражая поведение функции array_find().
     *
     * @see CoverArray::find()
     * @see array_find()
     */
    public function testFindMethod(): void
    {
        // Test finding an element in array of numbers
        // Тест поиска элемента в массиве чисел
        $data1 = [1, 3, 5, 7, 9];
        $cover1 = new CoverArray($data1);

        $this->assertSame(5, $cover1->find(function ($value, $key) {
            return $value > 4 && $key === 2;
        }));

        $this->assertNull($cover1->find(function ($value, $key) {
            return $value > 10;
        }));

        // Test finding an element in array of strings
        // Тест поиска элемента в массиве строк
        $data2 = ['apple', 'banana', 'cherry', 'date'];
        $cover2 = new CoverArray($data2);

        $this->assertSame('cherry', $cover2->find(function ($value, $key) {
            return str_starts_with($value, 'c');
        }));

        $this->assertNull($cover2->find(function ($value, $key) {
            return str_starts_with($value, 'z');
        }));

        // Test finding an element in associative array
        // Тест поиска элемента в ассоциативном массиве
        $data3 = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
        $cover3 = new CoverArray($data3);

        $this->assertSame(30, $cover3->find(function ($value, $key) {
            return $key === 'age' && $value > 20;
        }));

        $this->assertNull($cover3->find(function ($value, $key) {
            return $key === 'country';
        }));

        // Test with empty array
        // Тест с пустым массивом
        $data4 = [];
        $cover4 = new CoverArray($data4);

        $this->assertNull($cover4->find(function ($value, $key) {
            return $value === 'anything';
        }));

        // Test finding first element when multiple elements satisfy condition
        // Тест поиска первого элемента, когда несколько элементов удовлетворяют условию
        $data5 = [10, 20, 30, 40, 50];
        $cover5 = new CoverArray($data5);

        $this->assertSame(30, $cover5->find(function ($value, $key) {
            return $value >= 30;
        }));

        // Test with callback that uses both value and key
        // Тест с callback, который использует и значение, и ключ
        $data6 = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three'];
        $cover6 = new CoverArray($data6);

        $this->assertSame('two', $cover6->find(function ($value, $key) {
            return $key === 2 && strlen($value) === 3;
        }));

        // Test finding element that matches multiple conditions
        // Тест поиска элемента, соответствующего нескольким условиям
        $data7 = ['a' => 5, 'b' => 10, 'c' => 15, 'd' => 20];
        $cover7 = new CoverArray($data7);

        $this->assertSame(15, $cover7->find(function ($value, $key) {
            return $value % 5 === 0 && $value % 3 === 0;
        }));

        $this->assertNull($cover7->find(function ($value, $key) {
            return $value > 100;
        }));
    }
}