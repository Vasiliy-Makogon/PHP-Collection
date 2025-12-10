<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class IntersectKeyTest extends TestCase
{
    /**
     * Tests the intersectKey() method with associative arrays.
     *
     * This test verifies that the intersectKey() method correctly computes
     * the intersection of associative arrays using keys for comparison,
     * returning elements with keys present in all arrays, mirroring
     * PHP's array_intersect_key() function behavior.
     *
     *
     * Тестирование метода intersectKey() с ассоциативными массивами.
     *
     * Этот тест проверяет, что метод intersectKey() корректно вычисляет
     * пересечение ассоциативных массивов, используя ключи для сравнения,
     * возвращая элементы с ключами, присутствующими во всех массивах,
     * отражая поведение функции array_intersect_key() PHP.
     *
     * @see CoverArray::intersectKey()
     * @see array_intersect_key()
     */
    public function testIntersectKeyWithAssociativeArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect = ['b' => 20, 'c' => 30, 'e' => 50];

        $expected = array_intersect_key($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectKey($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectKey(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectKey() method with multiple arrays.
     *
     * This test verifies that the intersectKey() method correctly computes
     * the intersection with multiple arrays using keys for comparison,
     * returning elements with keys present in all provided arrays,
     * mirroring PHP's array_intersect_key() function behavior.
     *
     *
     * Тестирование метода intersectKey() с несколькими массивами.
     *
     * Этот тест проверяет, что метод intersectKey() корректно вычисляет
     * пересечение с несколькими массивами, используя ключи для сравнения,
     * возвращая элементы с ключами, присутствующими во всех предоставленных массивах,
     * отражая поведение функции array_intersect_key() PHP.
     *
     * @see CoverArray::intersectKey()
     * @see array_intersect_key()
     */
    public function testIntersectKeyWithMultipleArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5];
        $intersect1 = ['a' => 10, 'c' => 30];
        $intersect2 = ['b' => 200, 'd' => 400, 'e' => 500];

        $expected = array_intersect_key($data, $intersect1, $intersect2);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectKey($intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectKey(
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the intersectKey() method with numeric keys.
     *
     * This test verifies that the intersectKey() method correctly handles
     * numeric keys, returning elements with numeric keys present in all arrays,
     * mirroring PHP's array_intersect_key() function behavior.
     *
     *
     * Тестирование метода intersectKey() с числовыми ключами.
     *
     * Этот тест проверяет, что метод intersectKey() корректно обрабатывает
     * числовые ключи, возвращая элементы с числовыми ключами, присутствующими во всех массивах,
     * отражая поведение функции array_intersect_key() PHP.
     *
     * @see CoverArray::intersectKey()
     * @see array_intersect_key()
     */
    public function testIntersectKeyWithNumericKeys(): void
    {
        $data = [0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three'];
        $intersect = [1 => 'ONE', 3 => 'THREE', 4 => 'four'];

        $expected = array_intersect_key($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectKey($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectKey(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectKey() method with mixed key types.
     *
     * This test verifies that the intersectKey() method correctly handles
     * arrays with mixed key types (string and numeric), using keys for comparison,
     * mirroring PHP's array_intersect_key() function behavior.
     *
     *
     * Тестирование метода intersectKey() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод intersectKey() корректно обрабатывает
     * массивы со смешанными типами ключей (строка и число), используя ключи для сравнения,
     * отражая поведение функции array_intersect_key() PHP.
     *
     * @see CoverArray::intersectKey()
     * @see array_intersect_key()
     */
    public function testIntersectKeyWithMixedKeyTypes(): void
    {
        $data = ['a' => 'apple', 0 => 'zero', '1' => 'one'];
        $intersect = ['a' => 'apricot', 0 => 'ZERO'];

        $expected = array_intersect_key($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectKey($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectKey(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectKey() method with empty intersection array.
     *
     * This test verifies that the intersectKey() method correctly handles
     * empty intersection arrays, returning an empty result, mirroring
     * PHP's array_intersect_key() function behavior.
     *
     *
     * Тестирование метода intersectKey() с пустым массивом для пересечения.
     *
     * Этот тест проверяет, что метод intersectKey() корректно обрабатывает
     * пустые массивы для пересечения, возвращая пустой результат, отражая
     * поведение функции array_intersect_key() PHP.
     *
     * @see CoverArray::intersectKey()
     * @see array_intersect_key()
     */
    public function testIntersectKeyWithEmptyIntersectionArray(): void
    {
        $data = ['x' => 10, 'y' => 20, 'z' => 30];
        $intersect = [];

        $expected = array_intersect_key($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectKey($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectKey(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectKey() method with no common keys.
     *
     * This test verifies that the intersectKey() method correctly returns
     * an empty array when there are no common keys, mirroring
     * PHP's array_intersect_key() function behavior.
     *
     *
     * Тестирование метода intersectKey() без общих ключей.
     *
     * Этот тест проверяет, что метод intersectKey() корректно возвращает
     * пустой массив, когда нет общих ключей, отражая поведение функции array_intersect_key() PHP.
     *
     * @see CoverArray::intersectKey()
     * @see array_intersect_key()
     */
    public function testIntersectKeyWithNoCommonKeys(): void
    {
        $data = ['a' => 1, 'b' => 2];
        $intersect = ['c' => 3, 'd' => 4];

        $expected = array_intersect_key($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectKey($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectKey(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectKey() method with empty data array.
     *
     * This test verifies that the intersectKey() method correctly handles
     * empty data arrays, returning an empty result, mirroring
     * PHP's array_intersect_key() function behavior.
     *
     *
     * Тестирование метода intersectKey() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод intersectKey() корректно обрабатывает
     * пустые исходные массивы, возвращая пустой результат, отражая
     * поведение функции array_intersect_key() PHP.
     *
     * @see CoverArray::intersectKey()
     * @see array_intersect_key()
     */
    public function testIntersectKeyWithEmptyDataArray(): void
    {
        $data = [];
        $intersect = ['a' => 1, 'b' => 2];

        $expected = array_intersect_key($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectKey($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectKey(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectKey() method with mixed array and CoverArray arguments.
     *
     * This test verifies that the intersectKey() method correctly handles
     * a mix of array and CoverArray arguments, using keys for comparison,
     * mirroring PHP's array_intersect_key() function behavior.
     *
     *
     * Тестирование метода intersectKey() со смешанными аргументами массив и CoverArray.
     *
     * Этот тест проверяет, что метод intersectKey() корректно обрабатывает
     * смесь аргументов массива и CoverArray, используя ключи для сравнения,
     * отражая поведение функции array_intersect_key() PHP.
     *
     * @see CoverArray::intersectKey()
     * @see array_intersect_key()
     */
    public function testIntersectKeyWithMixedArrayAndCoverArrayArguments(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $intersect1 = ['b' => 20];
        $intersect2 = ['c' => 30];

        $expected = array_intersect_key($data, $intersect1, $intersect2);

        $cover = new CoverArray($data);

        // Mix of array and CoverArray arguments
        // Смесь аргументов массив и CoverArray
        $result = $cover->intersectKey(
            $intersect1,
            new CoverArray($intersect2)
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }
}