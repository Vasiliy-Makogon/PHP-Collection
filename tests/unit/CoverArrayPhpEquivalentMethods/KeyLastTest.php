<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class KeyLastTest extends TestCase
{
    /**
     * Tests the keyLast() method (array_key_last equivalent).
     *
     * This test verifies that the keyLast() method correctly returns
     * the last key of the CoverArray, or null for empty arrays,
     * mirroring PHP's array_key_last() function behavior.
     *
     *
     * Тестирование метода keyLast() (эквивалент array_key_last).
     *
     * Этот тест проверяет, что метод keyLast() корректно возвращает
     * последний ключ CoverArray, или null для пустых массивов,
     * отражая поведение функции array_key_last() PHP.
     *
     * @see CoverArray::keyLast()
     * @see array_key_last()
     */
    public function testKeyLastMethod(): void
    {
        // Test with associative array
        // Тест с ассоциативным массивом
        $data1 = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk', 'street' => 'Kirov st.'];

        $expected1 = array_key_last($data1);

        // CoverArray method
        // метод CoverArray
        $cover1 = new CoverArray($data1);
        $this->assertSame($expected1, $cover1->keyLast());

        // Test with sequential numeric array
        // Тест с последовательным числовым массивом
        $data2 = [18, 8, 1982];

        $expected2 = array_key_last($data2);

        // CoverArray method
        // метод CoverArray
        $cover2 = new CoverArray($data2);
        $this->assertSame($expected2, $cover2->keyLast());

        // Test with empty array
        // Тест с пустым массивом
        $data3 = [];

        $expected3 = array_key_last($data3);

        // CoverArray method
        // метод CoverArray
        $cover3 = new CoverArray($data3);
        $this->assertSame($expected3, $cover3->keyLast());

        // Test with mixed keys array
        // Тест с массивом со смешанными ключами
        $data4 = [0 => 'zero', 'a' => 'apple', 1 => 'one', 'b' => 'banana'];

        $expected4 = array_key_last($data4);

        // CoverArray method
        // метод CoverArray
        $cover4 = new CoverArray($data4);
        $this->assertSame($expected4, $cover4->keyLast());

        // Test with single element array
        // Тест с массивом из одного элемента
        $data5 = ['single' => 'element'];

        $expected5 = array_key_last($data5);

        // CoverArray method
        // метод CoverArray
        $cover5 = new CoverArray($data5);
        $this->assertSame($expected5, $cover5->keyLast());

        // Test with numeric keys not starting from 0
        // Тест с числовыми ключами, не начинающимися с 0
        $data6 = [5 => 'five', 10 => 'ten', 15 => 'fifteen'];

        $expected6 = array_key_last($data6);

        // CoverArray method
        // метод CoverArray
        $cover6 = new CoverArray($data6);
        $this->assertSame($expected6, $cover6->keyLast());

        // Test with reordered array (should return last key in current order, not insertion order)
        // Тест с переупорядоченным массивом (должен вернуть последний ключ в текущем порядке, а не порядке вставки)
        $data7 = ['z' => 'last', 'a' => 'first', 'm' => 'middle'];

        $expected7 = array_key_last($data7);

        // CoverArray method
        // метод CoverArray
        $cover7 = new CoverArray($data7);
        $this->assertSame($expected7, $cover7->keyLast());
    }
}