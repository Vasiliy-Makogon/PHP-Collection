<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class DiffTest extends TestCase
{
    /**
     * Tests the diff() method (array_diff equivalent).
     *
     * This test verifies that the diff() method correctly computes
     * the difference of arrays, comparing values across multiple
     * CoverArray or array arguments, mirroring PHP's array_diff() function.
     *
     *
     * Тестирование метода diff() (эквивалент array_diff).
     *
     * Этот тест проверяет, что метод diff() корректно вычисляет
     * расхождение массивов, сравнивая значения через несколько
     * аргументов CoverArray или массивов, отражая функцию array_diff() PHP.
     *
     * @see CoverArray::diff()
     * @see array_diff()
     */
    public function testDiffMethod(): void
    {
        // Test with simple arrays
        // Тест с простыми массивами
        $data1 = [1, 2, 3, 4, 5];
        $diff1 = [2, 4];
        $diff2 = [3];

        $expected1 = array_diff($data1, $diff1, $diff2);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->diff($diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->diff(
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );

        // Test with associative arrays (compares values, not keys)
        // Тест с ассоциативными массивами (сравнивает значения, не ключи)
        $data2 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date'];
        $diff3 = ['banana', 'date'];

        $expected2 = array_diff($data2, $diff3);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->diff($diff3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->diff(new CoverArray($diff3))->getDataAsArray()
        );

        // Test with mixed types
        // Тест со смешанными типами
        $data3 = [1, '1', 2, '2', 3];
        $diff4 = [1, '2'];

        $expected3 = array_diff($data3, $diff4);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->diff($diff4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->diff(new CoverArray($diff4))->getDataAsArray()
        );

        // Test with empty diff array
        // Тест с пустым массивом для сравнения
        $data4 = ['a', 'b', 'c'];
        $diff5 = [];

        $expected4 = array_diff($data4, $diff5);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->diff($diff5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->diff(new CoverArray($diff5))->getDataAsArray()
        );

        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data5 = ['red', 'green', 'blue', 'yellow', 'purple'];
        $diff6 = ['green', 'yellow'];
        $diff7 = ['red'];
        $diff8 = ['blue'];

        $expected5 = array_diff($data5, $diff6, $diff7, $diff8);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->diff($diff6, $diff7, $diff8)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->diff(
                new CoverArray($diff6),
                new CoverArray($diff7),
                new CoverArray($diff8)
            )->getDataAsArray()
        );
    }
}