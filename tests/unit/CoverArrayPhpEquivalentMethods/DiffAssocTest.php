<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class DiffAssocTest extends TestCase
{
    /**
     * Tests the diffAssoc() method (array_diff_assoc equivalent).
     *
     * This test verifies that the diffAssoc() method correctly computes
     * the difference of arrays with additional index check, comparing
     * both keys and values, mirroring PHP's array_diff_assoc() function.
     *
     *
     * Тестирование метода diffAssoc() (эквивалент array_diff_assoc).
     *
     * Этот тест проверяет, что метод diffAssoc() корректно вычисляет
     * расхождение массивов с дополнительной проверкой индекса, сравнивая
     * как ключи, так и значения, отражая функцию array_diff_assoc() PHP.
     *
     * @see CoverArray::diffAssoc()
     * @see array_diff_assoc()
     */
    public function testDiffAssocMethod(): void
    {
        // Test with simple associative arrays
        // Тест с простыми ассоциативными массивами
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff1 = ['b' => 2, 'c' => 30, 'e' => 5];

        $expected1 = array_diff_assoc($data1, $diff1);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->diffAssoc($diff1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->diffAssoc(new CoverArray($diff1))->getDataAsArray()
        );

        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data2 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff2 = ['b' => 2, 'c' => 30];
        $diff3 = ['a' => 10, 'd' => 4];

        $expected2 = array_diff_assoc($data2, $diff2, $diff3);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->diffAssoc($diff2, $diff3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->diffAssoc(
                new CoverArray($diff2),
                new CoverArray($diff3)
            )->getDataAsArray()
        );

        // Test with numeric keys (compares both key and value)
        // Тест с числовыми ключами (сравнивает и ключ, и значение)
        $data3 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $diff4 = [0 => 'zero', 1 => 'ONE', 3 => 'three'];

        $expected3 = array_diff_assoc($data3, $diff4);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->diffAssoc($diff4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->diffAssoc(new CoverArray($diff4))->getDataAsArray()
        );

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data4 = ['a' => 'apple', 0 => 'zero', '1' => 'one'];
        $diff5 = ['a' => 'apple', 0 => 'ZERO', '1' => 'one'];

        $expected4 = array_diff_assoc($data4, $diff5);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->diffAssoc($diff5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->diffAssoc(new CoverArray($diff5))->getDataAsArray()
        );

        // Test with empty diff array (should return entire array)
        // Тест с пустым массивом для сравнения (должен вернуть весь массив)
        $data5 = ['x' => 10, 'y' => 20, 'z' => 30];
        $diff6 = [];

        $expected5 = array_diff_assoc($data5, $diff6);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->diffAssoc($diff6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->diffAssoc(new CoverArray($diff6))->getDataAsArray()
        );

        // Test where all elements are removed
        // Тест, где все элементы удаляются
        $data6 = ['a' => 1, 'b' => 2];
        $diff7 = ['a' => 1, 'b' => 2];

        $expected6 = array_diff_assoc($data6, $diff7);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->diffAssoc($diff7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->diffAssoc(new CoverArray($diff7))->getDataAsArray()
        );
    }
}