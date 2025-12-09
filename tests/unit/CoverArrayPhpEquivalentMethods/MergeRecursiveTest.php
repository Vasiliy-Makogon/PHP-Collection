<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class MergeRecursiveTest extends TestCase
{
    /**
     * Tests the mergeRecursive() method (array_merge_recursive equivalent).
     *
     * This test verifies that the mergeRecursive() method correctly merges
     * one or more arrays recursively, with values for identical string keys
     * merged into arrays, mirroring PHP's array_merge_recursive() function.
     *
     *
     * Тестирование метода mergeRecursive() (эквивалент array_merge_recursive).
     *
     * Этот тест проверяет, что метод mergeRecursive() корректно объединяет
     * один или несколько массивов рекурсивно, со значениями для одинаковых
     * строковых ключей, объединенными в массивы, отражая array_merge_recursive() PHP.
     *
     * @see CoverArray::mergeRecursive()
     * @see array_merge_recursive()
     */
    public function testMergeRecursiveMethod(): void
    {
        // Test merging arrays with nested associative keys
        // Тест объединения массивов с вложенными ассоциативными ключами
        $data1 = ['color' => ['favorite' => 'red'], 5];
        $data2 = [10, 'color' => ['favorite' => 'green', 'blue']];

        $expected1 = [
            'color' => [
                'favorite' => [
                    0 => 'red',
                    1 => 'green',
                ],
                0 => 'blue',
            ],
            0 => 5,
            1 => 10,
        ];

        $cover1 = new CoverArray($data1);
        $cover2 = new CoverArray($data2);

        // original function
        // оригинальная функция
        $this->assertSame($expected1, array_merge_recursive($data1, $data2));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->mergeRecursive($data2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->mergeRecursive($cover2)->getDataAsArray()
        );

        // Test merging with multiple identical string keys at different levels
        // Тест объединения с несколькими одинаковыми строковыми ключами на разных уровнях
        $data3 = [
            'user' => [
                'name' => 'John',
                'contacts' => ['email' => 'john@example.com']
            ],
            'settings' => ['theme' => 'dark']
        ];

        $data4 = [
            'user' => [
                'age' => 30,
                'contacts' => ['phone' => '123-456-7890']
            ],
            'settings' => ['language' => 'en']
        ];

        $expected2 = array_merge_recursive($data3, $data4);

        $cover3 = new CoverArray($data3);
        $cover4 = new CoverArray($data4);

        // original function
        // оригинальная функция
        $this->assertSame($expected2, array_merge_recursive($data3, $data4));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover3->mergeRecursive($data4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover3->mergeRecursive($cover4)->getDataAsArray()
        );

        // Test merging numeric keys (they get reindexed, not merged)
        // Тест объединения числовых ключей (они переиндексируются, а не объединяются)
        $data5 = [0 => ['a', 'b'], 1 => ['c', 'd']];
        $data6 = [0 => ['e', 'f'], 1 => ['g', 'h']];

        $expected3 = array_merge_recursive($data5, $data6);

        $cover5 = new CoverArray($data5);
        $cover6 = new CoverArray($data6);

        // original function
        // оригинальная функция
        $this->assertSame($expected3, array_merge_recursive($data5, $data6));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover5->mergeRecursive($data6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover5->mergeRecursive($cover6)->getDataAsArray()
        );

        // Test merging three arrays recursively
        // Тест объединения трех массивов рекурсивно
        $data7 = ['a' => ['x' => 1]];
        $data8 = ['a' => ['y' => 2]];
        $data9 = ['a' => ['z' => 3]];

        $expected4 = array_merge_recursive($data7, $data8, $data9);

        $cover7 = new CoverArray($data7);
        $cover8 = new CoverArray($data8);
        $cover9 = new CoverArray($data9);

        // original function
        // оригинальная функция
        $this->assertSame($expected4, array_merge_recursive($data7, $data8, $data9));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover7->mergeRecursive($data8, $data9)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover7->mergeRecursive($cover8, $cover9)->getDataAsArray()
        );

        // Test merging with empty arrays
        // Тест объединения с пустыми массивами
        $data10 = ['key' => 'value', 'nested' => ['a' => 1]];
        $data11 = [];

        $expected5 = array_merge_recursive($data10, $data11);

        $cover10 = new CoverArray($data10);
        $cover11 = new CoverArray($data11);

        // original function
        // оригинальная функция
        $this->assertSame($expected5, array_merge_recursive($data10, $data11));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover10->mergeRecursive($data11)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover10->mergeRecursive($cover11)->getDataAsArray()
        );

        // Test merging arrays with scalar values for same string key (creates array)
        // Тест объединения массивов со скалярными значениями для одного и того же строкового ключа (создает массив)
        $data12 = ['fruit' => 'apple'];
        $data13 = ['fruit' => 'banana'];

        $expected6 = array_merge_recursive($data12, $data13);

        $cover12 = new CoverArray($data12);
        $cover13 = new CoverArray($data13);

        // original function
        // оригинальная функция
        $this->assertSame($expected6, array_merge_recursive($data12, $data13));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover12->mergeRecursive($data13)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover12->mergeRecursive($cover13)->getDataAsArray()
        );

        // Test merging arrays with mixed numeric and string keys
        // Тест объединения массивов со смешанными числовыми и строковыми ключами
        $data14 = [0 => 'zero', 'a' => ['x' => 1]];
        $data15 = [0 => 'ZERO', 'a' => ['y' => 2], 'b' => 'new'];

        $expected7 = array_merge_recursive($data14, $data15);

        $cover14 = new CoverArray($data14);
        $cover15 = new CoverArray($data15);

        // original function
        // оригинальная функция
        $this->assertSame($expected7, array_merge_recursive($data14, $data15));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected7,
            $cover14->mergeRecursive($data15)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected7,
            $cover14->mergeRecursive($cover15)->getDataAsArray()
        );
    }
}