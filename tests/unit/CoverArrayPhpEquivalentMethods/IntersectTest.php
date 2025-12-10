<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class IntersectTest extends TestCase
{
    /**
     * Tests the intersect() method with simple arrays.
     *
     * This test verifies that the intersect() method correctly computes
     * the intersection of simple arrays based on values, returning elements
     * present in all provided arrays, mirroring PHP's array_intersect() function.
     *
     *
     * Тестирование метода intersect() с простыми массивами.
     *
     * Этот тест проверяет, что метод intersect() корректно вычисляет
     * пересечение простых массивов на основе значений, возвращая элементы,
     * присутствующие во всех предоставленных массивах, отражая функцию array_intersect() PHP.
     *
     * @see CoverArray::intersect()
     * @see array_intersect()
     */
    public function testIntersectWithSimpleArrays(): void
    {
        $data = [1, 2, 3, 4, 5];
        $intersect1 = [2, 3, 6];
        $intersect2 = [3, 4, 7];

        $expected = array_intersect($data, $intersect1, $intersect2);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersect($intersect1, $intersect2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersect(
                new CoverArray($intersect1),
                new CoverArray($intersect2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the intersect() method with associative arrays.
     *
     * This test verifies that the intersect() method correctly computes
     * the intersection of associative arrays based on values, ignoring keys,
     * mirroring PHP's array_intersect() function behavior.
     *
     *
     * Тестирование метода intersect() с ассоциативными массивами.
     *
     * Этот тест проверяет, что метод intersect() корректно вычисляет
     * пересечение ассоциативных массивов на основе значений, игнорируя ключи,
     * отражая поведение функции array_intersect() PHP.
     *
     * @see CoverArray::intersect()
     * @see array_intersect()
     */
    public function testIntersectWithAssociativeArrays(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date'];
        $intersect = ['banana', 'date', 'elderberry'];

        $expected = array_intersect($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersect($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersect(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersect() method with multiple arrays.
     *
     * This test verifies that the intersect() method correctly computes
     * the intersection with multiple arrays, returning elements present
     * in all provided arrays, mirroring PHP's array_intersect() function.
     *
     *
     * Тестирование метода intersect() с несколькими массивами.
     *
     * Этот тест проверяет, что метод intersect() корректно вычисляет
     * пересечение с несколькими массивами, возвращая элементы, присутствующие
     * во всех предоставленных массивах, отражая функцию array_intersect() PHP.
     *
     * @see CoverArray::intersect()
     * @see array_intersect()
     */
    public function testIntersectWithMultipleArrays(): void
    {
        $data = ['red', 'green', 'blue', 'yellow', 'purple'];
        $intersect1 = ['green', 'yellow', 'orange'];
        $intersect2 = ['blue', 'green', 'violet'];
        $intersect3 = ['green', 'indigo'];

        $expected = array_intersect($data, $intersect1, $intersect2, $intersect3);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersect($intersect1, $intersect2, $intersect3)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersect(
                new CoverArray($intersect1),
                new CoverArray($intersect2),
                new CoverArray($intersect3)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the intersect() method with empty intersection array.
     *
     * This test verifies that the intersect() method correctly handles
     * empty intersection arrays, returning an empty result, mirroring
     * PHP's array_intersect() function behavior.
     *
     *
     * Тестирование метода intersect() с пустым массивом для пересечения.
     *
     * Этот тест проверяет, что метод intersect() корректно обрабатывает
     * пустые массивы для пересечения, возвращая пустой результат, отражая
     * поведение функции array_intersect() PHP.
     *
     * @see CoverArray::intersect()
     * @see array_intersect()
     */
    public function testIntersectWithEmptyIntersectionArray(): void
    {
        $data = ['a', 'b', 'c'];
        $intersect = [];

        $expected = array_intersect($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersect($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersect(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersect() method with no intersection.
     *
     * This test verifies that the intersect() method correctly returns
     * an empty array when there is no intersection between arrays,
     * mirroring PHP's array_intersect() function behavior.
     *
     *
     * Тестирование метода intersect() без пересечения.
     *
     * Этот тест проверяет, что метод intersect() корректно возвращает
     * пустой массив, когда нет пересечения между массивами,
     * отражая поведение функции array_intersect() PHP.
     *
     * @see CoverArray::intersect()
     * @see array_intersect()
     */
    public function testIntersectWithNoIntersection(): void
    {
        $data = [1, 2, 3];
        $intersect = [4, 5, 6];

        $expected = array_intersect($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersect($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersect(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersect() method with empty data array.
     *
     * This test verifies that the intersect() method correctly handles
     * empty data arrays, returning an empty result, mirroring
     * PHP's array_intersect() function behavior.
     *
     *
     * Тестирование метода intersect() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод intersect() корректно обрабатывает
     * пустые исходные массивы, возвращая пустой результат, отражая
     * поведение функции array_intersect() PHP.
     *
     * @see CoverArray::intersect()
     * @see array_intersect()
     */
    public function testIntersectWithEmptyDataArray(): void
    {
        $data = [];
        $intersect = [1, 2, 3];

        $expected = array_intersect($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersect($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersect(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersect() method with duplicate values.
     *
     * This test verifies that the intersect() method correctly handles
     * arrays with duplicate values, preserving duplicates in the result,
     * mirroring PHP's array_intersect() function behavior.
     *
     *
     * Тестирование метода intersect() с дублирующимися значениями.
     *
     * Этот тест проверяет, что метод intersect() корректно обрабатывает
     * массивы с дублирующимися значениями, сохраняя дубликаты в результате,
     * отражая поведение функции array_intersect() PHP.
     *
     * @see CoverArray::intersect()
     * @see array_intersect()
     */
    public function testIntersectWithDuplicateValues(): void
    {
        $data = [1, 2, 2, 3, 3, 3];
        $intersect = [2, 3, 3, 4];

        $expected = array_intersect($data, $intersect);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->intersect($intersect)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->intersect(new CoverArray($intersect))->getDataAsArray()
        );
    }

    /**
     * Tests the intersect() method with mixed array and CoverArray arguments.
     *
     * This test verifies that the intersect() method correctly handles
     * a mix of array and CoverArray arguments, computing the intersection
     * based on values, mirroring PHP's array_intersect() function behavior.
     *
     *
     * Тестирование метода intersect() со смешанными аргументами массив и CoverArray.
     *
     * Этот тест проверяет, что метод intersect() корректно обрабатывает
     * смесь аргументов массива и CoverArray, вычисляя пересечение
     * на основе значений, отражая поведение функции array_intersect() PHP.
     *
     * @see CoverArray::intersect()
     * @see array_intersect()
     */
    public function testIntersectWithMixedArrayAndCoverArrayArguments(): void
    {
        $data = ['a', 'b', 'c', 'd', 'e'];
        $intersect1 = ['b', 'c', 'f'];
        $intersect2 = ['c', 'd', 'g'];

        $expected = array_intersect($data, $intersect1, $intersect2);

        $cover = new CoverArray($data);

        // Mix of array and CoverArray arguments
        // Смесь аргументов массив и CoverArray
        $result = $cover->intersect(
            $intersect1,
            new CoverArray($intersect2)
        );

        $this->assertSame($expected, $result->getDataAsArray());
    }
}