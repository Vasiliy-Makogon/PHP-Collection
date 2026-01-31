<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ListTest extends TestCase
{
    /**
     * Tests that the list() method throws BadMethodCallException.
     *
     * This test verifies that the list() method throws a BadMethodCallException
     * because list() is a language construct in PHP, not a function, and cannot
     * be implemented as a class method. The method exists to provide a clear
     * error message guiding users to use the correct approach:
     * list($a, $b) = $cover->getDataAsArray() or [$a, $b] = $cover->getDataAsArray().
     *
     *
     * Тестирование того, что метод list() выбрасывает BadMethodCallException.
     *
     * Этот тест проверяет, что метод list() выбрасывает BadMethodCallException,
     * потому что list() является языковой конструкцией в PHP, а не функцией,
     * и не может быть реализован как метод класса. Метод существует для предоставления
     * понятного сообщения об ошибке, направляющего пользователей на использование
     * правильного подхода: list($a, $b) = $cover->getDataAsArray() или [$a, $b] = $cover->getDataAsArray().
     *
     * @see CoverArray::list()
     * @see CoverArray::getDataAsArray()
     */
    public function testListMethodThrowsBadMethodCallException(): void
    {
        $cover = new CoverArray(['first', 'second', 'third']);

        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('CoverArray::list() cannot be implemented because list() is a language construct');

        $a = null;
        $b = null;
        $c = null;
        $cover->list($a, $b, $c);
    }

    /**
     * Tests the workaround for list() using getDataAsArray() with list syntax.
     *
     * This test verifies that users can achieve the desired list() behavior
     * by using the workaround: list($a, $b, $c) = $cover->getDataAsArray().
     * This is the recommended approach for extracting multiple values from
     * a CoverArray into separate variables.
     *
     *
     * Тестирование обходного решения для list() с использованием getDataAsArray() и синтаксиса list.
     *
     * Этот тест проверяет, что пользователи могут достичь желаемого поведения list(),
     * используя обходное решение: list($a, $b, $c) = $cover->getDataAsArray().
     * Это рекомендуемый подход для извлечения нескольких значений из CoverArray
     * в отдельные переменные.
     *
     * @see CoverArray::list()
     * @see CoverArray::getDataAsArray()
     */
    public function testListWorkaroundWithListSyntax(): void
    {
        $cover = new CoverArray(['first', 'second', 'third']);

        list($a, $b, $c) = $cover->getDataAsArray();

        $this->assertSame('first', $a);
        $this->assertSame('second', $b);
        $this->assertSame('third', $c);
    }

    /**
     * Tests the workaround for list() using getDataAsArray() with short array syntax.
     *
     * This test verifies that users can achieve the desired list() behavior
     * by using the modern short array syntax: [$a, $b, $c] = $cover->getDataAsArray().
     * This is the recommended modern approach for extracting multiple values from
     * a CoverArray into separate variables.
     *
     *
     * Тестирование обходного решения для list() с использованием getDataAsArray() и короткого синтаксиса массива.
     *
     * Этот тест проверяет, что пользователи могут достичь желаемого поведения list(),
     * используя современный короткий синтаксис массива: [$a, $b, $c] = $cover->getDataAsArray().
     * Это рекомендуемый современный подход для извлечения нескольких значений из CoverArray
     * в отдельные переменные.
     *
     * @see CoverArray::list()
     * @see CoverArray::getDataAsArray()
     */
    public function testListWorkaroundWithShortArraySyntax(): void
    {
        $cover = new CoverArray(['first', 'second', 'third']);

        [$a, $b, $c] = $cover->getDataAsArray();

        $this->assertSame('first', $a);
        $this->assertSame('second', $b);
        $this->assertSame('third', $c);
    }

    /**
     * Tests the workaround for list() with partial assignment.
     *
     * This test verifies that users can extract only some values from
     * a CoverArray, skipping others, using the list syntax with empty slots.
     *
     *
     * Тестирование обходного решения для list() с частичным присваиванием.
     *
     * Этот тест проверяет, что пользователи могут извлекать только некоторые значения
     * из CoverArray, пропуская другие, используя синтаксис list с пустыми слотами.
     *
     * @see CoverArray::list()
     * @see CoverArray::getDataAsArray()
     */
    public function testListWorkaroundWithPartialAssignment(): void
    {
        $cover = new CoverArray(['first', 'second', 'third', 'fourth']);

        [$a, , $c] = $cover->getDataAsArray();

        $this->assertSame('first', $a);
        $this->assertSame('third', $c);
    }

    /**
     * Tests the workaround for list() with associative array.
     *
     * This test verifies that users can extract values from an associative
     * CoverArray using the modern keyed list syntax.
     *
     *
     * Тестирование обходного решения для list() с ассоциативным массивом.
     *
     * Этот тест проверяет, что пользователи могут извлекать значения из ассоциативного
     * CoverArray, используя современный синтаксис list с ключами.
     *
     * @see CoverArray::list()
     * @see CoverArray::getDataAsArray()
     */
    public function testListWorkaroundWithAssociativeArray(): void
    {
        $cover = new CoverArray(['name' => 'John', 'age' => 30, 'city' => 'New York']);

        ['name' => $name, 'age' => $age, 'city' => $city] = $cover->getDataAsArray();

        $this->assertSame('John', $name);
        $this->assertSame(30, $age);
        $this->assertSame('New York', $city);
    }

    /**
     * Tests the workaround for list() with nested arrays.
     *
     * This test verifies that users can extract values from nested arrays
     * within a CoverArray using nested list syntax.
     *
     *
     * Тестирование обходного решения для list() с вложенными массивами.
     *
     * Этот тест проверяет, что пользователи могут извлекать значения из вложенных массивов
     * внутри CoverArray, используя вложенный синтаксис list.
     *
     * @see CoverArray::list()
     * @see CoverArray::getDataAsArray()
     */
    public function testListWorkaroundWithNestedArrays(): void
    {
        $cover = new CoverArray([
            ['John', 30],
            ['Jane', 25]
        ]);

        [[$name1, $age1], [$name2, $age2]] = $cover->getDataAsArray();

        $this->assertSame('John', $name1);
        $this->assertSame(30, $age1);
        $this->assertSame('Jane', $name2);
        $this->assertSame(25, $age2);
    }
}
