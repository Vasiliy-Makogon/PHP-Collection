<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class PosTest extends TestCase
{
    /**
     * Tests the pos() method with basic array.
     *
     * This test verifies that the pos() method correctly returns
     * the element at the current internal pointer position,
     * mirroring PHP's pos() function behavior.
     *
     *
     * Тестирование метода pos() с базовым массивом.
     *
     * Этот тест проверяет, что метод pos() корректно возвращает
     * элемент в текущей позиции внутреннего указателя,
     * отражая поведение функции pos() PHP.
     *
     * @see CoverArray::pos()
     * @see pos()
     */
    public function testPosWithBasicArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];
        $dataCopy = $data;

        $expected = pos($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->pos();

        // Check current element
        $this->assertSame($expected, $result);
    }

    /**
     * Tests the pos() method after reset.
     *
     * This test verifies that the pos() method returns
     * the first element after resetting the internal pointer,
     * mirroring PHP's pos() function behavior.
     *
     *
     * Тестирование метода pos() после reset.
     *
     * Этот тест проверяет, что метод pos() возвращает
     * первый элемент после сброса внутреннего указателя,
     * отражая поведение функции pos() PHP.
     *
     * @see CoverArray::pos()
     * @see pos()
     */
    public function testPosAfterReset(): void
    {
        $data = ['first', 'second', 'third'];
        $dataCopy = $data;

        reset($data);
        $expected = pos($data);

        $cover = new CoverArray($dataCopy);
        $cover->reset();
        $result = $cover->pos();

        // Check pos element is first
        $this->assertSame($expected, $result);
        $this->assertSame('first', $result);
    }

    /**
     * Tests the pos() method after next.
     *
     * This test verifies that the pos() method returns
     * the correct element after advancing the internal pointer,
     * mirroring PHP's pos() function behavior.
     *
     *
     * Тестирование метода pos() после next.
     *
     * Этот тест проверяет, что метод pos() возвращает
     * корректный элемент после продвижения внутреннего указателя,
     * отражая поведение функции pos() PHP.
     *
     * @see CoverArray::pos()
     * @see pos()
     */
    public function testPosAfterNext(): void
    {
        $data = [10, 20, 30];
        $dataCopy = $data;

        next($data);
        $expected = pos($data);

        $cover = new CoverArray($dataCopy);
        $cover->next();
        $result = $cover->pos();

        // Check pos element is second
        $this->assertSame($expected, $result);
        $this->assertSame(20, $result);
    }

    /**
     * Tests the pos() method after end.
     *
     * This test verifies that the pos() method returns
     * the last element after setting pointer to the end,
     * mirroring PHP's pos() function behavior.
     *
     *
     * Тестирование метода pos() после end.
     *
     * Этот тест проверяет, что метод pos() возвращает
     * последний элемент после установки указателя в конец,
     * отражая поведение функции pos() PHP.
     *
     * @see CoverArray::pos()
     * @see pos()
     */
    public function testPosAfterEnd(): void
    {
        $data = ['a', 'b', 'c'];
        $dataCopy = $data;

        end($data);
        $expected = pos($data);

        $cover = new CoverArray($dataCopy);
        $cover->end();
        $result = $cover->pos();

        // Check pos element is last
        $this->assertSame($expected, $result);
        $this->assertSame('c', $result);
    }

    /**
     * Tests the pos() method with empty array.
     *
     * This test verifies that the pos() method returns false
     * for empty arrays,
     * mirroring PHP's pos() function behavior.
     *
     *
     * Тестирование метода pos() с пустым массивом.
     *
     * Этот тест проверяет, что метод pos() возвращает false
     * для пустых массивов,
     * отражая поведение функции pos() PHP.
     *
     * @see CoverArray::pos()
     * @see pos()
     */
    public function testPosWithEmptyArray(): void
    {
        $data = [];
        $dataCopy = $data;

        $expected = pos($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->pos();

        // Check returns false for empty array
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the pos() method with single element.
     *
     * This test verifies that the pos() method correctly returns
     * the only element in a single-element array,
     * mirroring PHP's pos() function behavior.
     *
     *
     * Тестирование метода pos() с одним элементом.
     *
     * Этот тест проверяет, что метод pos() корректно возвращает
     * единственный элемент в массиве из одного элемента,
     * отражая поведение функции pos() PHP.
     *
     * @see CoverArray::pos()
     * @see pos()
     */
    public function testPosWithSingleElement(): void
    {
        $data = [42];
        $dataCopy = $data;

        $expected = pos($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->pos();

        // Check pos element
        $this->assertSame($expected, $result);
        $this->assertSame(42, $result);
    }

    /**
     * Tests the pos() method with string keys.
     *
     * This test verifies that the pos() method correctly returns
     * the current element from an associative array with string keys,
     * mirroring PHP's pos() function behavior.
     *
     *
     * Тестирование метода pos() со строковыми ключами.
     *
     * Этот тест проверяет, что метод pos() корректно возвращает
     * текущий элемент из ассоциативного массива со строковыми ключами,
     * отражая поведение функции pos() PHP.
     *
     * @see CoverArray::pos()
     * @see pos()
     */
    public function testPosWithStringKeys(): void
    {
        $data = ['first' => 'one', 'second' => 'two', 'third' => 'three'];
        $dataCopy = $data;

        $expected = pos($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->pos();

        // Check pos element
        $this->assertSame($expected, $result);
        $this->assertSame('one', $result);
    }

    /**
     * Tests the pos() method with numeric keys.
     *
     * This test verifies that the pos() method correctly returns
     * the current element from an array with numeric keys,
     * mirroring PHP's pos() function behavior.
     *
     *
     * Тестирование метода pos() с числовыми ключами.
     *
     * Этот тест проверяет, что метод pos() корректно возвращает
     * текущий элемент из массива с числовыми ключами,
     * отражая поведение функции pos() PHP.
     *
     * @see CoverArray::pos()
     * @see pos()
     */
    public function testPosWithNumericKeys(): void
    {
        $data = [10 => 'ten', 20 => 'twenty', 30 => 'thirty'];
        $dataCopy = $data;

        $expected = pos($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->pos();

        // Check pos element
        $this->assertSame($expected, $result);
        $this->assertSame('ten', $result);
    }

    /**
     * Tests the pos() method after iterating all elements.
     *
     * This test verifies that the pos() method returns false
     * when the internal pointer is past the end of the array,
     * mirroring PHP's pos() function behavior.
     *
     *
     * Тестирование метода pos() после итерации всех элементов.
     *
     * Этот тест проверяет, что метод pos() возвращает false,
     * когда внутренний указатель находится за концом массива,
     * отражая поведение функции pos() PHP.
     *
     * @see CoverArray::pos()
     * @see pos()
     */
    public function testPosAfterIteratingAllElements(): void
    {
        $data = ['a', 'b', 'c'];
        $dataCopy = $data;

        // Move pointer past the end
        while (next($data) !== false);
        $expected = pos($data);

        $cover = new CoverArray($dataCopy);
        // Move pointer past the end
        while ($cover->next() !== false);
        $result = $cover->pos();

        // Check returns false when pointer is past the end
        $this->assertSame($expected, $result);
        $this->assertFalse($result);
    }

    /**
     * Tests the pos() method with mixed value types.
     *
     * This test verifies that the pos() method correctly returns
     * the current element regardless of its type,
     * mirroring PHP's pos() function behavior.
     *
     *
     * Тестирование метода pos() со смешанными типами значений.
     *
     * Этот тест проверяет, что метод pos() корректно возвращает
     * текущий элемент независимо от его типа,
     * отражая поведение функции pos() PHP.
     *
     * @see CoverArray::pos()
     * @see pos()
     */
    public function testPosWithMixedValueTypes(): void
    {
        $data = [123, 'string', true, null, 45.67];
        $dataCopy = $data;

        $expected = pos($data);

        $cover = new CoverArray($dataCopy);
        $result = $cover->pos();

        // Check pos element
        $this->assertSame($expected, $result);
        $this->assertSame(123, $result);
    }

    /**
     * Tests the pos() method is an alias of current().
     *
     * This test verifies that the pos() method returns
     * the same result as current() method,
     * mirroring PHP's pos() function behavior as an alias.
     *
     *
     * Тестирование метода pos() как алиаса current().
     *
     * Этот тест проверяет, что метод pos() возвращает
     * тот же результат, что и метод current(),
     * отражая поведение функции pos() PHP как алиаса.
     *
     * @see CoverArray::pos()
     * @see CoverArray::current()
     * @see pos()
     */
    public function testPosIsAliasOfCurrent(): void
    {
        $data = ['a', 'b', 'c'];

        $cover = new CoverArray($data);

        // Test at different positions
        $this->assertSame($cover->current(), $cover->pos());

        $cover->next();
        $this->assertSame($cover->current(), $cover->pos());

        $cover->end();
        $this->assertSame($cover->current(), $cover->pos());

        $cover->reset();
        $this->assertSame($cover->current(), $cover->pos());
    }
}
