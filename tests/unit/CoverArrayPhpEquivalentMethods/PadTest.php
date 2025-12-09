<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class PadTest extends TestCase
{
    /**
     * Tests the pad() method (array_pad equivalent).
     *
     * This test verifies that the pad() method correctly pads
     * the CoverArray to the specified length with a given value,
     * mirroring PHP's array_pad() function behavior.
     *
     *
     * Тестирование метода pad() (эквивалент array_pad).
     *
     * Этот тест проверяет, что метод pad() корректно дополняет
     * CoverArray до указанной длины заданным значением,
     * отражая поведение функции array_pad() PHP.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadMethod(): void
    {
        // Test padding to the right (positive length)
        // Тест дополнения справа (положительная длина)
        $data1 = [1, 2, 3];
        $expected1 = array_pad($data1, 5, 0);

        $cover1 = new CoverArray($data1);

        $this->assertSame($expected1, $cover1->pad(5, 0)->getDataAsArray());

        // Test padding to the left (negative length)
        // Тест дополнения слева (отрицательная длина)
        $data2 = [1, 2, 3];
        $expected2 = array_pad($data2, -5, 0);

        $cover2 = new CoverArray($data2);

        $this->assertSame($expected2, $cover2->pad(-5, 0)->getDataAsArray());

        // Test with length smaller than array size (no padding)
        // Тест с длиной меньше размера массива (без дополнения)
        $data3 = [1, 2, 3, 4, 5];
        $expected3 = array_pad($data3, 3, 0);

        $cover3 = new CoverArray($data3);

        $this->assertSame($expected3, $cover3->pad(3, 0)->getDataAsArray());

        // Test with negative length smaller than array size (no padding)
        // Тест с отрицательной длиной меньше размера массива (без дополнения)
        $data4 = [1, 2, 3, 4, 5];
        $expected4 = array_pad($data4, -3, 0);

        $cover4 = new CoverArray($data4);

        $this->assertSame($expected4, $cover4->pad(-3, 0)->getDataAsArray());

        // Test with string values
        // Тест со строковыми значениями
        $data5 = ['a', 'b', 'c'];
        $expected5 = array_pad($data5, 5, 'default');

        $cover5 = new CoverArray($data5);

        $this->assertSame($expected5, $cover5->pad(5, 'default')->getDataAsArray());

        // Test with array as padding value
        // Тест с массивом в качестве значения для дополнения
        $data6 = [1, 2];
        $padValue = ['nested' => 'value'];
        $expected6 = array_pad($data6, 4, $padValue);

        $cover6 = new CoverArray($data6);

        $this->assertSame($expected6, $cover6->pad(4, $padValue)->getDataAsArray());

        // Test with null as padding value
        // Тест с null в качестве значения для дополнения
        $data7 = ['a', 'b'];
        $expected7 = array_pad($data7, 4, null);

        $cover7 = new CoverArray($data7);

        $this->assertSame($expected7, $cover7->pad(4, null)->getDataAsArray());

        // Test with empty array
        // Тест с пустым массивом
        $data8 = [];
        $expected8 = array_pad($data8, 3, 'fill');

        $cover8 = new CoverArray($data8);

        $this->assertSame($expected8, $cover8->pad(3, 'fill')->getDataAsArray());

        // Test with length 0
        // Тест с длиной 0
        $data9 = [1, 2, 3];
        $expected9 = array_pad($data9, 0, 0);

        $cover9 = new CoverArray($data9);

        $this->assertSame($expected9, $cover9->pad(0, 0)->getDataAsArray());

        // Test with associative array (keys are reindexed)
        // Тест с ассоциативным массивом (ключи переиндексируются)
        $data10 = ['a' => 1, 'b' => 2];
        $expected10 = array_pad($data10, 4, 0);

        $cover10 = new CoverArray($data10);

        $this->assertSame($expected10, $cover10->pad(4, 0)->getDataAsArray());

        // Test with mixed padding (left and right with same value)
        // Тест со смешанным дополнением (слева и справа одинаковым значением)
        $data11 = [1, 2, 3];
        $expected11 = array_pad($data11, 7, 'x');

        $cover11 = new CoverArray($data11);

        $this->assertSame($expected11, $cover11->pad(7, 'x')->getDataAsArray());
    }
}