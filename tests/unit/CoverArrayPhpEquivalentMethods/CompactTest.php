<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class CompactTest extends TestCase
{
    /**
     * Tests that the compact() method throws BadMethodCallException.
     *
     * This test verifies that the compact() static method throws a BadMethodCallException
     * because compact() is a PHP function that operates on variables in the caller's scope,
     * and this cannot be replicated in a static method. The method exists to provide a clear
     * error message guiding users to use the correct approach:
     * new CoverArray(compact(...)) or CoverArray::fromArray(compact(...)).
     *
     *
     * Тестирование того, что метод compact() выбрасывает BadMethodCallException.
     *
     * Этот тест проверяет, что статический метод compact() выбрасывает BadMethodCallException,
     * потому что compact() является функцией PHP, работающей с переменными в области видимости вызывающего кода,
     * и это не может быть воспроизведено в статическом методе. Метод существует для предоставления
     * понятного сообщения об ошибке, направляющего пользователей на использование правильного подхода:
     * new CoverArray(compact(...)) или CoverArray::fromArray(compact(...)).
     *
     * @see CoverArray::compact()
     * @see CoverArray::fromArray()
     * @see compact()
     */
    public function testCompactMethodThrowsBadMethodCallException(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('CoverArray::compact() cannot be implemented due to PHP scope limitations');

        CoverArray::compact('name', 'age', 'city');
    }

    /**
     * Tests the workaround for compact() using native compact() with CoverArray constructor.
     *
     * This test verifies that users can achieve the desired compact() behavior
     * by using the workaround: new CoverArray(compact('var1', 'var2', ...)).
     * This is the recommended approach for creating a CoverArray from local variables.
     *
     *
     * Тестирование обходного решения для compact() с использованием нативной compact() и конструктора CoverArray.
     *
     * Этот тест проверяет, что пользователи могут достичь желаемого поведения compact(),
     * используя обходное решение: new CoverArray(compact('var1', 'var2', ...)).
     * Это рекомендуемый подход для создания CoverArray из локальных переменных.
     *
     * @see CoverArray::compact()
     * @see compact()
     */
    public function testCompactWorkaroundWithConstructor(): void
    {
        $name = 'John';
        $age = 30;
        $city = 'New York';

        $expected = compact('name', 'age', 'city');
        $cover = new CoverArray(compact('name', 'age', 'city'));

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the workaround for compact() using native compact() with fromArray().
     *
     * This test verifies that users can achieve the desired compact() behavior
     * by using the workaround: CoverArray::fromArray(compact('var1', 'var2', ...)).
     * This is an alternative recommended approach for creating a CoverArray from local variables.
     *
     *
     * Тестирование обходного решения для compact() с использованием нативной compact() и fromArray().
     *
     * Этот тест проверяет, что пользователи могут достичь желаемого поведения compact(),
     * используя обходное решение: CoverArray::fromArray(compact('var1', 'var2', ...)).
     * Это альтернативный рекомендуемый подход для создания CoverArray из локальных переменных.
     *
     * @see CoverArray::compact()
     * @see CoverArray::fromArray()
     * @see compact()
     */
    public function testCompactWorkaroundWithFromArray(): void
    {
        $name = 'John';
        $age = 30;
        $city = 'New York';

        $expected = compact('name', 'age', 'city');
        $cover = CoverArray::fromArray(compact('name', 'age', 'city'));

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the workaround for compact() with single variable.
     *
     * This test verifies that the compact() workaround works correctly
     * when compacting a single variable.
     *
     *
     * Тестирование обходного решения для compact() с одной переменной.
     *
     * Этот тест проверяет, что обходное решение compact() работает корректно
     * при компактировании одной переменной.
     *
     * @see CoverArray::compact()
     * @see compact()
     */
    public function testCompactWorkaroundWithSingleVariable(): void
    {
        $name = 'Alice';

        $expected = compact('name');
        $cover = new CoverArray(compact('name'));

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame('Alice', $cover->getDataAsArray()['name']);
    }

    /**
     * Tests the workaround for compact() with different data types.
     *
     * This test verifies that the compact() workaround correctly handles
     * variables of different types (string, int, float, bool, null, array).
     *
     *
     * Тестирование обходного решения для compact() с различными типами данных.
     *
     * Этот тест проверяет, что обходное решение compact() корректно обрабатывает
     * переменные различных типов (string, int, float, bool, null, array).
     *
     * @see CoverArray::compact()
     * @see compact()
     */
    public function testCompactWorkaroundWithDifferentDataTypes(): void
    {
        $string = 'text';
        $integer = 42;
        $float = 3.14;
        $boolean = true;
        $null = null;
        $array = [1, 2, 3];

        $expected = compact('string', 'integer', 'float', 'boolean', 'null', 'array');
        $cover = CoverArray::fromArray(compact('string', 'integer', 'float', 'boolean', 'null', 'array'));

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame('text', $cover->getDataAsArray()['string']);
        $this->assertSame(42, $cover->getDataAsArray()['integer']);
        $this->assertSame(3.14, $cover->getDataAsArray()['float']);
        $this->assertTrue($cover->getDataAsArray()['boolean']);
        $this->assertNull($cover->getDataAsArray()['null']);
        $this->assertSame([1, 2, 3], $cover->getDataAsArray()['array']);
    }

    /**
     * Tests the workaround for compact() with nested arrays and objects.
     *
     * This test verifies that the compact() workaround correctly handles
     * complex data structures like nested arrays and objects.
     *
     *
     * Тестирование обходного решения для compact() с вложенными массивами и объектами.
     *
     * Этот тест проверяет, что обходное решение compact() корректно обрабатывает
     * сложные структуры данных, такие как вложенные массивы и объекты.
     *
     * @see CoverArray::compact()
     * @see compact()
     */
    public function testCompactWorkaroundWithComplexStructures(): void
    {
        $user = ['name' => 'John', 'age' => 30];
        $settings = (object)['theme' => 'dark', 'notifications' => true];
        $items = [['id' => 1], ['id' => 2]];

        $expected = compact('user', 'settings', 'items');
        $cover = new CoverArray(compact('user', 'settings', 'items'));

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame(['name' => 'John', 'age' => 30], $cover->getDataAsArray()['user']);
        $this->assertEquals((object)['theme' => 'dark', 'notifications' => true], $cover->getDataAsArray()['settings']);
        $this->assertSame([['id' => 1], ['id' => 2]], $cover->getDataAsArray()['items']);
    }

    /**
     * Tests the workaround for compact() with partial variable list.
     *
     * This test verifies that the compact() workaround allows selecting
     * only specific variables from the current scope, ignoring others.
     *
     *
     * Тестирование обходного решения для compact() с частичным списком переменных.
     *
     * Этот тест проверяет, что обходное решение compact() позволяет выбирать
     * только определённые переменные из текущей области видимости, игнорируя другие.
     *
     * @see CoverArray::compact()
     * @see compact()
     */
    public function testCompactWorkaroundWithPartialVariableList(): void
    {
        $var1 = 'first';
        $var2 = 'second';
        $var3 = 'third';
        $var4 = 'fourth';

        // Compact only var1 and var3, ignoring var2 and var4
        $expected = compact('var1', 'var3');
        $cover = CoverArray::fromArray(compact('var1', 'var3'));

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertArrayHasKey('var1', $cover->getDataAsArray());
        $this->assertArrayHasKey('var3', $cover->getDataAsArray());
        $this->assertArrayNotHasKey('var2', $cover->getDataAsArray());
        $this->assertArrayNotHasKey('var4', $cover->getDataAsArray());
    }
}
