<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class IntersectAssocTest extends TestCase
{
    /**
     * Tests the intersectAssoc() method (array_intersect_assoc equivalent).
     *
     * This test verifies that the intersectAssoc() method correctly computes
     * the intersection of arrays with additional index check, comparing
     * both keys and values, mirroring PHP's array_intersect_assoc() function.
     *
     *
     * Тестирование метода intersectAssoc() (эквивалент array_intersect_assoc).
     *
     * Этот тест проверяет, что метод intersectAssoc() корректно вычисляет
     * пересечение массивов с дополнительной проверкой индекса, сравнивая
     * как ключи, так и значения, отражая функцию array_intersect_assoc() PHP.
     *
     * @see CoverArray::intersectAssoc()
     * @see array_intersect_assoc()
     */
    public function testIntersectAssocMethod(): void
    {
        // Test with associative arrays (compares both keys and values)
        // Тест с ассоциативными массивами (сравнивает и ключи, и значения)
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect1 = ['b' => 2, 'c' => 30, 'e' => 5];

        $expected1 = array_intersect_assoc($data1, $intersect1);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->intersectAssoc($intersect1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->intersectAssoc(new CoverArray($intersect1))->getDataAsArray()
        );

        // Test with multiple arrays for intersection
        // Тест с несколькими массивами для пересечения
        $data2 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect2 = ['b' => 2, 'c' => 30];
        $intersect3 = ['a' => 1, 'd' => 40];

        $expected2 = array_intersect_assoc($data2, $intersect2, $intersect3);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->intersectAssoc($intersect2, $intersect3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->intersectAssoc(
                new CoverArray($intersect2),
                new CoverArray($intersect3)
            )->getDataAsArray()
        );

        // Test with numeric keys (compares both key and value)
        // Тест с числовыми ключами (сравнивает и ключ, и значение)
        $data3 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $intersect4 = [0 => 'zero', 1 => 'ONE', 2 => 'two'];

        $expected3 = array_intersect_assoc($data3, $intersect4);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->intersectAssoc($intersect4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->intersectAssoc(new CoverArray($intersect4))->getDataAsArray()
        );

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data4 = ['a' => 'apple', 0 => 'zero', '1' => 'one'];
        $intersect5 = ['a' => 'apple', 0 => 'ZERO', '1' => 'one'];

        $expected4 = array_intersect_assoc($data4, $intersect5);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->intersectAssoc($intersect5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->intersectAssoc(new CoverArray($intersect5))->getDataAsArray()
        );

        // Test with empty intersection array (should return empty array)
        // Тест с пустым массивом для пересечения (должен вернуть пустой массив)
        $data5 = ['x' => 10, 'y' => 20, 'z' => 30];
        $intersect6 = [];

        $expected5 = array_intersect_assoc($data5, $intersect6);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->intersectAssoc($intersect6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->intersectAssoc(new CoverArray($intersect6))->getDataAsArray()
        );

        // Test with complete match
        // Тест с полным совпадением
        $data6 = ['a' => 1, 'b' => 2];
        $intersect7 = ['a' => 1, 'b' => 2];

        $expected6 = array_intersect_assoc($data6, $intersect7);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->intersectAssoc($intersect7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->intersectAssoc(new CoverArray($intersect7))->getDataAsArray()
        );
    }
}