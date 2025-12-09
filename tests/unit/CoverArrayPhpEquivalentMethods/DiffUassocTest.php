<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class DiffUassocTest extends TestCase
{
    /**
     * Tests the diffUassoc() method (array_diff_uassoc equivalent).
     *
     * This test verifies that the diffUassoc() method correctly computes
     * the difference of arrays with additional index check using a user-defined
     * callback function for key comparison, mirroring PHP's array_diff_uassoc().
     *
     *
     * Тестирование метода diffUassoc() (эквивалент array_diff_uassoc).
     *
     * Этот тест проверяет, что метод diffUassoc() корректно вычисляет
     * расхождение массивов с дополнительной проверкой индекса с использованием
     * пользовательской callback-функции для сравнения ключей, отражая array_diff_uassoc() PHP.
     *
     * @see CoverArray::diffUassoc()
     * @see array_diff_uassoc()
     */
    public function testDiffUassocMethod(): void
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
        $diff1 = ['a' => 1, 'b' => 20];

        $expected1 = array_diff_uassoc($data1, $diff1, $callback);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->diffUassoc($callback, $diff1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->diffUassoc($callback, new CoverArray($diff1))->getDataAsArray()
        );

        // Test with numeric keys using callback
        // Тест с числовыми ключами с использованием callback
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $diff2 = [0 => 'zero', 1 => 'ONE'];

        $expected2 = array_diff_uassoc($data2, $diff2, $callback);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->diffUassoc($callback, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->diffUassoc($callback, new CoverArray($diff2))->getDataAsArray()
        );

        // Test with multiple diff arrays
        // Тест с несколькими массивами для сравнения
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $diff3 = ['a' => 1, 'b' => 20];
        $diff4 = ['c' => 30, 'd' => 4];

        $expected3 = array_diff_uassoc($data3, $diff3, $diff4, $callback);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->diffUassoc($callback, $diff3, $diff4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->diffUassoc(
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
        $diff5 = ['a' => 'apple', 'b' => 'banana'];

        $expected4 = array_diff_uassoc($data4, $diff5, $caseInsensitiveCallback);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->diffUassoc($caseInsensitiveCallback, $diff5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->diffUassoc($caseInsensitiveCallback, new CoverArray($diff5))->getDataAsArray()
        );

        // Test with custom key comparison logic
        // Тест с пользовательской логикой сравнения ключей
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
        $diff6 = ['aa' => 10, 'ccc' => 3];

        $expected5 = array_diff_uassoc($data5, $diff6, $customCallback);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->diffUassoc($customCallback, $diff6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->diffUassoc($customCallback, new CoverArray($diff6))->getDataAsArray()
        );

        // Test with empty diff array
        // Тест с пустым массивом для сравнения
        $data6 = ['x' => 10, 'y' => 20];
        $diff7 = [];

        $expected6 = array_diff_uassoc($data6, $diff7, $callback);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->diffUassoc($callback, $diff7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->diffUassoc($callback, new CoverArray($diff7))->getDataAsArray()
        );
    }
}