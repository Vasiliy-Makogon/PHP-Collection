<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ColumnTest extends TestCase
{
    /**
     * Tests the column() method (array_column equivalent).
     *
     * This test verifies that the column() method correctly returns
     * the values from a single column in the input array, with optional
     * index key specification, mirroring PHP's array_column() function.
     *
     *
     * Тестирование метода column() (эквивалент array_column).
     *
     * Этот тест проверяет, что метод column() корректно возвращает
     * значения из одного столбца входного массива, с опциональным
     * указанием ключа индекса, отражая функцию array_column() PHP.
     *
     * @see CoverArray::column()
     * @see array_column()
     */
    public function testColumnMethod(): void
    {
        $data = [
            ['id' => 2135, 'first_name' => 'John', 'last_name' => 'Doe'],
            ['id' => 3245, 'first_name' => 'Sally', 'last_name' => 'Smith'],
            ['id' => 5342, 'first_name' => 'Jane', 'last_name' => 'Jones'],
            ['id' => 5623, 'first_name' => 'Peter', 'last_name' => 'Doe']
        ];

        $cover = new CoverArray($data);

        // Test without index key
        // Тест без ключа индекса
        $expected1 = array_column($data, 'first_name');

        $this->assertSame(
            $expected1,
            $cover->column('first_name')->getDataAsArray()
        );

        // Test with index key
        // Тест с ключом индекса
        $expected2 = array_column($data, 'first_name', 'id');

        $this->assertSame(
            $expected2,
            $cover->column('first_name', 'id')->getDataAsArray()
        );

        // Test with null column key (returns array of nulls)
        // Тест с null в качестве ключа столбца (возвращает массив null)
        $expected3 = array_column($data, null, 'id');

        $this->assertSame(
            $expected3,
            $cover->column(null, 'id')->getDataAsArray()
        );

        // Test with both null column and index keys
        // Тест с null в качестве ключа столбца и индекса
        $expected4 = array_column($data, null);

        $this->assertSame(
            $expected4,
            $cover->column(null)->getDataAsArray()
        );
    }
}