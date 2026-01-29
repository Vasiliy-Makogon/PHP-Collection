<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class PrevTest extends TestCase
{
    /**
     * Tests the prev() method with basic array.
     *
     * This test verifies that the prev() method correctly rewinds
     * the internal pointer to the previous element and returns it,
     * mirroring PHP's prev() function behavior.
     *
     *
     * Тестирование метода prev() с базовым массивом.
     *
     * Этот тест проверяет, что метод prev() корректно перемещает
     * внутренний указатель на предыдущий элемент и возвращает его,
     * отражая поведение функции prev() PHP.
     *
     * @see CoverArray::prev()
     * @see prev()
     */
    public function testPrevWithBasicArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];
        $dataCopy = $data;

        end($data);
        $expected = prev($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $result = $cover->prev();

        // Check previous element
        $this->assertSame($expected, $result);
        $this->assertSame('banana', $result);
    }

    /**
     * Tests the prev() method rewinding pointer.
     *
     * This test verifies that the prev() method rewinds
     * the internal pointer backward,
     * mirroring PHP's prev() function behavior.
     *
     *
     * Тестирование метода prev() с перемещением указателя назад.
     *
     * Этот тест проверяет, что метод prev() перемещает
     * внутренний указатель назад,
     * отражая поведение функции prev() PHP.
     *
     * @see CoverArray::prev()
     * @see prev()
     */
    public function testPrevRewindingPointer(): void
    {
        $data = [10, 20, 30, 40];
        $dataCopy = $data;

        end($data);
        prev($data);
        $expectedValue = current($data);
        $expectedKey = key($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $cover->prev();
        $resultValue = $cover->current();
        $resultKey = $cover->key();

        // Check pointer moved backward
        $this->assertSame($expectedValue, $resultValue);
        $this->assertSame($expectedKey, $resultKey);
        $this->assertSame(30, $resultValue);
        $this->assertSame(2, $resultKey);
    }

    /**
     * Tests the prev() method with empty array.
     *
     * This test verifies that the prev() method returns false
     * for empty arrays,
     * mirroring PHP's prev() function behavior.
     *
     *
     * Тестирование метода prev() с пустым массивом.
     *
     * Этот тест проверяет, что метод prev() возвращает false
     * для пустых массивов,
     * отражая поведение функции prev() PHP.
     *
     * @see CoverArray::prev()
     * @see prev()
     */
    public function testPrevWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $expected = prev($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->prev();

        // Check returns false for empty array
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the prev() method at beginning of array.
     *
     * This test verifies that the prev() method returns false
     * when called at the beginning of the array,
     * mirroring PHP's prev() function behavior.
     *
     *
     * Тестирование метода prev() в начале массива.
     *
     * Этот тест проверяет, что метод prev() возвращает false
     * при вызове в начале массива,
     * отражая поведение функции prev() PHP.
     *
     * @see CoverArray::prev()
     * @see prev()
     */
    public function testPrevAtBeginningOfArray(): void
    {
        $data = [42];
        $dataCopy = $data;

        $expected = prev($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->prev();

        // Check returns false (no previous element)
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the prev() method with string keys.
     *
     * This test verifies that the prev() method correctly rewinds
     * to the previous element in an associative array,
     * mirroring PHP's prev() function behavior.
     *
     *
     * Тестирование метода prev() со строковыми ключами.
     *
     * Этот тест проверяет, что метод prev() корректно перемещается
     * к предыдущему элементу в ассоциативном массиве,
     * отражая поведение функции prev() PHP.
     *
     * @see CoverArray::prev()
     * @see prev()
     */
    public function testPrevWithStringKeys(): void
    {
        $data = ['first' => 'one', 'second' => 'two', 'third' => 'three'];
        $dataCopy = $data;

        end($data);
        $expected = prev($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $result = $cover->prev();

        // Check previous element
        $this->assertSame($expected, $result);
        $this->assertSame('two', $result);
    }

    /**
     * Tests the prev() method multiple times.
     *
     * This test verifies that the prev() method correctly rewinds
     * through the array on multiple calls,
     * mirroring PHP's prev() function behavior.
     *
     *
     * Тестирование метода prev() при множественных вызовах.
     *
     * Этот тест проверяет, что метод prev() корректно перемещается
     * по массиву при множественных вызовах,
     * отражая поведение функции prev() PHP.
     *
     * @see CoverArray::prev()
     * @see prev()
     */
    public function testPrevMultipleTimes(): void
    {
        $data = [1, 2, 3, 4, 5];
        $dataCopy = $data;

        end($data);
        $expected1 = prev($data);
        $expected2 = prev($data);
        $expected3 = prev($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $result1 = $cover->prev();
        $result2 = $cover->prev();
        $result3 = $cover->prev();

        // Check sequential rewinding
        $this->assertSame($expected1, $result1);
        $this->assertSame($expected2, $result2);
        $this->assertSame($expected3, $result3);
        $this->assertSame(4, $result1);
        $this->assertSame(3, $result2);
        $this->assertSame(2, $result3);
    }

    /**
     * Tests the prev() method after next.
     *
     * This test verifies that the prev() method correctly returns
     * to the first element after advancing and rewinding,
     * mirroring PHP's prev() function behavior.
     *
     *
     * Тестирование метода prev() после next.
     *
     * Этот тест проверяет, что метод prev() корректно возвращается
     * к первому элементу после продвижения и перемещения назад,
     * отражая поведение функции prev() PHP.
     *
     * @see CoverArray::prev()
     * @see prev()
     */
    public function testPrevAfterNext(): void
    {
        $data = ['first', 'second', 'third'];
        $dataCopy = $data;

        reset($data);
        next($data);
        $expected = prev($data);

        $cover = new CoverArray($dataCopy);
        $cover->reset();
        $cover->next();
        $result = $cover->prev();

        // Check prev after next
        $this->assertSame($expected, $result);
        $this->assertSame('first', $result);
    }

    /**
     * Tests the prev() method with numeric keys.
     *
     * This test verifies that the prev() method correctly rewinds
     * to the previous element with numeric keys,
     * mirroring PHP's prev() function behavior.
     *
     *
     * Тестирование метода prev() с числовыми ключами.
     *
     * Этот тест проверяет, что метод prev() корректно перемещается
     * к предыдущему элементу с числовыми ключами,
     * отражая поведение функции prev() PHP.
     *
     * @see CoverArray::prev()
     * @see prev()
     */
    public function testPrevWithNumericKeys(): void
    {
        $data = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
        $dataCopy = $data;

        end($data);
        $expected = prev($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $result = $cover->prev();

        // Check previous element
        $this->assertSame($expected, $result);
        $this->assertSame('twenty', $result);
    }

    /**
     * Tests the prev() method with mixed value types.
     *
     * This test verifies that the prev() method correctly rewinds
     * and returns elements of different types,
     * mirroring PHP's prev() function behavior.
     *
     *
     * Тестирование метода prev() со смешанными типами значений.
     *
     * Этот тест проверяет, что метод prev() корректно перемещается
     * и возвращает элементы разных типов,
     * отражая поведение функции prev() PHP.
     *
     * @see CoverArray::prev()
     * @see prev()
     */
    public function testPrevWithMixedValueTypes(): void
    {
        $data = [123, 'string', true, null, 45.67];
        $dataCopy = $data;

        end($data);
        $expected = prev($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $result = $cover->prev();

        // Check previous element
        $this->assertSame($expected, $result);
        $this->assertNull($result);
    }

    /**
     * Tests the prev() method reaching beginning of array.
     *
     * This test verifies that the prev() method returns false
     * when rewinding past the beginning of the array,
     * mirroring PHP's prev() function behavior.
     *
     *
     * Тестирование метода prev() при достижении начала массива.
     *
     * Этот тест проверяет, что метод prev() возвращает false
     * при перемещении за начало массива,
     * отражая поведение функции prev() PHP.
     *
     * @see CoverArray::prev()
     * @see prev()
     */
    public function testPrevReachingBeginningOfArray(): void
    {
        $data = ['a', 'b'];
        $dataCopy = $data;

        next($data); // Move to 'b'
        prev($data); // Move back to 'a'
        $expected = prev($data); // Try to move before beginning

        $cover = new CoverArray($dataCopy);
        $cover->next(); // Move to 'b'
        $cover->prev(); // Move back to 'a'
        $result = $cover->prev(); // Try to move before beginning

        // Check returns false at beginning
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the prev() method with false value.
     *
     * This test verifies that the prev() method can return
     * false as a valid element value (not beginning of array),
     * mirroring PHP's prev() function behavior.
     *
     *
     * Тестирование метода prev() со значением false.
     *
     * Этот тест проверяет, что метод prev() может вернуть
     * false как корректное значение элемента (не начало массива),
     * отражая поведение функции prev() PHP.
     *
     * @see CoverArray::prev()
     * @see prev()
     */
    public function testPrevWithFalseValue(): void
    {
        $data = ['start', false, 'end'];
        $dataCopy = $data;

        end($data);
        $expected = prev($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $result = $cover->prev();

        // Check previous element is false
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the prev() method with key() integration.
     *
     * This test verifies that the prev() method correctly
     * moves the pointer so that key() returns the previous key,
     * mirroring PHP's prev() function behavior.
     *
     *
     * Тестирование метода prev() с интеграцией key().
     *
     * Этот тест проверяет, что метод prev() корректно
     * перемещает указатель так, что key() возвращает предыдущий ключ,
     * отражая поведение функции prev() PHP.
     *
     * @see CoverArray::prev()
     * @see prev()
     */
    public function testPrevWithKeyIntegration(): void
    {
        $data = ['first' => 'a', 'second' => 'b', 'third' => 'c'];
        $dataCopy = $data;

        end($data);
        prev($data);
        $expectedKey = key($data);
        $expectedValue = current($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $cover->prev();
        $resultKey = $cover->key();
        $resultValue = $cover->current();

        // Check pointer is correctly positioned
        $this->assertSame($expectedKey, $resultKey);
        $this->assertSame($expectedValue, $resultValue);
        $this->assertSame('second', $resultKey);
        $this->assertSame('b', $resultValue);
    }
}
