<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class IntersectUkeyTest extends TestCase
{
    /**
     * Tests the intersectUkey() method (array_intersect_ukey equivalent).
     *
     * This test verifies that the intersectUkey() method correctly computes
     * the intersection of arrays using a user-defined callback function
     * for key comparison, mirroring PHP's array_intersect_ukey() function.
     *
     *
     * Тестирование метода intersectUkey() (эквивалент array_intersect_ukey).
     *
     * Этот тест проверяет, что метод intersectUkey() корректно вычисляет
     * пересечение массивов с использованием пользовательской callback-функции
     * для сравнения ключей, отражая функцию array_intersect_ukey() PHP.
     *
     * @see CoverArray::intersectUkey()
     * @see array_intersect_ukey()
     */
    public function testIntersectUkeyMethod(): void
    {
        // Define a callback that works with mixed key types
        // Определяем callback, который работает со смешанными типами ключей
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        // Test with string keys
        // Тест со строковыми ключами
        $data1 = ['a' => 1, 'b' => 2, 'c' => 3];
        $intersect1 = ['a' => 10, 'b' => 20, 'd' => 40];

        $expected1 = array_intersect_ukey($data1, $intersect1, $callback);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->intersectUkey($callback, $intersect1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->intersectUkey($callback, new CoverArray($intersect1))->getDataAsArray()
        );

        // Test with numeric keys
        // Тест с числовыми ключами
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $intersect2 = [1 => 'ONE', 2 => 'TWO', 3 => 'three'];

        $expected2 = array_intersect_ukey($data2, $intersect2, $callback);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->intersectUkey($callback, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->intersectUkey($callback, new CoverArray($intersect2))->getDataAsArray()
        );

        // Test with multiple arrays
        // Тест с несколькими массивами
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect3 = ['a' => 10, 'b' => 20];
        $intersect4 = ['c' => 30, 'd' => 40];

        $expected3 = array_intersect_ukey($data3, $intersect3, $intersect4, $callback);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->intersectUkey($callback, $intersect3, $intersect4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->intersectUkey(
                $callback,
                new CoverArray($intersect3),
                new CoverArray($intersect4)
            )->getDataAsArray()
        );

        // Test with case-insensitive comparison callback
        // Тест с callback для сравнения без учета регистра
        $caseInsensitiveCallback = function ($a, $b) {
            return strcasecmp((string) $a, (string) $b);
        };

        $data4 = ['A' => 'apple', 'B' => 'banana', 'c' => 'cherry'];
        $intersect5 = ['a' => 'apricot', 'b' => 'blueberry'];

        $expected4 = array_intersect_ukey($data4, $intersect5, $caseInsensitiveCallback);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->intersectUkey($caseInsensitiveCallback, $intersect5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->intersectUkey($caseInsensitiveCallback, new CoverArray($intersect5))->getDataAsArray()
        );

        // Test with custom key comparison logic
        // Тест с пользовательской логикой сравнения ключей
        $customCallback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            // Compare by string length first
            // Сначала сравниваем по длине строки
            $lenA = strlen((string) $a);
            $lenB = strlen((string) $b);

            if ($lenA === $lenB) {
                return strcmp((string) $a, (string) $b);
            }
            return $lenA <=> $lenB;
        };

        $data5 = ['aa' => 1, 'b' => 2, 'ccc' => 3];
        $intersect6 = ['aa' => 10, 'ccc' => 30];

        $expected5 = array_intersect_ukey($data5, $intersect6, $customCallback);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->intersectUkey($customCallback, $intersect6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->intersectUkey($customCallback, new CoverArray($intersect6))->getDataAsArray()
        );

        // Test with empty intersection array
        // Тест с пустым массивом для пересечения
        $data6 = ['x' => 10, 'y' => 20];
        $intersect7 = [];

        $expected6 = array_intersect_ukey($data6, $intersect7, $callback);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->intersectUkey($callback, $intersect7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->intersectUkey($callback, new CoverArray($intersect7))->getDataAsArray()
        );

        // Test with no common keys
        // Тест без общих ключей
        $data7 = ['a' => 1, 'b' => 2];
        $intersect8 = ['c' => 3, 'd' => 4];

        $expected7 = array_intersect_ukey($data7, $intersect8, $callback);

        $cover7 = new CoverArray($data7);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected7,
            $cover7->intersectUkey($callback, $intersect8)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected7,
            $cover7->intersectUkey($callback, new CoverArray($intersect8))->getDataAsArray()
        );
    }
}