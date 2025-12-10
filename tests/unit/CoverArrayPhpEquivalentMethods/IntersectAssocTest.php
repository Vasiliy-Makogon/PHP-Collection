<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class IntersectAssocTest extends TestCase
{
    /**
     * Tests the intersectAssoc() method with associative arrays.
     *
     * This test verifies that the intersectAssoc() method correctly computes
     * the intersection of associative arrays comparing both keys and values,
     * mirroring PHP's array_intersect_assoc() function behavior.
     *
     *
     * Тестирование метода intersectAssoc() с ассоциативными массивами.
     *
     * Этот тест проверяет, что метод intersectAssoc() корректно вычисляет
     * пересечение ассоциативных массивов, сравнивая как ключи, так и значения,
     * отражая поведение функции array_intersect_assoc() PHP.
     *
     * @see CoverArray::intersectAssoc()
     * @see array_intersect_assoc()
     */
    public function testIntersectAssocWithAssociativeArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect = ['b' => 2, 'c' => 30, 'e' => 5];

        $expected = array_intersect_assoc($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectAssoc($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectAssoc(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectAssoc() method with multiple arrays.
     *
     * This test verifies that the intersectAssoc() method correctly computes
     * the intersection with multiple arrays, comparing both keys and values
     * across all arrays, mirroring PHP's array_intersect_assoc() function behavior.
     *
     *
     * Тестирование метода intersectAssoc() с несколькими массивами.
     *
     * Этот тест проверяет, что метод intersectAssoc() корректно вычисляет
     * пересечение с несколькими массивами, сравнивая как ключи, так и значения
     * во всех массивах, отражая поведение функции array_intersect_assoc() PHP.
     *
     * @see CoverArray::intersectAssoc()
     * @see array_intersect_assoc()
     */
    public function testIntersectAssocWithMultipleArrays(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $intersect1 = ['b' => 2, 'c' => 30];
        $intersect2 = ['a' => 1, 'd' => 40];

        $expected = array_intersect_assoc($data, $intersect1, $intersect2);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectAssoc($intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectAssoc(
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the intersectAssoc() method with numeric keys.
     *
     * This test verifies that the intersectAssoc() method correctly handles
     * numeric keys, requiring both key and value to match, mirroring
     * PHP's array_intersect_assoc() function behavior.
     *
     *
     * Тестирование метода intersectAssoc() с числовыми ключами.
     *
     * Этот тест проверяет, что метод intersectAssoc() корректно обрабатывает
     * числовые ключи, требуя совпадения и ключа, и значения, отражая
     * поведение функции array_intersect_assoc() PHP.
     *
     * @see CoverArray::intersectAssoc()
     * @see array_intersect_assoc()
     */
    public function testIntersectAssocWithNumericKeys(): void
    {
        $data = [0 => 'zero', 1 => 'one', 2 => 'two'];
        $intersect = [0 => 'zero', 1 => 'ONE', 2 => 'two'];

        $expected = array_intersect_assoc($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectAssoc($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectAssoc(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectAssoc() method with mixed key types.
     *
     * This test verifies that the intersectAssoc() method correctly handles
     * arrays with mixed key types (string and numeric), comparing both
     * keys and values, mirroring PHP's array_intersect_assoc() function behavior.
     *
     *
     * Тестирование метода intersectAssoc() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод intersectAssoc() корректно обрабатывает
     * массивы со смешанными типами ключей (строка и число), сравнивая как
     * ключи, так и значения, отражая поведение функции array_intersect_assoc() PHP.
     *
     * @see CoverArray::intersectAssoc()
     * @see array_intersect_assoc()
     */
    public function testIntersectAssocWithMixedKeyTypes(): void
    {
        $data = ['a' => 'apple', 0 => 'zero', '1' => 'one'];
        $intersect = ['a' => 'apple', 0 => 'ZERO', '1' => 'one'];

        $expected = array_intersect_assoc($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectAssoc($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectAssoc(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectAssoc() method with empty intersection array.
     *
     * This test verifies that the intersectAssoc() method correctly handles
     * empty intersection arrays, returning an empty result, mirroring
     * PHP's array_intersect_assoc() function behavior.
     *
     *
     * Тестирование метода intersectAssoc() с пустым массивом для пересечения.
     *
     * Этот тест проверяет, что метод intersectAssoc() корректно обрабатывает
     * пустые массивы для пересечения, возвращая пустой результат, отражая
     * поведение функции array_intersect_assoc() PHP.
     *
     * @see CoverArray::intersectAssoc()
     * @see array_intersect_assoc()
     */
    public function testIntersectAssocWithEmptyIntersectionArray(): void
    {
        $data = ['x' => 10, 'y' => 20, 'z' => 30];
        $intersect = [];

        $expected = array_intersect_assoc($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectAssoc($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectAssoc(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectAssoc() method with complete match.
     *
     * This test verifies that the intersectAssoc() method correctly returns
     * all elements when there is a complete match of keys and values,
     * mirroring PHP's array_intersect_assoc() function behavior.
     *
     *
     * Тестирование метода intersectAssoc() с полным совпадением.
     *
     * Этот тест проверяет, что метод intersectAssoc() корректно возвращает
     * все элементы при полном совпадении ключей и значений,
     * отражая поведение функции array_intersect_assoc() PHP.
     *
     * @see CoverArray::intersectAssoc()
     * @see array_intersect_assoc()
     */
    public function testIntersectAssocWithCompleteMatch(): void
    {
        $data = ['a' => 1, 'b' => 2];
        $intersect = ['a' => 1, 'b' => 2];

        $expected = array_intersect_assoc($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectAssoc($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectAssoc(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectAssoc() method with empty data array.
     *
     * This test verifies that the intersectAssoc() method correctly handles
     * empty data arrays, returning an empty result, mirroring
     * PHP's array_intersect_assoc() function behavior.
     *
     *
     * Тестирование метода intersectAssoc() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод intersectAssoc() корректно обрабатывает
     * пустые исходные массивы, возвращая пустой результат, отражая
     * поведение функции array_intersect_assoc() PHP.
     *
     * @see CoverArray::intersectAssoc()
     * @see array_intersect_assoc()
     */
    public function testIntersectAssocWithEmptyDataArray(): void
    {
        $data = [];
        $intersect = ['a' => 1, 'b' => 2];

        $expected = array_intersect_assoc($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersectAssoc($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersectAssoc(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersectAssoc() method with mixed array and CoverArray arguments.
     *
     * This test verifies that the intersectAssoc() method correctly handles
     * a mix of array and CoverArray arguments, comparing both keys and values,
     * mirroring PHP's array_intersect_assoc() function behavior.
     *
     *
     * Тестирование метода intersectAssoc() со смешанными аргументами массив и CoverArray.
     *
     * Этот тест проверяет, что метод intersectAssoc() корректно обрабатывает
     * смесь аргументов массива и CoverArray, сравнивая как ключи, так и значения,
     * отражая поведение функции array_intersect_assoc() PHP.
     *
     * @see CoverArray::intersectAssoc()
     * @see array_intersect_assoc()
     */
    public function testIntersectAssocWithMixedArrayAndCoverArrayArguments(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $intersect1 = ['b' => 2];
        $intersect2 = ['c' => 3];

        $expected = array_intersect_assoc($data, $intersect1, $intersect2);

        $cover = new CoverArray($data);

        // Mix of array and CoverArray arguments
        // Смесь аргументов массив и CoverArray
        $result = $cover->intersectAssoc(
            $intersect1,
            new CoverArray($intersect2)
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }
}