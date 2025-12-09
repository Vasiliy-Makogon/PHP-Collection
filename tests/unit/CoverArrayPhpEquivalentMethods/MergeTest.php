<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class MergeTest extends TestCase
{
    /**
     * Tests the merge() method (array_merge equivalent).
     *
     * This test verifies that the merge() method correctly merges
     * one or more arrays into the CoverArray, preserving numeric
     * keys and overwriting string keys, mirroring PHP's array_merge().
     *
     *
     * Тестирование метода merge() (эквивалент array_merge).
     *
     * Этот тест проверяет, что метод merge() корректно объединяет
     * один или несколько массивов в CoverArray, сохраняя числовые
     * ключи и перезаписывая строковые ключи, отражая array_merge() PHP.
     *
     * @see CoverArray::merge()
     * @see array_merge()
     */
    public function testMergeMethod(): void
    {
        // Test merging numeric arrays (keys are reindexed)
        // Тест объединения числовых массивов (ключи переиндексируются)
        $data1 = ['PHP', 'MySql'];
        $merge1 = ['HTML', 'CSS', 'JavaScript'];

        $expected1 = array_merge($data1, $merge1);

        $cover1 = new CoverArray($data1);
        $coverMerge1 = new CoverArray($merge1);

        // original function
        // оригинальная функция
        $this->assertSame($expected1, array_merge($data1, $merge1));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->merge($merge1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->merge($coverMerge1)->getDataAsArray()
        );

        // Test merging associative arrays (string keys are overwritten)
        // Тест объединения ассоциативных массивов (строковые ключи перезаписываются)
        $data2 = ['a' => 'apple', 'b' => 'banana'];
        $merge2 = ['b' => 'blueberry', 'c' => 'cherry'];

        $expected2 = array_merge($data2, $merge2);

        $cover2 = new CoverArray($data2);
        $coverMerge2 = new CoverArray($merge2);

        // original function
        // оригинальная функция
        $this->assertSame($expected2, array_merge($data2, $merge2));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->merge($merge2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->merge($coverMerge2)->getDataAsArray()
        );

        // Test merging multiple arrays
        // Тест объединения нескольких массивов
        $data3 = ['x' => 1, 'y' => 2];
        $merge3a = ['y' => 20, 'z' => 3];
        $merge3b = ['z' => 30, 'w' => 4];

        $expected3 = array_merge($data3, $merge3a, $merge3b);

        $cover3 = new CoverArray($data3);
        $coverMerge3a = new CoverArray($merge3a);
        $coverMerge3b = new CoverArray($merge3b);

        // original function
        // оригинальная функция
        $this->assertSame($expected3, array_merge($data3, $merge3a, $merge3b));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->merge($merge3a, $merge3b)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->merge($coverMerge3a, $coverMerge3b)->getDataAsArray()
        );

        // Test merging with mixed numeric and string keys
        // Тест объединения со смешанными числовыми и строковыми ключами
        $data4 = [0 => 'zero', 'a' => 'apple', 1 => 'one'];
        $merge4 = [1 => 'ONE', 'b' => 'banana', 2 => 'two'];

        $expected4 = array_merge($data4, $merge4);

        $cover4 = new CoverArray($data4);
        $coverMerge4 = new CoverArray($merge4);

        // original function
        // оригинальная функция
        $this->assertSame($expected4, array_merge($data4, $merge4));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->merge($merge4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->merge($coverMerge4)->getDataAsArray()
        );

        // Test merging empty arrays
        // Тест объединения пустых массивов
        $data5 = ['a' => 1, 'b' => 2];
        $merge5 = [];

        $expected5 = array_merge($data5, $merge5);

        $cover5 = new CoverArray($data5);
        $coverMerge5 = new CoverArray($merge5);

        // original function
        // оригинальная функция
        $this->assertSame($expected5, array_merge($data5, $merge5));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->merge($merge5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->merge($coverMerge5)->getDataAsArray()
        );

        // Test merging all empty arrays
        // Тест объединения всех пустых массивов
        $data6 = [];
        $merge6 = [];

        $expected6 = array_merge($data6, $merge6);

        $cover6 = new CoverArray($data6);
        $coverMerge6 = new CoverArray($merge6);

        // original function
        // оригинальная функция
        $this->assertSame($expected6, array_merge($data6, $merge6));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->merge($merge6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->merge($coverMerge6)->getDataAsArray()
        );

        // Test merging with integer keys that are reindexed
        // Тест объединения с целочисленными ключами, которые переиндексируются
        $data7 = [10 => 'ten', 20 => 'twenty'];
        $merge7 = [30 => 'thirty', 40 => 'forty'];

        $expected7 = array_merge($data7, $merge7);

        $cover7 = new CoverArray($data7);
        $coverMerge7 = new CoverArray($merge7);

        // original function
        // оригинальная функция
        $this->assertSame($expected7, array_merge($data7, $merge7));

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected7,
            $cover7->merge($merge7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected7,
            $cover7->merge($coverMerge7)->getDataAsArray()
        );
    }
}