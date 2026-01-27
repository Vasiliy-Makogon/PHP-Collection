<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ReduceTest extends TestCase
{
    /**
     * Tests the reduce() method with sum operation.
     *
     * This test verifies that the reduce() method correctly reduces
     * an array to a single value using a sum callback,
     * mirroring PHP's array_reduce() function.
     *
     *
     * Тестирование метода reduce() с операцией суммирования.
     *
     * Этот тест проверяет, что метод reduce() корректно сводит
     * массив к единственному значению используя callback суммирования,
     * отражая функцию array_reduce() PHP.
     *
     * @see CoverArray::reduce()
     * @see array_reduce()
     */
    public function testReduceWithSumOperation(): void
    {
        $data = [1, 2, 3, 4, 5];
        $callback = fn($carry, $item) => $carry + $item;

        $expected = array_reduce($data, $callback);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->reduce($callback));
    }

    /**
     * Tests the reduce() method with initial value.
     *
     * This test verifies that the reduce() method correctly uses
     * the initial value when reducing an array,
     * mirroring PHP's array_reduce() function.
     *
     *
     * Тестирование метода reduce() с начальным значением.
     *
     * Этот тест проверяет, что метод reduce() корректно использует
     * начальное значение при свёртке массива,
     * отражая функцию array_reduce() PHP.
     *
     * @see CoverArray::reduce()
     * @see array_reduce()
     */
    public function testReduceWithInitialValue(): void
    {
        $data = [1, 2, 3, 4, 5];
        $callback = fn($carry, $item) => $carry + $item;
        $initial = 10;

        $expected = array_reduce($data, $callback, $initial);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->reduce($callback, $initial));
    }

    /**
     * Tests the reduce() method with string concatenation.
     *
     * This test verifies that the reduce() method correctly concatenates
     * strings using a callback function,
     * mirroring PHP's array_reduce() function.
     *
     *
     * Тестирование метода reduce() с конкатенацией строк.
     *
     * Этот тест проверяет, что метод reduce() корректно соединяет
     * строки используя callback-функцию,
     * отражая функцию array_reduce() PHP.
     *
     * @see CoverArray::reduce()
     * @see array_reduce()
     */
    public function testReduceWithStringConcatenation(): void
    {
        $data = ['a', 'b', 'c', 'd'];
        $callback = fn($carry, $item) => $carry . $item;
        $initial = '';

        $expected = array_reduce($data, $callback, $initial);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->reduce($callback, $initial));
    }

    /**
     * Tests the reduce() method with empty array.
     *
     * This test verifies that the reduce() method correctly returns
     * the initial value when the array is empty,
     * mirroring PHP's array_reduce() function.
     *
     *
     * Тестирование метода reduce() с пустым массивом.
     *
     * Этот тест проверяет, что метод reduce() корректно возвращает
     * начальное значение, когда массив пуст,
     * отражая функцию array_reduce() PHP.
     *
     * @see CoverArray::reduce()
     * @see array_reduce()
     */
    public function testReduceWithEmptyArray(): void
    {
        $data = [];
        $callback = fn($carry, $item) => $carry + $item;
        $initial = 100;

        $expected = array_reduce($data, $callback, $initial);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->reduce($callback, $initial));
    }

    /**
     * Tests the reduce() method with empty array and no initial value.
     *
     * This test verifies that the reduce() method correctly returns
     * null when the array is empty and no initial value is provided,
     * mirroring PHP's array_reduce() function.
     *
     *
     * Тестирование метода reduce() с пустым массивом без начального значения.
     *
     * Этот тест проверяет, что метод reduce() корректно возвращает
     * null, когда массив пуст и начальное значение не указано,
     * отражая функцию array_reduce() PHP.
     *
     * @see CoverArray::reduce()
     * @see array_reduce()
     */
    public function testReduceWithEmptyArrayAndNoInitialValue(): void
    {
        $data = [];
        $callback = fn($carry, $item) => $carry + $item;

        $expected = array_reduce($data, $callback);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->reduce($callback));
    }

    /**
     * Tests the reduce() method with product operation.
     *
     * This test verifies that the reduce() method correctly reduces
     * an array to a single value using a multiplication callback,
     * mirroring PHP's array_reduce() function.
     *
     *
     * Тестирование метода reduce() с операцией умножения.
     *
     * Этот тест проверяет, что метод reduce() корректно сводит
     * массив к единственному значению используя callback умножения,
     * отражая функцию array_reduce() PHP.
     *
     * @see CoverArray::reduce()
     * @see array_reduce()
     */
    public function testReduceWithProductOperation(): void
    {
        $data = [1, 2, 3, 4, 5];
        $callback = fn($carry, $item) => $carry * $item;
        $initial = 1;

        $expected = array_reduce($data, $callback, $initial);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->reduce($callback, $initial));
    }

    /**
     * Tests the reduce() method with associative array.
     *
     * This test verifies that the reduce() method correctly reduces
     * an associative array (values only, keys are ignored),
     * mirroring PHP's array_reduce() function.
     *
     *
     * Тестирование метода reduce() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод reduce() корректно сворачивает
     * ассоциативный массив (только значения, ключи игнорируются),
     * отражая функцию array_reduce() PHP.
     *
     * @see CoverArray::reduce()
     * @see array_reduce()
     */
    public function testReduceWithAssociativeArray(): void
    {
        $data = ['a' => 10, 'b' => 20, 'c' => 30];
        $callback = fn($carry, $item) => $carry + $item;
        $initial = 0;

        $expected = array_reduce($data, $callback, $initial);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->reduce($callback, $initial));
    }

    /**
     * Tests the reduce() method building an array as result.
     *
     * This test verifies that the reduce() method correctly builds
     * an array as the result of reduction,
     * mirroring PHP's array_reduce() function.
     *
     *
     * Тестирование метода reduce() с построением массива как результата.
     *
     * Этот тест проверяет, что метод reduce() корректно строит
     * массив как результат свёртки,
     * отражая функцию array_reduce() PHP.
     *
     * @see CoverArray::reduce()
     * @see array_reduce()
     */
    public function testReduceBuildingArrayAsResult(): void
    {
        $data = [1, 2, 3, 4, 5];
        $callback = fn($carry, $item) => [...$carry, $item * 2];
        $initial = [];

        $expected = array_reduce($data, $callback, $initial);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->reduce($callback, $initial));
    }

    /**
     * Tests the reduce() method with max value finding.
     *
     * This test verifies that the reduce() method correctly finds
     * the maximum value in an array using a callback,
     * mirroring PHP's array_reduce() function.
     *
     *
     * Тестирование метода reduce() с поиском максимального значения.
     *
     * Этот тест проверяет, что метод reduce() корректно находит
     * максимальное значение в массиве используя callback,
     * отражая функцию array_reduce() PHP.
     *
     * @see CoverArray::reduce()
     * @see array_reduce()
     */
    public function testReduceFindingMaxValue(): void
    {
        $data = [3, 1, 4, 1, 5, 9, 2, 6];
        $callback = fn($carry, $item) => $carry === null || $item > $carry ? $item : $carry;

        $expected = array_reduce($data, $callback);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->reduce($callback));
    }
}
