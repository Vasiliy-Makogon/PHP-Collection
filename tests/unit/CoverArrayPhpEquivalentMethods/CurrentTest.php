<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class CurrentTest extends TestCase
{
    /**
     * Tests the current() method with basic array.
     *
     * This test verifies that the current() method correctly returns
     * the element at the current internal pointer position,
     * mirroring PHP's current() function behavior.
     *
     *
     * Тестирование метода current() с базовым массивом.
     *
     * Этот тест проверяет, что метод current() корректно возвращает
     * элемент в текущей позиции внутреннего указателя,
     * отражая поведение функции current() PHP.
     *
     * @see CoverArray::current()
     * @see current()
     */
    public function testCurrentWithBasicArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];
        $dataCopy = $data;

        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->current();

        // Check current element
        $this->assertSame($expected, $result);
    }

    /**
     * Tests the current() method after reset.
     *
     * This test verifies that the current() method returns
     * the first element after resetting the internal pointer,
     * mirroring PHP's current() function behavior.
     *
     *
     * Тестирование метода current() после reset.
     *
     * Этот тест проверяет, что метод current() возвращает
     * первый элемент после сброса внутреннего указателя,
     * отражая поведение функции current() PHP.
     *
     * @see CoverArray::current()
     * @see current()
     */
    public function testCurrentAfterReset(): void
    {
        $data = ['first', 'second', 'third'];
        $dataCopy = $data;

        reset($data);
        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        $cover->reset();
        $result = $cover->current();

        // Check current element is first
        $this->assertSame($expected, $result);
        $this->assertSame('first', $result);
    }

    /**
     * Tests the current() method after next.
     *
     * This test verifies that the current() method returns
     * the correct element after advancing the internal pointer,
     * mirroring PHP's current() function behavior.
     *
     *
     * Тестирование метода current() после next.
     *
     * Этот тест проверяет, что метод current() возвращает
     * корректный элемент после продвижения внутреннего указателя,
     * отражая поведение функции current() PHP.
     *
     * @see CoverArray::current()
     * @see current()
     */
    public function testCurrentAfterNext(): void
    {
        $data = [10, 20, 30];
        $dataCopy = $data;

        next($data);
        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        $cover->next();
        $result = $cover->current();

        // Check current element is second
        $this->assertSame($expected, $result);
        $this->assertSame(20, $result);
    }

    /**
     * Tests the current() method after end.
     *
     * This test verifies that the current() method returns
     * the last element after setting pointer to the end,
     * mirroring PHP's current() function behavior.
     *
     *
     * Тестирование метода current() после end.
     *
     * Этот тест проверяет, что метод current() возвращает
     * последний элемент после установки указателя в конец,
     * отражая поведение функции current() PHP.
     *
     * @see CoverArray::current()
     * @see current()
     */
    public function testCurrentAfterEnd(): void
    {
        $data = ['a', 'b', 'c'];
        $dataCopy = $data;

        end($data);
        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $result = $cover->current();

        // Check current element is last
        $this->assertSame($expected, $result);
        $this->assertSame('c', $result);
    }

    /**
     * Tests the current() method with empty array.
     *
     * This test verifies that the current() method returns false
     * for empty arrays,
     * mirroring PHP's current() function behavior.
     *
     *
     * Тестирование метода current() с пустым массивом.
     *
     * Этот тест проверяет, что метод current() возвращает false
     * для пустых массивов,
     * отражая поведение функции current() PHP.
     *
     * @see CoverArray::current()
     * @see current()
     */
    public function testCurrentWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->current();

        // Check returns false for empty array
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the current() method with single element.
     *
     * This test verifies that the current() method correctly returns
     * the only element in a single-element array,
     * mirroring PHP's current() function behavior.
     *
     *
     * Тестирование метода current() с одним элементом.
     *
     * Этот тест проверяет, что метод current() корректно возвращает
     * единственный элемент в массиве из одного элемента,
     * отражая поведение функции current() PHP.
     *
     * @see CoverArray::current()
     * @see current()
     */
    public function testCurrentWithSingleElement(): void
    {
        $data = [42];
        $dataCopy = $data;

        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->current();

        // Check current element
        $this->assertSame($expected, $result);
        $this->assertSame(42, $result);
    }

    /**
     * Tests the current() method with string keys.
     *
     * This test verifies that the current() method correctly returns
     * the current element from an associative array with string keys,
     * mirroring PHP's current() function behavior.
     *
     *
     * Тестирование метода current() со строковыми ключами.
     *
     * Этот тест проверяет, что метод current() корректно возвращает
     * текущий элемент из ассоциативного массива со строковыми ключами,
     * отражая поведение функции current() PHP.
     *
     * @see CoverArray::current()
     * @see current()
     */
    public function testCurrentWithStringKeys(): void
    {
        $data = ['first' => 'one', 'second' => 'two', 'third' => 'three'];
        $dataCopy = $data;

        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->current();

        // Check current element
        $this->assertSame($expected, $result);
        $this->assertSame('one', $result);
    }

    /**
     * Tests the current() method with numeric keys.
     *
     * This test verifies that the current() method correctly returns
     * the current element from an array with numeric keys,
     * mirroring PHP's current() function behavior.
     *
     *
     * Тестирование метода current() с числовыми ключами.
     *
     * Этот тест проверяет, что метод current() корректно возвращает
     * текущий элемент из массива с числовыми ключами,
     * отражая поведение функции current() PHP.
     *
     * @see CoverArray::current()
     * @see current()
     */
    public function testCurrentWithNumericKeys(): void
    {
        $data = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
        $dataCopy = $data;

        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->current();

        // Check current element
        $this->assertSame($expected, $result);
        $this->assertSame('ten', $result);
    }

    /**
     * Tests the current() method after iterating all elements.
     *
     * This test verifies that the current() method returns false
     * when the internal pointer is past the end of the array,
     * mirroring PHP's current() function behavior.
     *
     *
     * Тестирование метода current() после итерации всех элементов.
     *
     * Этот тест проверяет, что метод current() возвращает false,
     * когда внутренний указатель находится за концом массива,
     * отражая поведение функции current() PHP.
     *
     * @see CoverArray::current()
     * @see current()
     */
    public function testCurrentAfterIteratingAllElements(): void
    {
        $data = ['a', 'b', 'c'];
        $dataCopy = $data;

        // Move pointer past the end
        while (next($data) !== false);
        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        // Move pointer past the end
        while ($cover->next() !== false);
        $result = $cover->current();

        // Check returns false when pointer is past the end
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the current() method with mixed value types.
     *
     * This test verifies that the current() method correctly returns
     * the current element regardless of its type,
     * mirroring PHP's current() function behavior.
     *
     *
     * Тестирование метода current() со смешанными типами значений.
     *
     * Этот тест проверяет, что метод current() корректно возвращает
     * текущий элемент независимо от его типа,
     * отражая поведение функции current() PHP.
     *
     * @see CoverArray::current()
     * @see current()
     */
    public function testCurrentWithMixedValueTypes(): void
    {
        $data = [123, 'string', true, null, 45.67];
        $dataCopy = $data;

        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->current();

        // Check current element
        $this->assertSame($expected, $result);
        $this->assertSame(123, $result);
    }

    /**
     * Tests the current() method with false value.
     *
     * This test verifies that the current() method can distinguish
     * between a false value and an empty/exhausted array,
     * mirroring PHP's current() function behavior.
     *
     *
     * Тестирование метода current() со значением false.
     *
     * Этот тест проверяет, что метод current() может различить
     * значение false и пустой/исчерпанный массив,
     * отражая поведение функции current() PHP.
     *
     * @see CoverArray::current()
     * @see current()
     */
    public function testCurrentWithFalseValue(): void
    {
        $data = [false, true, false];
        $dataCopy = $data;

        $expected = current($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->current();

        // Check current element is false
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }
}
