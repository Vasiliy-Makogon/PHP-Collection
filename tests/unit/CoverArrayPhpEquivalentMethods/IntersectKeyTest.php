<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class IntersectKeyTest extends TestCase
{
    /**
     * Tests the intersectKey() method (array_intersect_key equivalent).
     *
     * This test verifies that the intersectKey() method correctly computes
     * the intersection of arrays using keys for comparison, returning
     * elements with keys present in all provided arrays, mirroring array_intersect_key().
     *
     *
     * Тестирование метода intersectKey() (эквивалент array_intersect_key).
     *
     * Этот тест проверяет, что метод intersectKey() корректно вычисляет
     * пересечение массивов, используя ключи для сравнения, возвращая
     * элементы с ключами, присутствующими во всех предоставленных массивах,
     * отражая array_intersect_key().
     *
     * @see CoverArray::intersectKey()
     * @see array_intersect_key()
     */
    public function testIntersectKeyMethod(): void
    {
        // Test with associative arrays
        // Тест с ассоциативными массивами
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect1 = ['b' => 20, 'c' => 30, 'e' => 50];

        $expected1 = array_intersect_key($data1, $intersect1);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->intersectKey($intersect1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->intersectKey(new CoverArray($intersect1))->getDataAsArray()
        );

        // Test with multiple arrays for intersection
        // Тест с несколькими массивами для пересечения
        $data2 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
        $intersect2 = ['a' => 10, 'c' => 30];
        $intersect3 = ['b' => 200, 'd' => 400, 'e' => 500];

        $expected2 = array_intersect_key($data2, $intersect2, $intersect3);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->intersectKey($intersect2, $intersect3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->intersectKey(
                new CoverArray($intersect2),
                new CoverArray($intersect3)
            )->getDataAsArray()
        );

        // Test with numeric keys
        // Тест с числовыми ключами
        $data3 = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three'];
        $intersect4 = [1 => 'ONE', 3 => 'THREE', 4 => 'four'];

        $expected3 = array_intersect_key($data3, $intersect4);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->intersectKey($intersect4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->intersectKey(new CoverArray($intersect4))->getDataAsArray()
        );

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data4 = ['a' => 'apple', 0 => 'zero', '1' => 'one'];
        $intersect5 = ['a' => 'apricot', 0 => 'ZERO'];

        $expected4 = array_intersect_key($data4, $intersect5);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->intersectKey($intersect5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->intersectKey(new CoverArray($intersect5))->getDataAsArray()
        );

        // Test with empty intersection array (should return empty array)
        // Тест с пустым массивом для пересечения (должен вернуть пустой массив)
        $data5 = ['x' => 10, 'y' => 20, 'z' => 30];
        $intersect6 = [];

        $expected5 = array_intersect_key($data5, $intersect6);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->intersectKey($intersect6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->intersectKey(new CoverArray($intersect6))->getDataAsArray()
        );

        // Test with no common keys
        // Тест без общих ключей
        $data6 = ['a' => 1, 'b' => 2];
        $intersect7 = ['c' => 3, 'd' => 4];

        $expected6 = array_intersect_key($data6, $intersect7);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->intersectKey($intersect7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->intersectKey(new CoverArray($intersect7))->getDataAsArray()
        );
    }
}