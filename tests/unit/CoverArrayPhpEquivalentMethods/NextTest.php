<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class NextTest extends TestCase
{
    /**
     * Tests the next() method with basic array.
     *
     * This test verifies that the next() method correctly advances
     * the internal pointer to the next element and returns it,
     * mirroring PHP's next() function behavior.
     *
     *
     * Тестирование метода next() с базовым массивом.
     *
     * Этот тест проверяет, что метод next() корректно продвигает
     * внутренний указатель на следующий элемент и возвращает его,
     * отражая поведение функции next() PHP.
     *
     * @see CoverArray::next()
     * @see next()
     */
    public function testNextWithBasicArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];
        $dataCopy = $data;

        $expected = next($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->next();

        // Check next element
        $this->assertSame($expected, $result);
        $this->assertSame('banana', $result);
    }

    /**
     * Tests the next() method advancing pointer.
     *
     * This test verifies that the next() method advances
     * the internal pointer forward,
     * mirroring PHP's next() function behavior.
     *
     *
     * Тестирование метода next() с продвижением указателя.
     *
     * Этот тест проверяет, что метод next() продвигает
     * внутренний указатель вперед,
     * отражая поведение функции next() PHP.
     *
     * @see CoverArray::next()
     * @see next()
     */
    public function testNextAdvancingPointer(): void
    {
        $data = [10, 20, 30, 40];
        $dataCopy = $data;

        reset($data);
        next($data);
        $expectedValue = current($data);
        $expectedKey = key($data);

        $cover = new CoverArray($dataCopy);
        $cover->reset();
        $cover->next();
        $resultValue = $cover->current();
        $resultKey = $cover->key();

        // Check pointer moved forward
        $this->assertSame($expectedValue, $resultValue);
        $this->assertSame($expectedKey, $resultKey);
        $this->assertSame(20, $resultValue);
        $this->assertSame(1, $resultKey);
    }

    /**
     * Tests the next() method with empty array.
     *
     * This test verifies that the next() method returns false
     * for empty arrays,
     * mirroring PHP's next() function behavior.
     *
     *
     * Тестирование метода next() с пустым массивом.
     *
     * Этот тест проверяет, что метод next() возвращает false
     * для пустых массивов,
     * отражая поведение функции next() PHP.
     *
     * @see CoverArray::next()
     * @see next()
     */
    public function testNextWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $expected = next($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->next();

        // Check returns false for empty array
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the next() method with single element.
     *
     * This test verifies that the next() method returns false
     * when called on a single-element array,
     * mirroring PHP's next() function behavior.
     *
     *
     * Тестирование метода next() с одним элементом.
     *
     * Этот тест проверяет, что метод next() возвращает false
     * при вызове на массиве из одного элемента,
     * отражая поведение функции next() PHP.
     *
     * @see CoverArray::next()
     * @see next()
     */
    public function testNextWithSingleElement(): void
    {
        $data = [42];
        $dataCopy = $data;

        $expected = next($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->next();

        // Check returns false (no next element)
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the next() method with string keys.
     *
     * This test verifies that the next() method correctly advances
     * to the next element in an associative array,
     * mirroring PHP's next() function behavior.
     *
     *
     * Тестирование метода next() со строковыми ключами.
     *
     * Этот тест проверяет, что метод next() корректно продвигается
     * к следующему элементу в ассоциативном массиве,
     * отражая поведение функции next() PHP.
     *
     * @see CoverArray::next()
     * @see next()
     */
    public function testNextWithStringKeys(): void
    {
        $data = ['first' => 'one', 'second' => 'two', 'third' => 'three'];
        $dataCopy = $data;

        $expected = next($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->next();

        // Check next element
        $this->assertSame($expected, $result);
        $this->assertSame('two', $result);
    }

    /**
     * Tests the next() method reaching end of array.
     *
     * This test verifies that the next() method returns false
     * when the pointer reaches the end of the array,
     * mirroring PHP's next() function behavior.
     *
     *
     * Тестирование метода next() при достижении конца массива.
     *
     * Этот тест проверяет, что метод next() возвращает false,
     * когда указатель достигает конца массива,
     * отражая поведение функции next() PHP.
     *
     * @see CoverArray::next()
     * @see next()
     */
    public function testNextReachingEndOfArray(): void
    {
        $data = ['a', 'b'];
        $dataCopy = $data;

        next($data); // Move to 'b'
        $expected = next($data); // Try to move past end

        $cover = new CoverArray($dataCopy);
        $cover->next(); // Move to 'b'
        $result = $cover->next(); // Try to move past end

        // Check returns false at end
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the next() method multiple times.
     *
     * This test verifies that the next() method correctly advances
     * through the array on multiple calls,
     * mirroring PHP's next() function behavior.
     *
     *
     * Тестирование метода next() при множественных вызовах.
     *
     * Этот тест проверяет, что метод next() корректно продвигается
     * по массиву при множественных вызовах,
     * отражая поведение функции next() PHP.
     *
     * @see CoverArray::next()
     * @see next()
     */
    public function testNextMultipleTimes(): void
    {
        $data = [1, 2, 3, 4, 5];
        $dataCopy = $data;

        $expected1 = next($data);
        $expected2 = next($data);
        $expected3 = next($data);

        $cover = new CoverArray($dataCopy);
        $result1 = $cover->next();
        $result2 = $cover->next();
        $result3 = $cover->next();

        // Check sequential advancement
        $this->assertSame($expected1, $result1);
        $this->assertSame($expected2, $result2);
        $this->assertSame($expected3, $result3);
        $this->assertSame(2, $result1);
        $this->assertSame(3, $result2);
        $this->assertSame(4, $result3);
    }

    /**
     * Tests the next() method after reset.
     *
     * This test verifies that the next() method correctly returns
     * the second element after reset,
     * mirroring PHP's next() function behavior.
     *
     *
     * Тестирование метода next() после reset.
     *
     * Этот тест проверяет, что метод next() корректно возвращает
     * второй элемент после reset,
     * отражая поведение функции next() PHP.
     *
     * @see CoverArray::next()
     * @see next()
     */
    public function testNextAfterReset(): void
    {
        $data = ['first', 'second', 'third'];
        $dataCopy = $data;

        // Move to end, then reset, then next
        end($data);
        reset($data);
        $expected = next($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $cover->reset();
        $result = $cover->next();

        // Check next after reset
        $this->assertSame($expected, $result);
        $this->assertSame('second', $result);
    }

    /**
     * Tests the next() method with numeric keys.
     *
     * This test verifies that the next() method correctly advances
     * to the next element with numeric keys,
     * mirroring PHP's next() function behavior.
     *
     *
     * Тестирование метода next() с числовыми ключами.
     *
     * Этот тест проверяет, что метод next() корректно продвигается
     * к следующему элементу с числовыми ключами,
     * отражая поведение функции next() PHP.
     *
     * @see CoverArray::next()
     * @see next()
     */
    public function testNextWithNumericKeys(): void
    {
        $data = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
        $dataCopy = $data;

        $expected = next($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->next();

        // Check next element
        $this->assertSame($expected, $result);
        $this->assertSame('twenty', $result);
    }

    /**
     * Tests the next() method with mixed value types.
     *
     * This test verifies that the next() method correctly advances
     * and returns elements of different types,
     * mirroring PHP's next() function behavior.
     *
     *
     * Тестирование метода next() со смешанными типами значений.
     *
     * Этот тест проверяет, что метод next() корректно продвигается
     * и возвращает элементы разных типов,
     * отражая поведение функции next() PHP.
     *
     * @see CoverArray::next()
     * @see next()
     */
    public function testNextWithMixedValueTypes(): void
    {
        $data = [123, 'string', true, null, 45.67];
        $dataCopy = $data;

        $expected = next($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->next();

        // Check next element
        $this->assertSame($expected, $result);
        $this->assertSame('string', $result);
    }

    /**
     * Tests the next() method with false value.
     *
     * This test verifies that the next() method can return
     * false as a valid element value (not end of array),
     * mirroring PHP's next() function behavior.
     *
     *
     * Тестирование метода next() со значением false.
     *
     * Этот тест проверяет, что метод next() может вернуть
     * false как корректное значение элемента (не конец массива),
     * отражая поведение функции next() PHP.
     *
     * @see CoverArray::next()
     * @see next()
     */
    public function testNextWithFalseValue(): void
    {
        $data = [true, false, 'end'];
        $dataCopy = $data;

        $expected = next($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->next();

        // Check next element is false
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }
}
