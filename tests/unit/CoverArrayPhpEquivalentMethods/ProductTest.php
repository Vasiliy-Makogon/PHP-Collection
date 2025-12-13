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
     * Tests the product() method with integers.
     *
     * This test verifies that the product() method correctly calculates
     * the product of integer array values, mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() с целыми числами.
     *
     * Этот тест проверяет, что метод product() корректно вычисляет
     * произведение целочисленных значений массива, отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithIntegers(): void
    {
        // Test with integers - product of integers
        // Тест с целыми числами - произведение целых чисел
        $data = [2, 3, 4];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with floats.
     *
     * This test verifies that the product() method correctly calculates
     * the product of floating point array values, mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() с числами с плавающей точкой.
     *
     * Этот тест проверяет, что метод product() корректно вычисляет
     * произведение значений массива с плавающей точкой, отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithFloats(): void
    {
        // Test with floats - product of floating point numbers
        // Тест с числами с плавающей точкой - произведение чисел с плавающей точкой
        $data = [1.5, 2.5, 2.0];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with empty array.
     *
     * This test verifies that the product() method correctly returns 1
     * for an empty array, mirroring PHP's array_product() function behavior.
     *
     *
     * Тестирование метода product() с пустым массивом.
     *
     * Этот тест проверяет, что метод product() корректно возвращает 1
     * для пустого массива, отражая поведение функции array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithEmptyArray(): void
    {
        // Test with empty array (should return 1, not 0!)
        // Тест с пустым массивом (должен вернуть 1, а не 0!)
        $data = [];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with single element.
     *
     * This test verifies that the product() method correctly returns
     * the single element for a one-element array, mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() с одним элементом.
     *
     * Этот тест проверяет, что метод product() корректно возвращает
     * единственный элемент для массива с одним элементом, отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithSingleElement(): void
    {
        // Test with single element
        // Тест с одним элементом
        $data = [5];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with negative numbers.
     *
     * This test verifies that the product() method correctly calculates
     * the product of negative array values, mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() с отрицательными числами.
     *
     * Этот тест проверяет, что метод product() корректно вычисляет
     * произведение отрицательных значений массива, отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithNegativeNumbers(): void
    {
        // Test with negative numbers
        // Тест с отрицательными числами
        $data = [-2, 3, -4];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with zero value.
     *
     * This test verifies that the product() method correctly returns 0
     * when any element in the array is zero, mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() с нулевым значением.
     *
     * Этот тест проверяет, что метод product() корректно возвращает 0,
     * когда любой элемент массива равен нулю, отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithZeroValue(): void
    {
        // Test with zero value
        // Тест с нулевым значением
        $data = [2, 3, 0, 5];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with string numbers.
     *
     * This test verifies that the product() method correctly converts
     * and calculates the product of string numeric values, mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() со строковыми числами.
     *
     * Этот тест проверяет, что метод product() корректно преобразует
     * и вычисляет произведение строковых числовых значений, отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithStringNumbers(): void
    {
        // Test with string numbers (should be converted automatically)
        // Тест со строковыми числами (должны быть преобразованы автоматически)
        $data = ['2', '3', '4'];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with mixed numeric strings and numbers.
     *
     * This test verifies that the product() method correctly handles
     * mixed string and numeric types, mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() со смешанными строковыми и числовыми значениями.
     *
     * Этот тест проверяет, что метод product() корректно обрабатывает
     * смешанные строковые и числовые типы, отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithMixedNumericStringsAndNumbers(): void
    {
        // Test with mixed numeric strings and numbers
        // Тест со смешанными строковыми и числовыми значениями
        $data = ['2.5', 3, 4];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with non-numeric strings.
     *
     * This test verifies that the product() method correctly handles
     * non-numeric strings by returning 0 and suppressing warnings,
     * mirroring PHP's array_product() function behavior when called with @.
     *
     *
     * Тестирование метода product() с нечисловыми строками.
     *
     * Этот тест проверяет, что метод product() корректно обрабатывает
     * нечисловые строки, возвращая 0 и подавляя предупреждения,
     * отражая поведение функции array_product() PHP при вызове с @.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithNonNumericStrings(): void
    {
        // Test with non-numeric strings - returns 0 in PHP >= 8.3, with E_WARNING suppressed
        // Тест с нечисловыми строками - возвращает 0 в PHP >= 8.3, с подавленным E_WARNING
        $data = [2, 3, 'abc', 4];
        $expected = @array_product($data); // 0
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with boolean values.
     *
     * This test verifies that the product() method correctly converts
     * boolean values to integers and calculates their product, mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() с булевыми значениями.
     *
     * Этот тест проверяет, что метод product() корректно преобразует
     * булевы значения в целые числа и вычисляет их произведение, отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithBooleanValues(): void
    {
        // Test with boolean values
        // Тест с булевыми значениями
        $data = [2, true, 3, false, 4];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with null values.
     *
     * This test verifies that the product() method correctly handles
     * null values by treating them as 0, mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() со значениями null.
     *
     * Этот тест проверяет, что метод product() корректно обрабатывает
     * значения null, рассматривая их как 0, отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithNullValues(): void
    {
        // Test with null values
        // Тест со значениями null
        $data = [2, 3, null, 4];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with large numbers.
     *
     * This test verifies that the product() method correctly handles
     * large numbers without overflow issues, mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() с большими числами.
     *
     * Этот тест проверяет, что метод product() корректно обрабатывает
     * большие числа без проблем с переполнением, отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithLargeNumbers(): void
    {
        // Test with large numbers
        // Тест с большими числами
        $data = [1000, 1000, 1000];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with associative array.
     *
     * This test verifies that the product() method correctly works
     * with associative arrays, ignoring keys and calculating product of values,
     * mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод product() корректно работает
     * с ассоциативными массивами, игнорируя ключи и вычисляя произведение значений,
     * отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithAssociativeArray(): void
    {
        // Test with associative array
        // Тест с ассоциативным массивом
        $data = ['a' => 2, 'b' => 3, 'c' => 4];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with numeric strings with leading zeros.
     *
     * This test verifies that the product() method correctly handles
     * numeric strings with leading zeros, mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() с числовыми строками с ведущими нулями.
     *
     * Этот тест проверяет, что метод product() корректно обрабатывает
     * числовые строки с ведущими нулями, отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithNumericStringsWithLeadingZeros(): void
    {
        // Test with numeric string with leading zeros
        // Тест с числовой строкой с ведущими нулями
        $data = ['02', '03'];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with very small float numbers.
     *
     * This test verifies that the product() method correctly calculates
     * the product of very small float numbers, mirroring PHP's array_product() function.
     *
     *
     * Тестирование метода product() с очень маленькими числами с плавающей точкой.
     *
     * Этот тест проверяет, что метод product() корректно вычисляет
     * произведение очень маленьких чисел с плавающей точкой, отражая функцию array_product() PHP.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithVerySmallFloatNumbers(): void
    {
        // Test with very small float numbers
        // Тест с очень маленькими числами с плавающей точкой
        $data = [0.1, 0.2, 0.3];
        $expected = array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }

    /**
     * Tests the product() method with CoverArray as value.
     *
     * This test verifies that the product() method correctly handles
     * CoverArray objects as values, treating them as arrays and potentially
     * causing warnings to be suppressed, mirroring PHP's array_product() function
     * with non-scalar values.
     *
     *
     * Тестирование метода product() со значением типа CoverArray.
     *
     * Этот тест проверяет, что метод product() корректно обрабатывает
     * объекты CoverArray как значения, рассматривая их как массивы и потенциально
     * вызывая подавление предупреждений, отражая функцию array_product() PHP
     * с нескалярными значениями.
     *
     * @see CoverArray::product()
     * @see array_product()
     */
    public function testProductWithCoverArrayValue(): void
    {
        // Test with CoverArray as value - non-scalar values return 0 with suppressed warning
        // Тест со значением типа CoverArray - нескалярные значения возвращают 0 с подавленным предупреждением
        $innerCover = new CoverArray([2, 3]);
        $data = [2, $innerCover, 4];

        $expected = @array_product($data);
        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->product());
    }
}