<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class DiffUkeyTest extends TestCase
{
    /**
     * Tests the diffUkey() method (array_diff_ukey equivalent).
     *
     * This test verifies that the diffUkey() method correctly computes
     * the difference of arrays using a user-defined callback function
     * for key comparison, mirroring PHP's array_diff_ukey() function.
     *
     *
     * Тестирование метода diffUkey() (эквивалент array_diff_ukey).
     *
     * Этот тест проверяет, что метод diffUkey() корректно вычисляет
     * расхождение массивов с использованием пользовательской callback-функции
     * для сравнения ключей, отражая функцию array_diff_ukey() PHP.
     *
     * @see CoverArray::diffUkey()
     * @see array_diff_ukey()
     */
    public function testDiffUkeyMethod(): void
    {
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        // Test with string keys using callback
        // Тест со строковыми ключами с использованием callback
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3];
        $diff1 = ['a' => 100, 'b' => 200];

        $expected1 = array_diff_ukey($data1, $diff1, $callback);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->diffUkey($callback, $diff1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->diffUkey($callback, new CoverArray($diff1))->getDataAsArray()
        );

        // Test with numeric keys using callback
        // Тест с числовыми ключами с использованием callback
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $diff2 = [0 => 'ZERO', 1 => 'ONE'];

        $expected2 = array_diff_ukey($data2, $diff2, $callback);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->diffUkey($callback, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->diffUkey($callback, new CoverArray($diff2))->getDataAsArray()
        );

        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff3 = ['a' => 10, 'b' => 20];
        $diff4 = ['c' => 30, 'd' => 40];

        $expected3 = array_diff_ukey($data3, $diff3, $diff4, $callback);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->diffUkey($callback, $diff3, $diff4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->diffUkey(
                $callback,
                new CoverArray($diff3),
                new CoverArray($diff4)
            )->getDataAsArray()
        );

        // Test with case-insensitive comparison callback
        // Тест с callback для сравнения без учета регистра
        $caseInsensitiveCallback = function ($a, $b) {
            return strcasecmp((string) $a, (string) $b);
        };

        $data4 = ['A' => 'apple', 'B' => 'banana', 'c' => 'cherry'];
        $diff5 = ['a' => 'apricot', 'b' => 'blueberry'];

        $expected4 = array_diff_ukey($data4, $diff5, $caseInsensitiveCallback);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->diffUkey($caseInsensitiveCallback, $diff5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->diffUkey($caseInsensitiveCallback, new CoverArray($diff5))->getDataAsArray()
        );

        // Test with custom key comparison logic (comparing string lengths of keys)
        // Тест с пользовательской логикой сравнения ключей (сравнение длины строк ключей)
        $customCallback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            // Приводим к строке и сравниваем длину
            $lenA = strlen((string) $a);
            $lenB = strlen((string) $b);

            if ($lenA === $lenB) {
                return strcmp((string) $a, (string) $b);
            }
            return $lenA <=> $lenB;
        };

        $data5 = ['aa' => 1, 'b' => 2, 'ccc' => 3];
        $diff6 = ['aa' => 10, 'ccc' => 30];

        $expected5 = array_diff_ukey($data5, $diff6, $customCallback);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->diffUkey($customCallback, $diff6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->diffUkey($customCallback, new CoverArray($diff6))->getDataAsArray()
        );

        // Test with empty diff array
        // Тест с пустым массивом для сравнения
        $data6 = ['x' => 10, 'y' => 20];
        $diff7 = [];

        $expected6 = array_diff_ukey($data6, $diff7, $callback);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->diffUkey($callback, $diff7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->diffUkey($callback, new CoverArray($diff7))->getDataAsArray()
        );

        // Test where all keys are removed
        // Тест, где все ключи удаляются
        $data7 = ['a' => 1, 'b' => 2];
        $diff8 = ['a' => 100, 'b' => 200];

        $expected7 = array_diff_ukey($data7, $diff8, $callback);

        $cover7 = new CoverArray($data7);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected7,
            $cover7->diffUkey($callback, $diff8)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected7,
            $cover7->diffUkey($callback, new CoverArray($diff8))->getDataAsArray()
        );
    }
}