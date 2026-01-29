<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ResetTest extends TestCase
{
    /**
     * Tests the reset() method with basic array.
     *
     * This test verifies that the reset() method correctly sets
     * the internal pointer to the first element and returns it,
     * mirroring PHP's reset() function behavior.
     *
     *
     * Тестирование метода reset() с базовым массивом.
     *
     * Этот тест проверяет, что метод reset() корректно устанавливает
     * внутренний указатель на первый элемент и возвращает его,
     * отражая поведение функции reset() PHP.
     *
     * @see CoverArray::reset()
     * @see reset()
     */
    public function testResetWithBasicArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];
        $dataCopy = $data;

        $expected = reset($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->reset();

        // Check first element
        $this->assertSame($expected, $result);
        $this->assertSame('apple', $result);
    }

    /**
     * Tests the reset() method moving pointer to first element.
     *
     * This test verifies that the reset() method moves
     * the internal pointer to the first element,
     * mirroring PHP's reset() function behavior.
     *
     *
     * Тестирование метода reset() с перемещением указателя на первый элемент.
     *
     * Этот тест проверяет, что метод reset() перемещает
     * внутренний указатель на первый элемент,
     * отражая поведение функции reset() PHP.
     *
     * @see CoverArray::reset()
     * @see reset()
     */
    public function testResetMovingPointerToFirstElement(): void
    {
        $data = [10, 20, 30, 40];
        $dataCopy = $data;

        // Move to end, then reset
        end($data);
        reset($data);
        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $cover->reset();
        $result = $cover->current();

        // Check pointer is at first element
        $this->assertSame($expected, $result);
        $this->assertSame(10, $result);
    }

    /**
     * Tests the reset() method with empty array.
     *
     * This test verifies that the reset() method returns false
     * for empty arrays,
     * mirroring PHP's reset() function behavior.
     *
     *
     * Тестирование метода reset() с пустым массивом.
     *
     * Этот тест проверяет, что метод reset() возвращает false
     * для пустых массивов,
     * отражая поведение функции reset() PHP.
     *
     * @see CoverArray::reset()
     * @see reset()
     */
    public function testResetWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $expected = reset($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->reset();

        // Check returns false for empty array
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the reset() method with single element.
     *
     * This test verifies that the reset() method correctly returns
     * the only element in a single-element array,
     * mirroring PHP's reset() function behavior.
     *
     *
     * Тестирование метода reset() с одним элементом.
     *
     * Этот тест проверяет, что метод reset() корректно возвращает
     * единственный элемент в массиве из одного элемента,
     * отражая поведение функции reset() PHP.
     *
     * @see CoverArray::reset()
     * @see reset()
     */
    public function testResetWithSingleElement(): void
    {
        $data = [42];
        $dataCopy = $data;

        $expected = reset($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->reset();

        // Check returns the only element
        $this->assertSame($expected, $result);
        $this->assertSame(42, $result);
    }

    /**
     * Tests the reset() method with string keys.
     *
     * This test verifies that the reset() method correctly returns
     * the first element from an associative array with string keys,
     * mirroring PHP's reset() function behavior.
     *
     *
     * Тестирование метода reset() со строковыми ключами.
     *
     * Этот тест проверяет, что метод reset() корректно возвращает
     * первый элемент из ассоциативного массива со строковыми ключами,
     * отражая поведение функции reset() PHP.
     *
     * @see CoverArray::reset()
     * @see reset()
     */
    public function testResetWithStringKeys(): void
    {
        $data = ['first' => 'one', 'second' => 'two', 'third' => 'three'];
        $dataCopy = $data;

        $expected = reset($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->reset();

        // Check first element
        $this->assertSame($expected, $result);
        $this->assertSame('one', $result);
    }

    /**
     * Tests the reset() method with numeric keys.
     *
     * This test verifies that the reset() method correctly returns
     * the first element from an array with numeric keys,
     * mirroring PHP's reset() function behavior.
     *
     *
     * Тестирование метода reset() с числовыми ключами.
     *
     * Этот тест проверяет, что метод reset() корректно возвращает
     * первый элемент из массива с числовыми ключами,
     * отражая поведение функции reset() PHP.
     *
     * @see CoverArray::reset()
     * @see reset()
     */
    public function testResetWithNumericKeys(): void
    {
        $data = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
        $dataCopy = $data;

        $expected = reset($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->reset();

        // Check first element
        $this->assertSame($expected, $result);
        $this->assertSame('ten', $result);
    }

    /**
     * Tests the reset() method after navigation.
     *
     * This test verifies that the reset() method returns pointer
     * to the beginning after navigation,
     * mirroring PHP's reset() function behavior.
     *
     *
     * Тестирование метода reset() после навигации.
     *
     * Этот тест проверяет, что метод reset() возвращает указатель
     * в начало после навигации,
     * отражая поведение функции reset() PHP.
     *
     * @see CoverArray::reset()
     * @see reset()
     */
    public function testResetAfterNavigation(): void
    {
        $data = ['a', 'b', 'c', 'd'];
        $dataCopy = $data;

        // Navigate through array
        next($data);
        next($data);
        $expected = reset($data);

        $cover = new CoverArray($dataCopy);
        $cover->next();
        $cover->next();
        $result = $cover->reset();

        // Check reset to first
        $this->assertSame($expected, $result);
        $this->assertSame('a', $result);
    }

    /**
     * Tests the reset() method called multiple times.
     *
     * This test verifies that the reset() method returns
     * the same first element on multiple calls,
     * mirroring PHP's reset() function behavior.
     *
     *
     * Тестирование метода reset() при множественных вызовах.
     *
     * Этот тест проверяет, что метод reset() возвращает
     * тот же первый элемент при множественных вызовах,
     * отражая поведение функции reset() PHP.
     *
     * @see CoverArray::reset()
     * @see reset()
     */
    public function testResetCalledMultipleTimes(): void
    {
        $data = [1, 2, 3];
        $dataCopy = $data;

        reset($data);
        $expected1 = current($data);
        reset($data);
        $expected2 = current($data);

        $cover = new CoverArray($dataCopy);
        $cover->reset();
        $result1 = $cover->current();
        $cover->reset();
        $result2 = $cover->current();

        // Check consistent behavior
        $this->assertSame($expected1, $result1);
        $this->assertSame($expected2, $result2);
        $this->assertSame(1, $result1);
        $this->assertSame(1, $result2);
    }

    /**
     * Tests the reset() method with mixed value types.
     *
     * This test verifies that the reset() method correctly returns
     * the first element regardless of its type,
     * mirroring PHP's reset() function behavior.
     *
     *
     * Тестирование метода reset() со смешанными типами значений.
     *
     * Этот тест проверяет, что метод reset() корректно возвращает
     * первый элемент независимо от его типа,
     * отражая поведение функции reset() PHP.
     *
     * @see CoverArray::reset()
     * @see reset()
     */
    public function testResetWithMixedValueTypes(): void
    {
        $data = [123, 'string', true, null, 45.67];
        $dataCopy = $data;

        $expected = reset($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->reset();

        // Check first element
        $this->assertSame($expected, $result);
        $this->assertSame(123, $result);
    }

    /**
     * Tests the reset() method with false value.
     *
     * This test verifies that the reset() method can return
     * false as a valid first element value,
     * mirroring PHP's reset() function behavior.
     *
     *
     * Тестирование метода reset() со значением false.
     *
     * Этот тест проверяет, что метод reset() может вернуть
     * false как корректное значение первого элемента,
     * отражая поведение функции reset() PHP.
     *
     * @see CoverArray::reset()
     * @see reset()
     */
    public function testResetWithFalseValue(): void
    {
        $data = [false, 'middle', true];
        $dataCopy = $data;

        $expected = reset($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->reset();

        // Check first element is false
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the reset() method with key() integration.
     *
     * This test verifies that the reset() method correctly
     * moves the pointer so that key() returns the first key,
     * mirroring PHP's reset() function behavior.
     *
     *
     * Тестирование метода reset() с интеграцией key().
     *
     * Этот тест проверяет, что метод reset() корректно
     * перемещает указатель так, что key() возвращает первый ключ,
     * отражая поведение функции reset() PHP.
     *
     * @see CoverArray::reset()
     * @see reset()
     */
    public function testResetWithKeyIntegration(): void
    {
        $data = ['first' => 'a', 'second' => 'b', 'third' => 'c'];
        $dataCopy = $data;

        end($data);
        reset($data);
        $expectedKey = key($data);
        $expectedValue = current($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $cover->reset();
        $resultKey = $cover->key();
        $resultValue = $cover->current();

        // Check pointer is correctly positioned
        $this->assertSame($expectedKey, $resultKey);
        $this->assertSame($expectedValue, $resultValue);
        $this->assertSame('first', $resultKey);
        $this->assertSame('a', $resultValue);
    }
}
