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
     * Callback for mixed key types comparison.
     *
     * Callback для сравнения смешанных типов ключей.
     */
    public function mixedKeyCallback($a, $b): int
    {
        if ($a === $b) {
            return 0;
        }
        return $a <=> $b;
    }

    /**
     * Case-insensitive comparison callback.
     *
     * Callback для сравнения без учета регистра.
     */
    public function caseInsensitiveCallback($a, $b): int
    {
        return strcasecmp((string) $a, (string) $b);
    }

    /**
     * Custom key comparison by string length.
     *
     * Пользовательское сравнение ключей по длине строки.
     */
    public function lengthThenStringCallback($a, $b): int
    {
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
    }

    /**
     * Tests the intersectUassoc() method with string keys.
     *
     * This test verifies that the intersectUassoc() method correctly computes
     * the intersection with string keys using a user-defined callback function
     * for key comparison, mirroring PHP's array_intersect_uassoc() function behavior.
     *
     *
     * Тестирование метода intersectUassoc() со строковыми ключами.
     *
     * Этот тест проверяет, что метод intersectUassoc() корректно вычисляет
     * пересечение со строковыми ключами с использованием пользовательской
     * callback-функции для сравнения ключей, отражая поведение функции array_intersect_uassoc() PHP.
     *
     * @see CoverArray::intersectUassoc()
     * @see array_intersect_uassoc()
     */
    public function testIntersectUassocWithStringKeys(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $intersect = ['a' => 1, 'b' => 20];

        $expected = array_intersect_uassoc($data, $intersect, [$this, 'mixedKeyCallback']);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'mixedKeyCallback'], $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'mixedKeyCallback'], new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUassoc() method with numeric keys.
     *
     * This test verifies that the intersectUassoc() method correctly computes
     * the intersection with numeric keys using a user-defined callback function
     * for key comparison, mirroring PHP's array_intersect_uassoc() function behavior.
     *
     *
     * Тестирование метода intersectUassoc() с числовыми ключами.
     *
     * Этот тест проверяет, что метод intersectUassoc() корректно вычисляет
     * пересечение с числовыми ключами с использованием пользовательской
     * callback-функции для сравнения ключей, отражая поведение функции array_intersect_uassoc() PHP.
     *
     * @see CoverArray::intersectUassoc()
     * @see array_intersect_uassoc()
     */
    public function testIntersectUassocWithNumericKeys(): void
    {
        $data = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $intersect = [0 => 'zero', 1 => 'ONE'];

        $expected = array_intersect_uassoc($data, $intersect, [$this, 'mixedKeyCallback']);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'mixedKeyCallback'], $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'mixedKeyCallback'], new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUassoc() method with multiple arrays.
     *
     * This test verifies that the intersectUassoc() method correctly computes
     * the intersection with multiple arrays using a user-defined callback function
     * for key comparison, mirroring PHP's array_intersect_uassoc() function behavior.
     *
     *
     * Тестирование метода intersectUassoc() с несколькими массивами.
     *
     * Этот тест проверяет, что метод intersectUassoc() корректно вычисляет
     * пересечение с несколькими массивами с использованием пользовательской
     * callback-функции для сравнения ключей, отражая поведение функции array_intersect_uassoc() PHP.
     *
     * @see CoverArray::intersectUassoc()
     * @see array_intersect_uassoc()
     */
    public function testIntersectUassocWithMultipleArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect1 = ['a' => 1, 'b' => 20];
        $intersect2 = ['c' => 30, 'd' => 4];

        $expected = array_intersect_uassoc($data, $intersect1, $intersect2, [$this, 'mixedKeyCallback']);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'mixedKeyCallback'], $intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUassoc(
                [$this, 'mixedKeyCallback'],
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUassoc() method with case-insensitive comparison.
     *
     * This test verifies that the intersectUassoc() method correctly computes
     * the intersection using a case-insensitive comparison callback function
     * for key comparison, mirroring PHP's array_intersect_uassoc() function behavior.
     *
     *
     * Тестирование метода intersectUassoc() с сравнением без учета регистра.
     *
     * Этот тест проверяет, что метод intersectUassoc() корректно вычисляет
     * пересечение с использованием callback-функции для сравнения без учета регистра,
     * отражая поведение функции array_intersect_uassoc() PHP.
     *
     * @see CoverArray::intersectUassoc()
     * @see array_intersect_uassoc()
     */
    public function testIntersectUassocWithCaseInsensitiveComparison(): void
    {
        $data = ['A' => 'apple', 'B' => 'banana', 'c' => 'cherry'];
        $intersect = ['a' => 'apple', 'b' => 'banana'];

        $expected = array_intersect_uassoc($data, $intersect, [$this, 'caseInsensitiveCallback']);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'caseInsensitiveCallback'], $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'caseInsensitiveCallback'], new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUassoc() method with custom key comparison logic.
     *
     * This test verifies that the intersectUassoc() method correctly computes
     * the intersection using a custom callback function that compares keys
     * by string length first, mirroring PHP's array_intersect_uassoc() function behavior.
     *
     *
     * Тестирование метода intersectUassoc() с пользовательской логикой сравнения ключей.
     *
     * Этот тест проверяет, что метод intersectUassoc() корректно вычисляет
     * пересечение с использованием пользовательской callback-функции, которая сравнивает
     * ключи сначала по длине строки, отражая поведение функции array_intersect_uassoc() PHP.
     *
     * @see CoverArray::intersectUassoc()
     * @see array_intersect_uassoc()
     */
    public function testIntersectUassocWithCustomKeyComparison(): void
    {
        $data = ['aa' => 1, 'b' => 2, 'ccc' => 3];
        $intersect = ['aa' => 10, 'ccc' => 3];

        $expected = array_intersect_uassoc($data, $intersect, [$this, 'lengthThenStringCallback']);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'lengthThenStringCallback'], $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'lengthThenStringCallback'], new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUassoc() method with empty intersection array.
     *
     * This test verifies that the intersectUassoc() method correctly handles
     * empty intersection arrays, returning an empty result, mirroring
     * PHP's array_intersect_uassoc() function behavior.
     *
     *
     * Тестирование метода intersectUassoc() с пустым массивом для пересечения.
     *
     * Этот тест проверяет, что метод intersectUassoc() корректно обрабатывает
     * пустые массивы для пересечения, возвращая пустой результат,
     * отражая поведение функции array_intersect_uassoc() PHP.
     *
     * @see CoverArray::intersectUassoc()
     * @see array_intersect_uassoc()
     */
    public function testIntersectUassocWithEmptyIntersectionArray(): void
    {
        $data = ['x' => 10, 'y' => 20];
        $intersect = [];

        $expected = array_intersect_uassoc($data, $intersect, [$this, 'mixedKeyCallback']);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'mixedKeyCallback'], $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'mixedKeyCallback'], new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUassoc() method with empty data array.
     *
     * This test verifies that the intersectUassoc() method correctly handles
     * empty data arrays, returning an empty result, mirroring
     * PHP's array_intersect_uassoc() function behavior.
     *
     *
     * Тестирование метода intersectUassoc() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод intersectUassoc() корректно обрабатывает
     * пустые исходные массивы, возвращая пустой результат,
     * отражая поведение функции array_intersect_uassoc() PHP.
     *
     * @see CoverArray::intersectUassoc()
     * @see array_intersect_uassoc()
     */
    public function testIntersectUassocWithEmptyDataArray(): void
    {
        $data = [];
        $intersect = ['a' => 1, 'b' => 2];

        $expected = array_intersect_uassoc($data, $intersect, [$this, 'mixedKeyCallback']);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'mixedKeyCallback'], $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'mixedKeyCallback'], new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectUassoc() method with mixed array and CoverArray arguments.
     *
     * This test verifies that the intersectUassoc() method correctly handles
     * a mix of array and CoverArray arguments using a user-defined callback
     * for key comparison, mirroring PHP's array_intersect_uassoc() function behavior.
     *
     *
     * Тестирование метода intersectUassoc() со смешанными аргументами массив и CoverArray.
     *
     * Этот тест проверяет, что метод intersectUassoc() корректно обрабатывает
     * смесь аргументов массива и CoverArray с использованием пользовательской
     * callback-функции для сравнения ключей, отражая поведение функции array_intersect_uassoc() PHP.
     *
     * @see CoverArray::intersectUassoc()
     * @see array_intersect_uassoc()
     */
    public function testIntersectUassocWithMixedArrayAndCoverArrayArguments(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $intersect1 = ['b' => 2];
        $intersect2 = ['c' => 3];

        $expected = array_intersect_uassoc($data, $intersect1, $intersect2, [$this, 'mixedKeyCallback']);

        $cover = new CoverArray($data);

        // Mix of array and CoverArray arguments
        // Смесь аргументов массив и CoverArray
        $result = $cover->intersectUassoc(
            [$this, 'mixedKeyCallback'],
            $intersect1,
            new CoverArray($intersect2)
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }

    /**
     * Tests the intersectUassoc() method with single intersection array.
     *
     * This test verifies that the intersectUassoc() method correctly computes
     * the intersection with a single array using a user-defined callback function
     * for key comparison, mirroring PHP's array_intersect_uassoc() function behavior.
     *
     *
     * Тестирование метода intersectUassoc() с одним массивом для пересечения.
     *
     * Этот тест проверяет, что метод intersectUassoc() корректно вычисляет
     * пересечение с одним массивом с использованием пользовательской
     * callback-функции для сравнения ключей, отражая поведение функции array_intersect_uassoc() PHP.
     *
     * @see CoverArray::intersectUassoc()
     * @see array_intersect_uassoc()
     */
    public function testIntersectUassocWithSingleIntersectionArray(): void
    {
        $data = ['x' => 10, 'y' => 20, 'z' => 30];
        $intersect = ['x' => 10, 'y' => 25];

        $expected = array_intersect_uassoc($data, $intersect, [$this, 'mixedKeyCallback']);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'mixedKeyCallback'], $intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectUassoc([$this, 'mixedKeyCallback'], new CoverArray($intersect))->getDataAsArray()
        );
    }
}