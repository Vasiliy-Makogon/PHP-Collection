<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class IntersectTest extends TestCase
{
    /**
     * Tests the intersect() method (array_intersect equivalent).
     *
     * This test verifies that the intersect() method correctly computes
     * the intersection of arrays based on values, returning elements
     * present in all provided arrays, mirroring PHP's array_intersect().
     *
     *
     * Тестирование метода intersect() (эквивалент array_intersect).
     *
     * Этот тест проверяет, что метод intersect() корректно вычисляет
     * пересечение массивов на основе значений, возвращая элементы,
     * присутствующие во всех предоставленных массивах, отражая array_intersect() PHP.
     *
     * @see CoverArray::intersect()
     * @see array_intersect()
     */
    public function testIntersectMethod(): void
    {
        // Test with simple arrays
        // Тест с простыми массивами
        $data1 = [1, 2, 3, 4, 5];
        $intersect1 = [2, 3, 6];
        $intersect2 = [3, 4, 7];

        $expected1 = array_intersect($data1, $intersect1, $intersect2);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->intersect($intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->intersect(
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );

        // Test with associative arrays (compares values, not keys)
        // Тест с ассоциативными массивами (сравнивает значения, не ключи)
        $data2 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date'];
        $intersect3 = ['banana', 'date', 'elderberry'];

        $expected2 = array_intersect($data2, $intersect3);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->intersect($intersect3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->intersect(new CoverArray($intersect3))->getDataAsArray()
        );

        // Test with multiple arrays for intersection
        // Тест с несколькими массивами для пересечения
        $data3 = ['red', 'green', 'blue', 'yellow', 'purple'];
        $intersect4 = ['green', 'yellow', 'orange'];
        $intersect5 = ['blue', 'green', 'violet'];
        $intersect6 = ['green', 'indigo'];

        $expected3 = array_intersect($data3, $intersect4, $intersect5, $intersect6);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->intersect($intersect4, $intersect5, $intersect6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->intersect(
                new CoverArray($intersect4),
                new CoverArray($intersect5),
                new CoverArray($intersect6)
            )->getDataAsArray()
        );

        // Test with empty intersection array
        // Тест с пустым массивом для пересечения
        $data4 = ['a', 'b', 'c'];
        $intersect7 = [];

        $expected4 = array_intersect($data4, $intersect7);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->intersect($intersect7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->intersect(new CoverArray($intersect7))->getDataAsArray()
        );

        // Test with no intersection
        // Тест без пересечения
        $data5 = [1, 2, 3];
        $intersect8 = [4, 5, 6];

        $expected5 = array_intersect($data5, $intersect8);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->intersect($intersect8)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->intersect(new CoverArray($intersect8))->getDataAsArray()
        );
    }
}