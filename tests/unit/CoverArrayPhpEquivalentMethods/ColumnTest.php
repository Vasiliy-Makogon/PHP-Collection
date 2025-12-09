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
     * Tests the column() method without index key.
     *
     * This test verifies that the column() method correctly returns
     * the values from a single column in the input array without
     * using an index key, mirroring PHP's array_column() function
     * with only the column_key parameter.
     *
     *
     * Тестирование метода column() без ключа индекса.
     *
     * Этот тест проверяет, что метод column() корректно возвращает
     * значения из одного столбца входного массива без использования
     * ключа индекса, отражая функцию array_column() PHP
     * только с параметром column_key.
     *
     * @see CoverArray::column()
     * @see array_column()
     */
    public function testColumnWithoutIndexKey(): void
    {
        $data = [
            ['id' => 2135, 'first_name' => 'John', 'last_name' => 'Doe'],
            ['id' => 3245, 'first_name' => 'Sally', 'last_name' => 'Smith'],
            ['id' => 5342, 'first_name' => 'Jane', 'last_name' => 'Jones'],
            ['id' => 5623, 'first_name' => 'Peter', 'last_name' => 'Doe']
        ];

        $expected = array_column($data, 'first_name');

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->column('first_name')->getDataAsArray()
        );
    }

    /**
     * Tests the column() method with index key.
     *
     * This test verifies that the column() method correctly returns
     * the values from a single column indexed by another column,
     * mirroring PHP's array_column() function with both column_key
     * and index_key parameters.
     *
     *
     * Тестирование метода column() с ключом индекса.
     *
     * Этот тест проверяет, что метод column() корректно возвращает
     * значения из одного столбца, индексированные другим столбцом,
     * отражая функцию array_column() PHP с обоими параметрами
     * column_key и index_key.
     *
     * @see CoverArray::column()
     * @see array_column()
     */
    public function testColumnWithIndexKey(): void
    {
        $data = [
            ['id' => 2135, 'first_name' => 'John', 'last_name' => 'Doe'],
            ['id' => 3245, 'first_name' => 'Sally', 'last_name' => 'Smith'],
            ['id' => 5342, 'first_name' => 'Jane', 'last_name' => 'Jones'],
            ['id' => 5623, 'first_name' => 'Peter', 'last_name' => 'Doe']
        ];

        $expected = array_column($data, 'first_name', 'id');

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->column('first_name', 'id')->getDataAsArray()
        );
    }

    /**
     * Tests the column() method with null column key and index key.
     *
     * This test verifies that the column() method correctly returns
     * the input array indexed by the specified column when column_key
     * is null, mirroring PHP's array_column() function with null
     * column_key and index_key parameters.
     *
     *
     * Тестирование метода column() с null в качестве ключа столбца и ключом индекса.
     *
     * Этот тест проверяет, что метод column() корректно возвращает
     * входной массив, индексированный указанным столбцом, когда column_key
     * равен null, отражая функцию array_column() PHP с null
     * в качестве column_key и указанным index_key.
     *
     * @see CoverArray::column()
     * @see array_column()
     */
    public function testColumnWithNullColumnKeyAndIndexKey(): void
    {
        $data = [
            ['id' => 2135, 'first_name' => 'John', 'last_name' => 'Doe'],
            ['id' => 3245, 'first_name' => 'Sally', 'last_name' => 'Smith'],
            ['id' => 5342, 'first_name' => 'Jane', 'last_name' => 'Jones'],
            ['id' => 5623, 'first_name' => 'Peter', 'last_name' => 'Doe']
        ];

        $expected = array_column($data, null, 'id');

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->column(null, 'id')->getDataAsArray()
        );
    }

    /**
     * Tests the column() method with null column key without index key.
     *
     * This test verifies that the column() method correctly returns
     * the input array as is when column_key is null and no index_key
     * is specified, mirroring PHP's array_column() function with only
     * null column_key parameter.
     *
     *
     * Тестирование метода column() с null в качестве ключа столбца без ключа индекса.
     *
     * Этот тест проверяет, что метод column() корректно возвращает
     * входной массив как есть, когда column_key равен null и index_key
     * не указан, отражая функцию array_column() PHP только с null
     * в качестве column_key.
     *
     * @see CoverArray::column()
     * @see array_column()
     */
    public function testColumnWithNullColumnKeyWithoutIndexKey(): void
    {
        $data = [
            ['id' => 2135, 'first_name' => 'John', 'last_name' => 'Doe'],
            ['id' => 3245, 'first_name' => 'Sally', 'last_name' => 'Smith'],
            ['id' => 5342, 'first_name' => 'Jane', 'last_name' => 'Jones'],
            ['id' => 5623, 'first_name' => 'Peter', 'last_name' => 'Doe']
        ];

        $expected = array_column($data, null);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->column(null)->getDataAsArray()
        );
    }

    /**
     * Tests the column() method with associative arrays of objects.
     *
     * This test verifies that the column() method correctly works
     * with arrays of objects, extracting properties from objects,
     * mirroring PHP's array_column() function behavior with objects.
     *
     *
     * Тестирование метода column() с ассоциативными массивами объектов.
     *
     * Этот тест проверяет, что метод column() корректно работает
     * с массивами объектов, извлекая свойства из объектов,
     * отражая поведение функции array_column() PHP с объектами.
     *
     * @see CoverArray::column()
     * @see array_column()
     */
    public function testColumnWithObjects(): void
    {
        $obj1 = (object)['id' => 1, 'name' => 'John'];
        $obj2 = (object)['id' => 2, 'name' => 'Jane'];
        $obj3 = (object)['id' => 3, 'name' => 'Bob'];

        $data = [$obj1, $obj2, $obj3];

        $expected = array_column($data, 'name');

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->column('name')->getDataAsArray()
        );
    }

    /**
     * Tests the column() method with missing column keys.
     *
     * This test verifies that the column() method correctly handles
     * missing column keys, returning null values for missing keys,
     * mirroring PHP's array_column() function behavior.
     *
     *
     * Тестирование метода column() с отсутствующими ключами столбцов.
     *
     * Этот тест проверяет, что метод column() корректно обрабатывает
     * отсутствующие ключи столбцов, возвращая null для отсутствующих ключей,
     * отражая поведение функции array_column() PHP.
     *
     * @see CoverArray::column()
     * @see array_column()
     */
    public function testColumnWithMissingColumnKeys(): void
    {
        $data = [
            ['id' => 1, 'name' => 'John'],
            ['id' => 2], // отсутствует ключ 'name'
            ['id' => 3, 'name' => 'Bob'],
            ['id' => 4, 'name' => 'Alice', 'age' => 25]
        ];

        $expected = array_column($data, 'name');

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->column('name')->getDataAsArray()
        );
    }

    /**
     * Tests the column() method with duplicate index keys.
     *
     * This test verifies that the column() method correctly handles
     * duplicate index keys, overwriting previous values with later ones,
     * mirroring PHP's array_column() function behavior.
     *
     *
     * Тестирование метода column() с дублирующимися ключами индекса.
     *
     * Этот тест проверяет, что метод column() корректно обрабатывает
     * дублирующиеся ключи индекса, перезаписывая предыдущие значения более поздними,
     * отражая поведение функции array_column() PHP.
     *
     * @see CoverArray::column()
     * @see array_column()
     */
    public function testColumnWithDuplicateIndexKeys(): void
    {
        $data = [
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane'],
            ['id' => 1, 'name' => 'Bob'], // дублирующий id
            ['id' => 3, 'name' => 'Alice']
        ];

        $expected = array_column($data, 'name', 'id');

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->column('name', 'id')->getDataAsArray()
        );
    }

    /**
     * Tests the column() method with numeric index keys.
     *
     * This test verifies that the column() method correctly handles
     * numeric index keys, converting them appropriately,
     * mirroring PHP's array_column() function behavior.
     *
     *
     * Тестирование метода column() с числовыми ключами индекса.
     *
     * Этот тест проверяет, что метод column() корректно обрабатывает
     * числовые ключи индекса, преобразуя их соответствующим образом,
     * отражая поведение функции array_column() PHP.
     *
     * @see CoverArray::column()
     * @see array_column()
     */
    public function testColumnWithNumericIndexKeys(): void
    {
        $data = [
            ['id' => '001', 'value' => 'A'],
            ['id' => 2, 'value' => 'B'],
            ['id' => '003', 'value' => 'C'],
            ['id' => 4, 'value' => 'D']
        ];

        $expected = array_column($data, 'value', 'id');

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->column('value', 'id')->getDataAsArray()
        );
    }
}