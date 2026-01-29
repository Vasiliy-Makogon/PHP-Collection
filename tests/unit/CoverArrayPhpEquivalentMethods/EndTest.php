<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class EndTest extends TestCase
{
    /**
     * Tests the end() method with basic array.
     *
     * This test verifies that the end() method correctly sets
     * the internal pointer to the last element and returns it,
     * mirroring PHP's end() function behavior.
     *
     *
     * Тестирование метода end() с базовым массивом.
     *
     * Этот тест проверяет, что метод end() корректно устанавливает
     * внутренний указатель на последний элемент и возвращает его,
     * отражая поведение функции end() PHP.
     *
     * @see CoverArray::end()
     * @see end()
     */
    public function testEndWithBasicArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];
        $dataCopy = $data;

        $expected = end($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->end();

        // Check last element
        $this->assertSame($expected, $result);
        $this->assertSame('cherry', $result);
    }

    /**
     * Tests the end() method moving pointer to last element.
     *
     * This test verifies that the end() method moves
     * the internal pointer to the last element,
     * mirroring PHP's end() function behavior.
     *
     *
     * Тестирование метода end() с перемещением указателя на последний элемент.
     *
     * Этот тест проверяет, что метод end() перемещает
     * внутренний указатель на последний элемент,
     * отражая поведение функции end() PHP.
     *
     * @see CoverArray::end()
     * @see end()
     */
    public function testEndMovingPointerToLastElement(): void
    {
        $data = [10, 20, 30, 40];
        $dataCopy = $data;

        // Reset to ensure pointer is at beginning
        reset($data);
        end($data);
        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        $cover->reset();
        $cover->end();
        $result = $cover->current();

        // Check pointer is at last element
        $this->assertSame($expected, $result);
        $this->assertSame(40, $result);
    }

    /**
     * Tests the end() method with empty array.
     *
     * This test verifies that the end() method returns false
     * for empty arrays,
     * mirroring PHP's end() function behavior.
     *
     *
     * Тестирование метода end() с пустым массивом.
     *
     * Этот тест проверяет, что метод end() возвращает false
     * для пустых массивов,
     * отражая поведение функции end() PHP.
     *
     * @see CoverArray::end()
     * @see end()
     */
    public function testEndWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $expected = end($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->end();

        // Check returns false for empty array
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the end() method with single element.
     *
     * This test verifies that the end() method correctly returns
     * the only element in a single-element array,
     * mirroring PHP's end() function behavior.
     *
     *
     * Тестирование метода end() с одним элементом.
     *
     * Этот тест проверяет, что метод end() корректно возвращает
     * единственный элемент в массиве из одного элемента,
     * отражая поведение функции end() PHP.
     *
     * @see CoverArray::end()
     * @see end()
     */
    public function testEndWithSingleElement(): void
    {
        $data = [42];
        $dataCopy = $data;

        $expected = end($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->end();

        // Check returns the only element
        $this->assertSame($expected, $result);
        $this->assertSame(42, $result);
    }

    /**
     * Tests the end() method with string keys.
     *
     * This test verifies that the end() method correctly returns
     * the last element from an associative array with string keys,
     * mirroring PHP's end() function behavior.
     *
     *
     * Тестирование метода end() со строковыми ключами.
     *
     * Этот тест проверяет, что метод end() корректно возвращает
     * последний элемент из ассоциативного массива со строковыми ключами,
     * отражая поведение функции end() PHP.
     *
     * @see CoverArray::end()
     * @see end()
     */
    public function testEndWithStringKeys(): void
    {
        $data = ['first' => 'one', 'second' => 'two', 'third' => 'three'];
        $dataCopy = $data;

        $expected = end($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->end();

        // Check last element
        $this->assertSame($expected, $result);
        $this->assertSame('three', $result);
    }

    /**
     * Tests the end() method with numeric keys.
     *
     * This test verifies that the end() method correctly returns
     * the last element from an array with numeric keys,
     * mirroring PHP's end() function behavior.
     *
     *
     * Тестирование метода end() с числовыми ключами.
     *
     * Этот тест проверяет, что метод end() корректно возвращает
     * последний элемент из массива с числовыми ключами,
     * отражая поведение функции end() PHP.
     *
     * @see CoverArray::end()
     * @see end()
     */
    public function testEndWithNumericKeys(): void
    {
        $data = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
        $dataCopy = $data;

        $expected = end($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->end();

        // Check last element
        $this->assertSame($expected, $result);
        $this->assertSame('thirty', $result);
    }

    /**
     * Tests the end() method after reset.
     *
     * This test verifies that the end() method moves pointer
     * from the beginning to the end,
     * mirroring PHP's end() function behavior.
     *
     *
     * Тестирование метода end() после reset.
     *
     * Этот тест проверяет, что метод end() перемещает указатель
     * из начала в конец,
     * отражая поведение функции end() PHP.
     *
     * @see CoverArray::end()
     * @see end()
     */
    public function testEndAfterReset(): void
    {
        $data = ['a', 'b', 'c', 'd'];
        $dataCopy = $data;

        reset($data);
        $expected = end($data);

        $cover = new CoverArray($dataCopy);
        $cover->reset();
        $result = $cover->end();

        // Check moved to last element
        $this->assertSame($expected, $result);
        $this->assertSame('d', $result);
    }

    /**
     * Tests the end() method called multiple times.
     *
     * This test verifies that the end() method returns
     * the same last element on multiple calls,
     * mirroring PHP's end() function behavior.
     *
     *
     * Тестирование метода end() при множественных вызовах.
     *
     * Этот тест проверяет, что метод end() возвращает
     * тот же последний элемент при множественных вызовах,
     * отражая поведение функции end() PHP.
     *
     * @see CoverArray::end()
     * @see end()
     */
    public function testEndCalledMultipleTimes(): void
    {
        $data = [1, 2, 3];
        $dataCopy = $data;

        end($data);
        $expected1 = current($data);
        end($data);
        $expected2 = current($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $result1 = $cover->current();
        $cover->end();
        $result2 = $cover->current();

        // Check consistent behavior
        $this->assertSame($expected1, $result1);
        $this->assertSame($expected2, $result2);
        $this->assertSame(3, $result1);
        $this->assertSame(3, $result2);
    }

    /**
     * Tests the end() method with mixed value types.
     *
     * This test verifies that the end() method correctly returns
     * the last element regardless of its type,
     * mirroring PHP's end() function behavior.
     *
     *
     * Тестирование метода end() со смешанными типами значений.
     *
     * Этот тест проверяет, что метод end() корректно возвращает
     * последний элемент независимо от его типа,
     * отражая поведение функции end() PHP.
     *
     * @see CoverArray::end()
     * @see end()
     */
    public function testEndWithMixedValueTypes(): void
    {
        $data = [123, 'string', true, null, 45.67];
        $dataCopy = $data;

        $expected = end($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->end();

        // Check last element
        $this->assertSame($expected, $result);
        $this->assertSame(45.67, $result);
    }

    /**
     * Tests the end() method with false value.
     *
     * This test verifies that the end() method can return
     * false as a valid last element value,
     * mirroring PHP's end() function behavior.
     *
     *
     * Тестирование метода end() со значением false.
     *
     * Этот тест проверяет, что метод end() может вернуть
     * false как корректное значение последнего элемента,
     * отражая поведение функции end() PHP.
     *
     * @see CoverArray::end()
     * @see end()
     */
    public function testEndWithFalseValue(): void
    {
        $data = [true, 'middle', false];
        $dataCopy = $data;

        $expected = end($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->end();

        // Check last element is false
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the end() method with key() integration.
     *
     * This test verifies that the end() method correctly
     * moves the pointer so that key() returns the last key,
     * mirroring PHP's end() function behavior.
     *
     *
     * Тестирование метода end() с интеграцией key().
     *
     * Этот тест проверяет, что метод end() корректно
     * перемещает указатель так, что key() возвращает последний ключ,
     * отражая поведение функции end() PHP.
     *
     * @see CoverArray::end()
     * @see end()
     */
    public function testEndWithKeyIntegration(): void
    {
        $data = ['first' => 'a', 'second' => 'b', 'third' => 'c'];
        $dataCopy = $data;

        end($data);
        $expectedKey = key($data);
        $expectedValue = current($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $resultKey = $cover->key();
        $resultValue = $cover->current();

        // Check pointer is correctly positioned
        $this->assertSame($expectedKey, $resultKey);
        $this->assertSame($expectedValue, $resultValue);
        $this->assertSame('third', $resultKey);
        $this->assertSame('c', $resultValue);
    }
}
