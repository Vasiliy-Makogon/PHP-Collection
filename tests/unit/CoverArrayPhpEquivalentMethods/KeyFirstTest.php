<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class KeyFirstTest extends TestCase
{
    /**
     * Tests the keyFirst() method (array_key_first equivalent).
     *
     * This test verifies that the keyFirst() method correctly returns
     * the first key of the CoverArray, or null for empty arrays,
     * mirroring PHP's array_key_first() function behavior.
     *
     *
     * Тестирование метода keyFirst() (эквивалент array_key_first).
     *
     * Этот тест проверяет, что метод keyFirst() корректно возвращает
     * первый ключ CoverArray, или null для пустых массивов,
     * отражая поведение функции array_key_first() PHP.
     *
     * @see CoverArray::keyFirst()
     * @see array_key_first()
     */
    public function testKeyFirstMethod(): void
    {
        // Test with associative array
        // Тест с ассоциативным массивом
        $data1 = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk', 'street' => 'Kirov st.'];

        $expected1 = array_key_first($data1);

        // CoverArray method
        // метод CoverArray
        $cover1 = new CoverArray($data1);
        $this->assertSame($expected1, $cover1->keyFirst());

        // Test with sequential numeric array
        // Тест с последовательным числовым массивом
        $data2 = [18, 8, 1982];

        $expected2 = array_key_first($data2);

        // CoverArray method
        // метод CoverArray
        $cover2 = new CoverArray($data2);
        $this->assertSame($expected2, $cover2->keyFirst());

        // Test with empty array
        // Тест с пустым массивом
        $data3 = [];

        $expected3 = array_key_first($data3);

        // CoverArray method
        // метод CoverArray
        $cover3 = new CoverArray($data3);
        $this->assertSame($expected3, $cover3->keyFirst());

        // Test with mixed keys array
        // Тест с массивом со смешанными ключами
        $data4 = [0 => 'zero', 'a' => 'apple', 1 => 'one', 'b' => 'banana'];

        $expected4 = array_key_first($data4);

        // CoverArray method
        // метод CoverArray
        $cover4 = new CoverArray($data4);
        $this->assertSame($expected4, $cover4->keyFirst());

        // Test with single element array
        // Тест с массивом из одного элемента
        $data5 = ['single' => 'element'];

        $expected5 = array_key_first($data5);

        // CoverArray method
        // метод CoverArray
        $cover5 = new CoverArray($data5);
        $this->assertSame($expected5, $cover5->keyFirst());
    }
}