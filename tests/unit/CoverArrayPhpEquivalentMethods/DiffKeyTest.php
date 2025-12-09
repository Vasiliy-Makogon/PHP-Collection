<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class DiffKeyTest extends TestCase
{
    /**
     * Tests the diffKey() method (array_diff_key equivalent).
     *
     * This test verifies that the diffKey() method correctly computes
     * the difference of arrays using keys for comparison, ignoring
     * values, mirroring PHP's array_diff_key() function.
     *
     *
     * Тестирование метода diffKey() (эквивалент array_diff_key).
     *
     * Этот тест проверяет, что метод diffKey() корректно вычисляет
     * расхождение массивов, используя ключи для сравнения, игнорируя
     * значения, отражая функцию array_diff_key() PHP.
     *
     * @see CoverArray::diffKey()
     * @see array_diff_key()
     */
    public function testDiffKeyMethod(): void
    {
        // Test with string keys
        // Тест со строковыми ключами
        $data1 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $diff1 = ['a' => 'apricot', 'c' => 'coconut'];

        $expected1 = array_diff_key($data1, $diff1);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->diffKey($diff1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->diffKey(new CoverArray($diff1))->getDataAsArray()
        );

        // Test with numeric keys
        // Тест с числовыми ключами
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three'];
        $diff2 = [1 => 'ONE', 3 => 'THREE'];

        $expected2 = array_diff_key($data2, $diff2);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->diffKey($diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->diffKey(new CoverArray($diff2))->getDataAsArray()
        );

        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
        $diff3 = ['a' => 10, 'c' => 30];
        $diff4 = ['b' => 20, 'd' => 40];

        $expected3 = array_diff_key($data3, $diff3, $diff4);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->diffKey($diff3, $diff4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->diffKey(
                new CoverArray($diff3),
                new CoverArray($diff4)
            )->getDataAsArray()
        );

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data4 = ['a' => 'apple', 0 => 'zero', '1' => 'one'];
        $diff5 = ['a' => 'apricot', 0 => 'ZERO'];

        $expected4 = array_diff_key($data4, $diff5);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->diffKey($diff5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->diffKey(new CoverArray($diff5))->getDataAsArray()
        );

        // Test with empty diff array (should return entire array)
        // Тест с пустым массивом для сравнения (должен вернуть весь массив)
        $data5 = ['x' => 10, 'y' => 20, 'z' => 30];
        $diff6 = [];

        $expected5 = array_diff_key($data5, $diff6);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->diffKey($diff6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->diffKey(new CoverArray($diff6))->getDataAsArray()
        );

        // Test where all keys are removed
        // Тест, где все ключи удаляются
        $data6 = ['a' => 1, 'b' => 2];
        $diff7 = ['a' => 100, 'b' => 200];

        $expected6 = array_diff_key($data6, $diff7);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->diffKey($diff7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->diffKey(new CoverArray($diff7))->getDataAsArray()
        );
    }
}