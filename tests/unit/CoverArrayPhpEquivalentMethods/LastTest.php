<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class LastTest extends TestCase
{
    /**
     * Tests the last() method (array_last equivalent).
     *
     * This test verifies that the last() method correctly returns
     * the last element of the CoverArray, or null for empty arrays,
     * providing convenient access to the final element.
     *
     *
     * Тестирование метода last() (эквивалент array_last).
     *
     * Этот тест проверяет, что метод last() корректно возвращает
     * последний элемент CoverArray, или null для пустых массивов,
     * предоставляя удобный доступ к конечному элементу.
     *
     * @see CoverArray::last()
     */
    public function testLastMethod(): void
    {
        // Test with sequential numeric array
        // Тест с последовательным числовым массивом
        $data1 = ['PHP', 'MySql'];

        // CoverArray method
        // метод CoverArray
        $cover1 = new CoverArray($data1);
        $this->assertSame('MySql', $cover1->last());

        // Test with associative array
        // Тест с ассоциативным массивом
        $data2 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];

        // CoverArray method
        // метод CoverArray
        $cover2 = new CoverArray($data2);
        $this->assertSame('cherry', $cover2->last());

        // Test with empty array
        // Тест с пустым массивом
        $data3 = [];

        // CoverArray method
        // метод CoverArray
        $cover3 = new CoverArray($data3);
        $this->assertNull($cover3->last());

        // Test with single element array
        // Тест с массивом из одного элемента
        $data4 = ['single' => 'element'];

        // CoverArray method
        // метод CoverArray
        $cover4 = new CoverArray($data4);
        $this->assertSame('element', $cover4->last());

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data5 = [0 => 'zero', 'a' => 'apple', 1 => 'one'];

        // CoverArray method
        // метод CoverArray
        $cover5 = new CoverArray($data5);
        $this->assertSame('one', $cover5->last());

        // Test with numeric keys not starting from 0
        // Тест с числовыми ключами, не начинающимися с 0
        $data6 = [5 => 'five', 10 => 'ten', 15 => 'fifteen'];

        // CoverArray method
        // метод CoverArray
        $cover6 = new CoverArray($data6);
        $this->assertSame('fifteen', $cover6->last());

        // Test with null value as last element
        // Тест с null значением в качестве последнего элемента
        $data7 = ['a' => 1, 'b' => null];

        // CoverArray method
        // метод CoverArray
        $cover7 = new CoverArray($data7);
        $this->assertNull($cover7->last());

        // Test with false value as last element
        // Тест со значением false в качестве последнего элемента
        $data8 = ['a' => true, 'b' => false];

        // CoverArray method
        // метод CoverArray
        $cover8 = new CoverArray($data8);
        $this->assertFalse($cover8->last());

        // Test with zero value as last element
        // Тест с нулевым значением в качестве последнего элемента
        $data9 = ['a' => 1, 'b' => 0];

        // CoverArray method
        // метод CoverArray
        $cover9 = new CoverArray($data9);
        $this->assertSame(0, $cover9->last());

        // Test with empty string as last element
        // Тест с пустой строкой в качестве последнего элемента
        $data10 = ['a' => 'not empty', 'b' => ''];

        // CoverArray method
        // метод CoverArray
        $cover10 = new CoverArray($data10);
        $this->assertSame('', $cover10->last());

        // Test that method doesn't affect array pointer (same result on multiple calls)
        // Тест, что метод не затрагивает указатель массива (одинаковый результат при нескольких вызовах)
        $data11 = ['first', 'second', 'third'];
        $cover11 = new CoverArray($data11);

        $this->assertSame('third', $cover11->last());
        $this->assertSame('third', $cover11->last()); // Second call should return same result
        $this->assertSame('third', $cover11->last()); // Third call should return same result
    }
}