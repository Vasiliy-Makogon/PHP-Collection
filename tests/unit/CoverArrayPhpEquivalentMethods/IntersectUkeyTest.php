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
     * Tests the intersectUkey() method with string keys.
     *
     * This test verifies that the intersectUkey() method correctly computes
     * the intersection of arrays with string keys using a user-defined
     * callback function for key comparison, mirroring PHP's array_intersect_ukey() function.
     *
     *
     * Тестирование метода intersectUkey() со строковыми ключами.
     *
     * Этот тест проверяет, что метод intersectUkey() корректно вычисляет
     * пересечение массивов со строковыми ключами с использованием пользовательской
     * callback-функции для сравнения ключей, отражая функцию array_intersect_ukey() PHP.
     *
     * @see CoverArray::intersectUkey()
     * @see array_intersect_ukey()
     */
    public function testIntersectUkeyWithStringKeys(): void
    {
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $intersect = ['a' => 10, 'b' => 20, 'd' => 40];

        $expected = array_intersect_ukey($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUkey($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUkey($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUkey() method with numeric keys.
     *
     * This test verifies that the intersectUkey() method correctly computes
     * the intersection of arrays with numeric keys using a user-defined
     * callback function for key comparison, mirroring PHP's array_intersect_ukey() function.
     *
     *
     * Тестирование метода intersectUkey() с числовыми ключами.
     *
     * Этот тест проверяет, что метод intersectUkey() корректно вычисляет
     * пересечение массивов с числовыми ключами с использованием пользовательской
     * callback-функции для сравнения ключей, отражая функцию array_intersect_ukey() PHP.
     *
     * @see CoverArray::intersectUkey()
     * @see array_intersect_ukey()
     */
    public function testIntersectUkeyWithNumericKeys(): void
    {
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        $data = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $intersect = [1 => 'ONE', 2 => 'TWO', 3 => 'three'];

        $expected = array_intersect_ukey($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUkey($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUkey($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUkey() method with multiple arrays.
     *
     * This test verifies that the intersectUkey() method correctly computes
     * the intersection of arrays with multiple arrays using a user-defined
     * callback function for key comparison, mirroring PHP's array_intersect_ukey() function.
     *
     *
     * Тестирование метода intersectUkey() с несколькими массивами.
     *
     * Этот тест проверяет, что метод intersectUkey() корректно вычисляет
     * пересечение массивов с несколькими массивами с использованием пользовательской
     * callback-функции для сравнения ключей, отражая функцию array_intersect_ukey() PHP.
     *
     * @see CoverArray::intersectUkey()
     * @see array_intersect_ukey()
     */
    public function testIntersectUkeyWithMultipleArrays(): void
    {
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect1 = ['a' => 10, 'b' => 20];
        $intersect2 = ['c' => 30, 'd' => 40];

        $expected = array_intersect_ukey($data, $intersect1, $intersect2, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUkey($callback, $intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUkey(
                $callback,
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUkey() method with case-insensitive comparison.
     *
     * This test verifies that the intersectUkey() method correctly computes
     * the intersection of arrays using a case-insensitive callback function
     * for key comparison, mirroring PHP's array_intersect_ukey() function.
     *
     *
     * Тестирование метода intersectUkey() с сравнением без учета регистра.
     *
     * Этот тест проверяет, что метод intersectUkey() корректно вычисляет
     * пересечение массивов с использованием callback-функции без учета регистра
     * для сравнения ключей, отражая функцию array_intersect_ukey() PHP.
     *
     * @see CoverArray::intersectUkey()
     * @see array_intersect_ukey()
     */
    public function testIntersectUkeyWithCaseInsensitiveComparison(): void
    {
        $caseInsensitiveCallback = function ($a, $b) {
            return strcasecmp((string) $a, (string) $b);
        };

        $data = ['A' => 'apple', 'B' => 'banana', 'c' => 'cherry'];
        $intersect = ['a' => 'apricot', 'b' => 'blueberry'];

        $expected = array_intersect_ukey($data, $intersect, $caseInsensitiveCallback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUkey($caseInsensitiveCallback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUkey($caseInsensitiveCallback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUkey() method with custom key comparison logic.
     *
     * This test verifies that the intersectUkey() method correctly computes
     * the intersection of arrays using a custom callback function that
     * implements specific key comparison logic, mirroring PHP's array_intersect_ukey() function.
     *
     *
     * Тестирование метода intersectUkey() с пользовательской логикой сравнения ключей.
     *
     * Этот тест проверяет, что метод intersectUkey() корректно вычисляет
     * пересечение массивов с использованием пользовательской callback-функции,
     * реализующей специфическую логику сравнения ключей, отражая функцию array_intersect_ukey() PHP.
     *
     * @see CoverArray::intersectUkey()
     * @see array_intersect_ukey()
     */
    public function testIntersectUkeyWithCustomKeyComparisonLogic(): void
    {
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

        $data = ['aa' => 1, 'b' => 2, 'ccc' => 3];
        $intersect = ['aa' => 10, 'ccc' => 30];

        $expected = array_intersect_ukey($data, $intersect, $customCallback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUkey($customCallback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUkey($customCallback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUkey() method with empty intersection array.
     *
     * This test verifies that the intersectUkey() method correctly handles
     * empty intersection arrays, returning an empty result, mirroring
     * PHP's array_intersect_ukey() function behavior.
     *
     *
     * Тестирование метода intersectUkey() с пустым массивом для пересечения.
     *
     * Этот тест проверяет, что метод intersectUkey() корректно обрабатывает
     * пустые массивы для пересечения, возвращая пустой результат, отражая
     * поведение функции array_intersect_ukey() PHP.
     *
     * @see CoverArray::intersectUkey()
     * @see array_intersect_ukey()
     */
    public function testIntersectUkeyWithEmptyIntersectionArray(): void
    {
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        $data = ['x' => 10, 'y' => 20];
        $intersect = [];

        $expected = array_intersect_ukey($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUkey($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUkey($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUkey() method with no common keys.
     *
     * This test verifies that the intersectUkey() method correctly handles
     * arrays with no common keys, returning an empty result, mirroring
     * PHP's array_intersect_ukey() function behavior.
     *
     *
     * Тестирование метода intersectUkey() без общих ключей.
     *
     * Этот тест проверяет, что метод intersectUkey() корректно обрабатывает
     * массивы без общих ключей, возвращая пустой результат, отражая
     * поведение функции array_intersect_ukey() PHP.
     *
     * @see CoverArray::intersectUkey()
     * @see array_intersect_ukey()
     */
    public function testIntersectUkeyWithNoCommonKeys(): void
    {
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        $data = ['a' => 1, 'b' => 2];
        $intersect = ['c' => 3, 'd' => 4];

        $expected = array_intersect_ukey($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUkey($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUkey($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUkey() method with empty data array.
     *
     * This test verifies that the intersectUkey() method correctly handles
     * empty data arrays, returning an empty result, mirroring
     * PHP's array_intersect_ukey() function behavior.
     *
     *
     * Тестирование метода intersectUkey() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод intersectUkey() корректно обрабатывает
     * пустые исходные массивы, возвращая пустой результат, отражая
     * поведение функции array_intersect_ukey() PHP.
     *
     * @see CoverArray::intersectUkey()
     * @see array_intersect_ukey()
     */
    public function testIntersectUkeyWithEmptyDataArray(): void
    {
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        $data = [];
        $intersect = ['a' => 1, 'b' => 2];

        $expected = array_intersect_ukey($data, $intersect, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUkey($callback, $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUkey($callback, new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUkey() method with mixed array and CoverArray arguments.
     *
     * This test verifies that the intersectUkey() method correctly handles
     * a mix of array and CoverArray arguments, using a user-defined callback
     * function for key comparison, mirroring PHP's array_intersect_ukey() function.
     *
     *
     * Тестирование метода intersectUkey() со смешанными аргументами массив и CoverArray.
     *
     * Этот тест проверяет, что метод intersectUkey() корректно обрабатывает
     * смесь аргументов массива и CoverArray, используя пользовательскую callback-функцию
     * для сравнения ключей, отражая функцию array_intersect_ukey() PHP.
     *
     * @see CoverArray::intersectUkey()
     * @see array_intersect_ukey()
     */
    public function testIntersectUkeyWithMixedArrayAndCoverArrayArguments(): void
    {
        $callback = function ($a, $b) {
            if ($a === $b) {
                return 0;
            }
            return $a <=> $b;
        };

        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect1 = ['a' => 10, 'b' => 20];
        $intersect2 = ['c' => 30];
        $intersect3 = ['d' => 40];

        $expected = array_intersect_ukey($data, $intersect1, $intersect2, $intersect3, $callback);

        $cover = new CoverArray($data);

        // Mix of array and CoverArray arguments
        // Смесь аргументов массив и CoverArray
        $result = $cover->intersectUkey(
            $callback,
            $intersect1,
            new CoverArray($intersect2),
            $intersect3
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }
}