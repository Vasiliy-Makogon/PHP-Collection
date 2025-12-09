<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class IntersectUassocTest extends TestCase
{
    /**
     * Tests the intersectUassoc() method (array_intersect_uassoc equivalent).
     *
     * This test verifies that the intersectUassoc() method correctly computes
     * the intersection of arrays with additional index check using a user-defined
     * callback function for key comparison, mirroring PHP's array_intersect_uassoc().
     *
     *
     * Тестирование метода intersectUassoc() (эквивалент array_intersect_uassoc).
     *
     * Этот тест проверяет, что метод intersectUassoc() корректно вычисляет
     * пересечение массивов с дополнительной проверкой индекса с использованием
     * пользовательской callback-функции для сравнения ключей, отражая array_intersect_uassoc() PHP.
     *
     * @see CoverArray::intersectUassoc()
     * @see array_intersect_uassoc()
     */
    public function testIntersectUassocMethod(): void
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
        $intersect1 = ['a' => 1, 'b' => 20];

        $expected1 = array_intersect_uassoc($data1, $intersect1, $callback);

        $cover1 = new CoverArray($data1);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected1,
            $cover1->intersectUassoc($callback, $intersect1)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected1,
            $cover1->intersectUassoc($callback, new CoverArray($intersect1))->getDataAsArray()
        );

        // Test with numeric keys
        // Тест с числовыми ключами
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $intersect2 = [0 => 'zero', 1 => 'ONE'];

        $expected2 = array_intersect_uassoc($data2, $intersect2, $callback);

        $cover2 = new CoverArray($data2);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected2,
            $cover2->intersectUassoc($callback, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected2,
            $cover2->intersectUassoc($callback, new CoverArray($intersect2))->getDataAsArray()
        );

        // Test with multiple arrays
        // Тест с несколькими массивами
        $data3 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect3 = ['a' => 1, 'b' => 20];
        $intersect4 = ['c' => 30, 'd' => 4];

        $expected3 = array_intersect_uassoc($data3, $intersect3, $intersect4, $callback);

        $cover3 = new CoverArray($data3);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected3,
            $cover3->intersectUassoc($callback, $intersect3, $intersect4)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected3,
            $cover3->intersectUassoc(
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
        $intersect5 = ['a' => 'apple', 'b' => 'banana'];

        $expected4 = array_intersect_uassoc($data4, $intersect5, $caseInsensitiveCallback);

        $cover4 = new CoverArray($data4);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected4,
            $cover4->intersectUassoc($caseInsensitiveCallback, $intersect5)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected4,
            $cover4->intersectUassoc($caseInsensitiveCallback, new CoverArray($intersect5))->getDataAsArray()
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
        $intersect6 = ['aa' => 10, 'ccc' => 3];

        $expected5 = array_intersect_uassoc($data5, $intersect6, $customCallback);

        $cover5 = new CoverArray($data5);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected5,
            $cover5->intersectUassoc($customCallback, $intersect6)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected5,
            $cover5->intersectUassoc($customCallback, new CoverArray($intersect6))->getDataAsArray()
        );

        // Test with empty intersection array
        // Тест с пустым массивом для пересечения
        $data6 = ['x' => 10, 'y' => 20];
        $intersect7 = [];

        $expected6 = array_intersect_uassoc($data6, $intersect7, $callback);

        $cover6 = new CoverArray($data6);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected6,
            $cover6->intersectUassoc($callback, $intersect7)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected6,
            $cover6->intersectUassoc($callback, new CoverArray($intersect7))->getDataAsArray()
        );
    }
}