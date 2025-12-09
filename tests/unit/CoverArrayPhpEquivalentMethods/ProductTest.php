<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ProductTest extends TestCase
{
    /**
     * Tests the product() method (array_product equivalent).
     *
     * This test verifies that the product() method correctly calculates
     * the product of array values, mirroring PHP's array_product() function.
     * It tests various scenarios including integers, floats, strings,
     * booleans, null values, and edge cases like empty arrays and zero values.
     *
     *
     * Тестирование метода product() (эквивалент array_product).
     *
     * Этот тест проверяет, что метод product() корректно вычисляет
     * произведение значений массива, отражая поведение функции array_product() PHP.
     * Он тестирует различные сценарии, включая целые числа, числа с плавающей точкой,
     * строки, булевы значения, null и граничные случаи, такие как пустые массивы и нулевые значения.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductMethod(): void
    {
        // Test with integers - product of integers
        $data1 = [2, 3, 4];
        $expected1 = array_product($data1);
        $cover1 = new CoverArray($data1);
        $this->assertSame($expected1, $cover1->product());

        // Test with floats - product of floating point numbers
        $data2 = [1.5, 2.5, 2.0];
        $expected2 = array_product($data2);
        $cover2 = new CoverArray($data2);
        $this->assertSame($expected2, $cover2->product());

        // Test with empty array (should return 1, not 0!)
        $data3 = [];
        $expected3 = array_product($data3);
        $cover3 = new CoverArray($data3);
        $this->assertSame($expected3, $cover3->product());

        // Test with single element
        $data4 = [5];
        $expected4 = array_product($data4);
        $cover4 = new CoverArray($data4);
        $this->assertSame($expected4, $cover4->product());

        // Test with negative numbers
        $data5 = [-2, 3, -4];
        $expected5 = array_product($data5);
        $cover5 = new CoverArray($data5);
        $this->assertSame($expected5, $cover5->product());

        // Test with zero value
        $data6 = [2, 3, 0, 5];
        $expected6 = array_product($data6);
        $cover6 = new CoverArray($data6);
        $this->assertSame($expected6, $cover6->product());

        // Test with string numbers (should be converted automatically)
        $data7 = ['2', '3', '4'];
        $expected7 = array_product($data7);
        $cover7 = new CoverArray($data7);
        $this->assertSame($expected7, $cover7->product());

        // Test with mixed numeric strings and numbers
        $data8 = ['2.5', 3, 4];
        $expected8 = array_product($data8);
        $cover8 = new CoverArray($data8);
        $this->assertSame($expected8, $cover8->product());

        // Test with non-numeric strings - returns 0 in PHP >= 8.3, with E_WARNING suppressed
        // Тест с нечисловыми строками - возвращает 0 в PHP >= 8.3, с подавленным E_WARNING
        $data9 = [2, 3, 'abc', 4];
        $expected9 = @array_product($data9); // 0
        $cover9 = new CoverArray($data9);
        $this->assertSame($expected9, $cover9->product());

        // Test with boolean values
        $data10 = [2, true, 3, false, 4];
        $expected10 = array_product($data10);
        $cover10 = new CoverArray($data10);
        $this->assertSame($expected10, $cover10->product());

        // Test with null values
        $data11 = [2, 3, null, 4];
        $expected11 = array_product($data11);
        $cover11 = new CoverArray($data11);
        $this->assertSame($expected11, $cover11->product());

        // Test with large numbers
        $data12 = [1000, 1000, 1000];
        $expected12 = array_product($data12);
        $cover12 = new CoverArray($data12);
        $this->assertSame($expected12, $cover12->product());

        // Test with associative array
        $data13 = ['a' => 2, 'b' => 3, 'c' => 4];
        $expected13 = array_product($data13);
        $cover13 = new CoverArray($data13);
        $this->assertSame($expected13, $cover13->product());

        // Test with numeric string with leading zeros
        $data14 = ['02', '03'];
        $expected14 = array_product($data14);
        $cover14 = new CoverArray($data14);
        $this->assertSame($expected14, $cover14->product());

        // Test with very small float numbers
        $data15 = [0.1, 0.2, 0.3];
        $expected15 = array_product($data15);
        $cover15 = new CoverArray($data15);
        $this->assertSame($expected15, $cover15->product());

        // Test that original array is not modified
        $data16 = [2, 3, 4];
        $expected16 = array_product($data16);
        $cover16 = new CoverArray($data16);
        $result = $cover16->product();
        $this->assertSame($expected16, $result);
        $this->assertSame([2, 3, 4], $cover16->getDataAsArray(), 'Original array should not be modified');
    }
}