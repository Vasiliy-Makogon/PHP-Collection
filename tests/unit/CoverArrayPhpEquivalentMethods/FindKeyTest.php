<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FindKeyTest extends TestCase
{
    /**
     * Tests the findKey() method (array_find_key equivalent).
     *
     * This test verifies that the findKey() method correctly returns the key
     * of the first element satisfying a callback function, or null if no
     * element matches, mirroring the behavior of the array_find_key() function.
     *
     *
     * Тестирование метода findKey() (эквивалент array_find_key).
     *
     * Этот тест проверяет, что метод findKey() корректно возвращает ключ
     * первого элемента, удовлетворяющего callback-функции, или null если
     * ни один элемент не соответствует, отражая поведение функции array_find_key().
     *
     * @see CoverArray::findKey()
     * @see array_find_key()
     */
    public function testFindKeyMethod(): void
    {
        // Test finding key of an element in array of numbers
        // Тест поиска ключа элемента в массиве чисел
        $data1 = [10, 20, 30, 40, 50];
        $cover1 = new CoverArray($data1);

        $this->assertSame(2, $cover1->findKey(function ($value, $key) {
            return $value === 30;
        }));

        $this->assertNull($cover1->findKey(function ($value, $key) {
            return $value === 100;
        }));

        // Test finding key of an element in associative array
        // Тест поиска ключа элемента в ассоциативном массиве
        $data2 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $cover2 = new CoverArray($data2);

        $this->assertSame('b', $cover2->findKey(function ($value, $key) {
            return $value === 'banana';
        }));

        $this->assertNull($cover2->findKey(function ($value, $key) {
            return $value === 'date';
        }));

        // Test finding key using key in callback
        // Тест поиска ключа с использованием ключа в callback
        $data3 = [5 => 'five', 10 => 'ten', 15 => 'fifteen'];
        $cover3 = new CoverArray($data3);

        $this->assertSame(10, $cover3->findKey(function ($value, $key) {
            return $key === 10;
        }));

        // Test with empty array
        // Тест с пустым массивом
        $data4 = [];
        $cover4 = new CoverArray($data4);

        $this->assertNull($cover4->findKey(function ($value, $key) {
            return $value === 'anything';
        }));

        // Test finding first key when multiple elements satisfy condition
        // Тест поиска первого ключа, когда несколько элементов удовлетворяют условию
        $data5 = ['x' => 1, 'y' => 2, 'z' => 3, 'w' => 4];
        $cover5 = new CoverArray($data5);

        $this->assertSame('y', $cover5->findKey(function ($value, $key) {
            return $value >= 2;
        }));

        // Test with callback that uses both value and key
        // Тест с callback, который использует и значение, и ключ
        $data6 = ['first' => 10, 'second' => 20, 'third' => 30];
        $cover6 = new CoverArray($data6);

        $this->assertSame('second', $cover6->findKey(function ($value, $key) {
            return $value > 15 && $key === 'second';
        }));

        // Test with callback that always returns false
        // Тест с callback, который всегда возвращает false
        $data7 = ['a' => 1, 'b' => 2, 'c' => 3];
        $cover7 = new CoverArray($data7);

        $this->assertNull($cover7->findKey(function ($value, $key) {
            return false;
        }));

        // Test with callback that always returns true (should return first key)
        // Тест с callback, который всегда возвращает true (должен вернуть первый ключ)
        $data8 = ['one' => 1, 'two' => 2, 'three' => 3];
        $cover8 = new CoverArray($data8);

        $this->assertSame('one', $cover8->findKey(function ($value, $key) {
            return true;
        }));

        // Test finding key with complex condition
        // Тест поиска ключа со сложным условием
        $data9 = ['item1' => 5, 'item2' => 12, 'item3' => 8, 'item4' => 15];
        $cover9 = new CoverArray($data9);

        $this->assertSame('item2', $cover9->findKey(function ($value, $key) {
            return $value % 2 === 0 && $value > 10;
        }));

        $this->assertNull($cover9->findKey(function ($value, $key) {
            return $value > 100;
        }));
    }
}