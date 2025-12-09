<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FlipTest extends TestCase
{
    /**
     * Tests the flip() method (array_flip equivalent).
     *
     * This test verifies that the flip() method correctly exchanges
     * all keys with their associated values in the CoverArray,
     * mirroring PHP's array_flip() function behavior.
     *
     *
     * Тестирование метода flip() (эквивалент array_flip).
     *
     * Этот тест проверяет, что метод flip() корректно меняет местами
     * все ключи с их связанными значениями в CoverArray,
     * отражая поведение функции array_flip() PHP.
     *
     * @see CoverArray::flip()
     * @see array_flip()
     */
    public function testFlipMethod(): void
    {
        // Test with simple associative array
        // Тест с простым ассоциативным массивом
        $data1 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];

        $expected1 = array_flip($data1);

        $cover1 = new CoverArray($data1);
        $this->assertSame(
            $expected1,
            $cover1->flip()->getDataAsArray()
        );

        // Test with numeric keys (will become values)
        // Тест с числовыми ключами (станут значениями)
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two'];

        $expected2 = array_flip($data2);

        $cover2 = new CoverArray($data2);
        $this->assertSame(
            $expected2,
            $cover2->flip()->getDataAsArray()
        );

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3];

        $expected3 = array_flip($data3);

        $cover3 = new CoverArray($data3);
        $this->assertSame(
            $expected3,
            $cover3->flip()->getDataAsArray()
        );

        // Test with duplicate values (only last duplicate will be kept)
        // Тест с дублирующимися значениями (сохранится только последний дубликат)
        $data4 = ['x' => 'fruit', 'y' => 'fruit', 'z' => 'vegetable'];

        $expected4 = array_flip($data4);

        $cover4 = new CoverArray($data4);
        $this->assertSame(
            $expected4,
            $cover4->flip()->getDataAsArray()
        );

        // Test with empty array
        // Тест с пустым массивом
        $data5 = [];

        $expected5 = array_flip($data5);

        $cover5 = new CoverArray($data5);
        $this->assertSame(
            $expected5,
            $cover5->flip()->getDataAsArray()
        );

        // Test with numeric string values that become integer keys
        // Тест с числовыми строковыми значениями, которые становятся целочисленными ключами
        $data6 = ['one' => '1', 'two' => '2', 'three' => '3'];

        $expected6 = array_flip($data6);

        $cover6 = new CoverArray($data6);
        $this->assertSame(
            $expected6,
            $cover6->flip()->getDataAsArray()
        );

        // Test with values that are valid string and integer types
        // Тест со значениями, которые являются допустимыми строковыми и целочисленными типами
        $data7 = ['a' => 'apple', 'b' => 2, 'c' => '3'];

        $expected7 = array_flip($data7);

        $cover7 = new CoverArray($data7);
        $this->assertSame(
            $expected7,
            $cover7->flip()->getDataAsArray()
        );
    }
}