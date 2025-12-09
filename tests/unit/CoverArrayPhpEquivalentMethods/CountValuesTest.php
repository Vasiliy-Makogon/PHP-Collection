<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class CountValuesTest extends TestCase
{
    /**
     * Tests the countValues() method (array_count_values equivalent).
     *
     * This test verifies that the countValues() method correctly counts
     * the occurrences of each value in the CoverArray, returning a new
     * CoverArray where keys are the original values and values are their counts.
     *
     *
     * Тестирование метода countValues() (эквивалент array_count_values).
     *
     * Этот тест проверяет, что метод countValues() корректно подсчитывает
     * количество вхождений каждого значения в CoverArray, возвращая новый
     * CoverArray, где ключи - это исходные значения, а значения - их количество.
     *
     * @see CoverArray::countValues()
     * @see array_count_values()
     */
    public function testCountValuesMethod(): void
    {
        // Test with simple array of strings
        // Тест с простым массивом строк
        $data = ['apple', 'banana', 'apple', 'orange', 'banana', 'apple'];

        $expected = array_count_values($data);

        // CoverArray method
        // метод CoverArray
        $cover = new CoverArray($data);
        $result = $cover->countValues();

        $this->assertSame($expected, $result->getDataAsArray());

        // Test with numbers
        // Тест с числами
        $data2 = [1, 2, 1, 3, 2, 1, 1];

        $expected2 = array_count_values($data2);

        // CoverArray method
        // метод CoverArray
        $cover2 = new CoverArray($data2);
        $result2 = $cover2->countValues();

        $this->assertSame($expected2, $result2->getDataAsArray());

        // Test with empty array
        // Тест с пустым массивом
        $data3 = [];

        $expected3 = array_count_values($data3);

        // CoverArray method
        // метод CoverArray
        $cover3 = new CoverArray($data3);
        $result3 = $cover3->countValues();

        $this->assertSame($expected3, $result3->getDataAsArray());

        // Test with mixed string and number values
        // Тест со смешанными строками и числами
        $data4 = ['apple', 1, 'banana', 1, 'apple', 2, 'apple'];

        $expected4 = array_count_values($data4);

        // CoverArray method
        // метод CoverArray
        $cover4 = new CoverArray($data4);
        $result4 = $cover4->countValues();

        $this->assertSame($expected4, $result4->getDataAsArray());
    }
}