<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class UdiffTest extends TestCase
{
    /**
     * Tests the udiff() method with simple numeric comparison.
     *
     * This test verifies that the udiff() method correctly computes
     * the difference of arrays using a callback function for value comparison,
     * mirroring PHP's array_udiff() function behavior.
     *
     *
     * Тестирование метода udiff() с простым числовым сравнением.
     *
     * Этот тест проверяет, что метод udiff() корректно вычисляет
     * расхождение массивов, используя callback-функцию для сравнения значений,
     * отражая поведение функции array_udiff() PHP.
     *
     * @see CoverArray::udiff()
     * @see array_udiff()
     */
    public function testUdiffWithNumericComparison(): void
    {
        $data = [1, 2, 3, 4, 5];
        $diff1 = [2, 4];
        $diff2 = [3];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff($data, $diff1, $diff2, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiff($callback, $diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiff(
                $callback,
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the udiff() method with string comparison callback.
     *
     * This test verifies that the udiff() method correctly computes
     * the difference of string arrays using a custom comparison callback,
     * mirroring PHP's array_udiff() function behavior.
     *
     *
     * Тестирование метода udiff() с callback для сравнения строк.
     *
     * Этот тест проверяет, что метод udiff() корректно вычисляет
     * расхождение строковых массивов, используя пользовательский callback сравнения,
     * отражая поведение функции array_udiff() PHP.
     *
     * @see CoverArray::udiff()
     * @see array_udiff()
     */
    public function testUdiffWithStringComparison(): void
    {
        $data = ['apple', 'banana', 'cherry', 'date'];
        $diff = ['banana', 'date'];

        $callback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiff($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiff($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiff() method with case-insensitive comparison.
     *
     * This test verifies that the udiff() method correctly uses
     * a custom callback for case-insensitive comparison,
     * mirroring PHP's array_udiff() function behavior.
     *
     *
     * Тестирование метода udiff() с регистронезависимым сравнением.
     *
     * Этот тест проверяет, что метод udiff() корректно использует
     * пользовательский callback для регистронезависимого сравнения,
     * отражая поведение функции array_udiff() PHP.
     *
     * @see CoverArray::udiff()
     * @see array_udiff()
     */
    public function testUdiffWithCaseInsensitiveComparison(): void
    {
        $data = ['Apple', 'Banana', 'Cherry'];
        $diff = ['apple', 'CHERRY'];

        $callback = function ($a, $b) {
            return strcasecmp($a, $b);
        };

        $expected = array_udiff($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiff($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiff($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiff() method with associative arrays.
     *
     * This test verifies that the udiff() method correctly computes
     * the difference of associative arrays using callback for value comparison,
     * preserving keys, mirroring PHP's array_udiff() function behavior.
     *
     *
     * Тестирование метода udiff() с ассоциативными массивами.
     *
     * Этот тест проверяет, что метод udiff() корректно вычисляет
     * расхождение ассоциативных массивов, используя callback для сравнения значений,
     * сохраняя ключи, отражая поведение функции array_udiff() PHP.
     *
     * @see CoverArray::udiff()
     * @see array_udiff()
     */
    public function testUdiffWithAssociativeArrays(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date'];
        $diff = ['x' => 'banana', 'y' => 'date'];

        $callback = function ($a, $b) {
            return strcmp($a, $b);
        };

        $expected = array_udiff($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiff($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiff($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiff() method with empty result.
     *
     * This test verifies that the udiff() method returns an empty array
     * when all elements are found in comparison arrays,
     * mirroring PHP's array_udiff() function behavior.
     *
     *
     * Тестирование метода udiff() с пустым результатом.
     *
     * Этот тест проверяет, что метод udiff() возвращает пустой массив,
     * когда все элементы найдены в массивах сравнения,
     * отражая поведение функции array_udiff() PHP.
     *
     * @see CoverArray::udiff()
     * @see array_udiff()
     */
    public function testUdiffWithEmptyResult(): void
    {
        $data = [1, 2, 3];
        $diff = [1, 2, 3, 4, 5];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiff($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiff($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiff() method with no difference found.
     *
     * This test verifies that the udiff() method returns the entire array
     * when no elements match in comparison arrays,
     * mirroring PHP's array_udiff() function behavior.
     *
     *
     * Тестирование метода udiff() без найденных различий.
     *
     * Этот тест проверяет, что метод udiff() возвращает весь массив,
     * когда ни один элемент не совпадает в массивах сравнения,
     * отражая поведение функции array_udiff() PHP.
     *
     * @see CoverArray::udiff()
     * @see array_udiff()
     */
    public function testUdiffWithNoDifference(): void
    {
        $data = [1, 2, 3];
        $diff = [4, 5, 6];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiff($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiff($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiff() method with custom object comparison.
     *
     * This test verifies that the udiff() method correctly uses
     * a custom callback to compare objects by their properties,
     * mirroring PHP's array_udiff() function behavior.
     *
     *
     * Тестирование метода udiff() с пользовательским сравнением объектов.
     *
     * Этот тест проверяет, что метод udiff() корректно использует
     * пользовательский callback для сравнения объектов по их свойствам,
     * отражая поведение функции array_udiff() PHP.
     *
     * @see CoverArray::udiff()
     * @see array_udiff()
     */
    public function testUdiffWithObjectComparison(): void
    {
        $obj1 = (object)['id' => 1, 'name' => 'A'];
        $obj2 = (object)['id' => 2, 'name' => 'B'];
        $obj3 = (object)['id' => 3, 'name' => 'C'];
        $obj4 = (object)['id' => 2, 'name' => 'B'];

        $data = [$obj1, $obj2, $obj3];
        $diff = [$obj4];

        $callback = function ($a, $b) {
            return $a->id <=> $b->id;
        };

        $expected = array_udiff($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiff($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiff($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiff() method with multiple comparison arrays.
     *
     * This test verifies that the udiff() method correctly handles
     * multiple comparison arrays with a custom callback,
     * mirroring PHP's array_udiff() function behavior.
     *
     *
     * Тестирование метода udiff() с несколькими массивами сравнения.
     *
     * Этот тест проверяет, что метод udiff() корректно обрабатывает
     * несколько массивов сравнения с пользовательским callback,
     * отражая поведение функции array_udiff() PHP.
     *
     * @see CoverArray::udiff()
     * @see array_udiff()
     */
    public function testUdiffWithMultipleComparisonArrays(): void
    {
        $data = [10, 20, 30, 40, 50];
        $diff1 = [20, 40];
        $diff2 = [30];
        $diff3 = [60, 70];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff($data, $diff1, $diff2, $diff3, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiff($callback, $diff1, $diff2, $diff3)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiff(
                $callback,
                new CoverArray($diff1),
                new CoverArray($diff2),
                new CoverArray($diff3)
            )->getDataAsArray()
        );
    }

    /**
     * Tests the udiff() method with empty source array.
     *
     * This test verifies that the udiff() method returns an empty array
     * when the source array is empty,
     * mirroring PHP's array_udiff() function behavior.
     *
     *
     * Тестирование метода udiff() с пустым исходным массивом.
     *
     * Этот тест проверяет, что метод udiff() возвращает пустой массив,
     * когда исходный массив пуст,
     * отражая поведение функции array_udiff() PHP.
     *
     * @see CoverArray::udiff()
     * @see array_udiff()
     */
    public function testUdiffWithEmptySourceArray(): void
    {
        $data = [];
        $diff = [1, 2, 3];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff($data, $diff, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiff($callback, $diff)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiff($callback, new CoverArray($diff))->getDataAsArray()
        );
    }

    /**
     * Tests the udiff() method with empty comparison arrays.
     *
     * This test verifies that the udiff() method returns the entire array
     * when all comparison arrays are empty,
     * mirroring PHP's array_udiff() function behavior.
     *
     *
     * Тестирование метода udiff() с пустыми массивами сравнения.
     *
     * Этот тест проверяет, что метод udiff() возвращает весь массив,
     * когда все массивы сравнения пусты,
     * отражая поведение функции array_udiff() PHP.
     *
     * @see CoverArray::udiff()
     * @see array_udiff()
     */
    public function testUdiffWithEmptyComparisonArrays(): void
    {
        $data = [1, 2, 3];
        $diff1 = [];
        $diff2 = [];

        $callback = function ($a, $b) {
            return $a <=> $b;
        };

        $expected = array_udiff($data, $diff1, $diff2, $callback);

        $cover = new CoverArray($data);

        // arguments as array
        $this->assertSame(
            $expected,
            $cover->udiff($callback, $diff1, $diff2)->getDataAsArray()
        );

        // arguments as CoverArray
        $this->assertSame(
            $expected,
            $cover->udiff(
                $callback,
                new CoverArray($diff1),
                new CoverArray($diff2)
            )->getDataAsArray()
        );
    }
}
